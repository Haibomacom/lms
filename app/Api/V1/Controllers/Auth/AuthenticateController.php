<?php

namespace App\Api\V1\Controllers\Auth;

use App\Api\V1\Controllers\Controller;
use App\Models\UserInfo;
use App\Transformers\UserInfoTransformer;
use Dingo\Api\Http\Request;
use EasyWeChat\Foundation\Application;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateController extends Controller
{
    protected $application;
    protected $info;

    public function __construct(Application $application, UserInfo $info)
    {
        $this->application = $application;
        $this->info = $info;
    }

    /**
     * 用户认证
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function authenticate(Request $request)
    {
        $result = $this->getSessionKey($request->input('code'));

        // 匹配用户 openid，不存在即创建，返回 UserInfo 表的对象
        $user = $this->info->firstOrCreate(['openid' => $result['openid']]);

        // 将 session_key 保存至数据库
        $user->update(['session' => $result['session_key']]);

        // 如果有 unionid 就保存至数据库
        if (isset($result['unionid'])) $user->update(['unionid' => $result['unionid']]);

        return $this->response()->item($user, new UserInfoTransformer());
    }

    /**
     * 获取用户的 openid 和 session_key
     * 获取失败直接抛出异常
     *
     * @param $code
     * @return mixed
     */
    public function getSessionKey($code)
    {
        return json_decode($this->application->mini_program->sns->getSessionKey($code), true);
    }

    /**
     * 检查用户的 Token 是否合法
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function checkToken(Request $request)
    {
        $token = $request->input('token');

        if (!$token) $this->response()->error('请先登录', 401);

        try {
            JWTAuth::authenticate($token);
        } catch (TokenExpiredException $e) {
            $this->response()->error('登录超时，请重新登录', 401);
        } catch (JWTException $e) {
            $this->response()->error('请先登录', 401);
        }

        return $this->response()->noContent();
    }
}
