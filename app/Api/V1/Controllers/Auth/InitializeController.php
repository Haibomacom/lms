<?php

namespace App\Api\V1\Controllers\Auth;

use App\Api\V1\Controllers\Controller;
use App\Models\SmsLog;
use App\Models\UserInfo;
use Carbon\Carbon;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Toplan\PhpSms\Facades\Sms;
use Tymon\JWTAuth\Facades\JWTAuth;

class InitializeController extends Controller
{
    public $template_code = 'SMS_85730017';
    public $zh_mobile = '/^(\+?0?86\-?)?((13\d|14[57]|15[^4,\D]|17[3678]|18\d)\d{8}|170[059]\d{7})$/';

    protected $info;
    protected $log;

    public function __construct(UserInfo $info, SmsLog $log)
    {
        $this->info = $info;
        $this->log = $log;
    }

    public function sendSmsCode(Request $request)
    {
        // 验证手机号是否符合要求
        $validator = Validator::make($request->all(), [
            'mobile' => ['required', 'unique:user_info', 'regex:' . $this->zh_mobile],
        ]);
        if ($validator->fails()) {
            $this->response()->error($validator->errors()->first(), 422);
        }

        $mobile = $request->input('mobile');

        if ($this->getLastCode($mobile)) {
            $this->response()->error('发送太频繁了，请稍后重试。', 423);
        }

        if ($this->getTodayCodeTimes($mobile) > 3) {
            $this->response()->error('今天发送已达上限。', 423);
        }

        // 生成短信验证码
        $code = $this->generateCode();
        // 发送短信验证码
        $result = Sms::make()->to($mobile)->template('Aliyun', $this->template_code)->data('code', $code)->send();
        // 保存验证码短信记录
        $this->recordCodeLog($mobile, $code, $result);

        if (!$result['success']) {
            $this->response()->error('服务器发生错误。', 500);
        }

        return $this->response()->created();
    }

    /**
     * 取今天成功发送验证码短信次数
     *
     * @param string $mobile
     * @return int
     */
    protected function getTodayCodeTimes($mobile)
    {
        return $this->log
            ->where('mobile', $mobile)->where('status', 1)->where('created_at', '>=', Carbon::today())
            ->count();
    }

    /**
     * 取 120 秒内可用验证码
     * 有则返回验证码，无则返回 false
     *
     * @param string $mobile
     * @param int $time
     * @return string|bool
     */
    protected function getLastCode($mobile, $time = 120)
    {
        $time = Carbon::createFromTimestamp(Carbon::now()->timestamp - $time);
        $log = $this->log->orderByDesc('created_at')
            ->where('mobile', $mobile)->where('status', 1)->where('created_at', '>=', $time)
            ->first();

        if (!$log) {
            return false;
        }
        return $log->code;
    }

    /**
     * 生成短信数字验证码
     *
     * @return int
     */
    protected function generateCode()
    {
        return rand(10000, 99999);
    }

    /**
     * 保存短信发送记录
     *
     * @param string $mobile
     * @param int $code
     * @param array $result
     */
    protected function recordCodeLog($mobile, $code, array $result)
    {
        $this->log->create([
            'mobile' => $mobile,
            'code'   => $code,
            'status' => $result['success'] ? 1 : 0,
            'result' => json_encode($result),
        ]);
    }

    /**
     * 用户初始化 / 注册
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function initialize(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile'   => ['required', 'unique:user_info', 'regex:' . $this->zh_mobile],
            'code'     => ['required', 'digits:5'],
            'password' => ['required', 'string', 'min:6', 'max:24'],
        ]);
        if ($validator->fails()) {
            $this->response()->error($validator->errors()->first(), 422);
        }

        $user = JWTAuth::authenticate($request->input('token'));

        $this->validateCode($request->input('mobile'), $request->input('code'));

        // 更新用户信息
        $user->forceFill([
            'mobile'        => $request->input('mobile'),
            'mobile_verify' => 1,
            'password'      => bcrypt($request->input('password')),
        ])->save();

        return $this->response()->created();
    }

    /**
     * 验证短信验证码是否正确
     *
     * @param $mobile
     * @param $code
     */
    protected function validateCode($mobile, $code)
    {
        $lastCode = $this->getLastCode($mobile);
        if (!$lastCode) {
            $this->response()->error('未发送验证码或验证码已过期。', 422);
        }

        if ($lastCode != $code) {
            $key = 'smsCode' . $mobile;
            // 是否有锁定缓存
            if (Cache::has($key)) {
                Cache::increment($key);
            } else {
                Cache::put($key, 1, Carbon::now()->addMinutes(2));
            }
            // 判断是否超过3次
            $times = (int)Cache::get($key);
            if ($times >= 3) {
                Cache::forget($key);
                $this->response()->error('验证码错误次数过多，请重新发送。', 423);
            } else {
                $this->response()->error('验证码错误，还有' . (3 - $times) . '次机会。', 422);
            }
        }
    }
}
