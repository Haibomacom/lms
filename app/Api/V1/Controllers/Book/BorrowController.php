<?php

namespace App\Api\V1\Controllers\Book;

use App\Api\V1\Controllers\Controller;
use App\Models\BookBorrow;
use App\Models\BookLocation;
use App\Transformers\BorrowDetailTransformer;
use App\Transformers\OrderTransformer;
use Carbon\Carbon;
use Dingo\Api\Http\Request;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;
use EasyWeChat\Support\Collection;
use Tymon\JWTAuth\Facades\JWTAuth;

class BorrowController extends Controller
{
    protected $application;
    protected $location;
    protected $borrow;

    public function __construct(Application $application, BookLocation $location, BookBorrow $borrow)
    {
        $this->application = $application;
        $this->location = $location;
        $this->borrow = $borrow;
    }

    /**
     * 获取借阅列表
     *
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function getList(Request $request)
    {
        $user = JWTAuth::authenticate($request->input('token'));

        return $this->response()->paginator(
            $this->borrow->where('user_id', $user->id)->paginate(), new BorrowDetailTransformer()
        );
    }

    public function add(Request $request)
    {
        // 用户认证
        $user = JWTAuth::authenticate($request->input('token'));

        $location = $this->location->find($request->input('location'));

        if (!$location) $this->response()->errorNotFound();

        if ($this->hasUnpaid($user->id)) $this->response()->error('您当前有未支付的订单', 423);

        $book = $location->book;
        $now = Carbon::now();
        $tradeNumber = $now->timestamp . $this->fillSpace($user->id) . $this->fillSpace($location->id);

        $order = new Order([
            'body'             => $book->title,
            'detail'           => $book->title . '-' . $book->author->name_cn . '-' . $book->publish_house,
            'out_trade_no'     => $tradeNumber,
            'total_fee'        => (int)($location->money * 100),
            'spbill_create_ip' => $request->ip(),
            'time_start'       => $now->format('YmdHis'),
            'time_expire'      => $now->addMinutes(10)->format('YmdHis'),
            'notify_url'       => str_replace('add', 'notify', $request->url()),
            'trade_type'       => 'JSAPI',
            'openid'           => $user->openid,
        ]);

        $result = $this->application->payment->prepare($order);
//        if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS') {
        if (!($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS')) {
            $borrow = $this->borrow->create([
                'status'       => 1,
                'user_id'      => $user->id,
                'location_id'  => $location->id,
                'trade_number' => $tradeNumber,
                'payment'      => $this->application->payment->configForPayment($result->prepay_id),
            ]);
            return $this->response()->item($borrow, new OrderTransformer());
        } else {
            $this->response()->error('生成订单错误', 500);
        }
    }


    public function hasUnpaid($user_id)
    {
        return $this->borrow
            ->where('status', 1)
            ->where('user_id', $user_id)
            ->where('created_at', '>=', Carbon::now()->subMinutes(10))
            ->first() ? true : false;
    }


    public function handleNotify()
    {
        return $this->application->payment->handleNotify(function (Collection $notify, $successful) {
            $borrow = $this->borrow->where('trade_number', $notify->out_trade_no)->first();

            if (!$borrow || $borrow->status != 1) return true;

            $borrow->result = json_encode($notify);
            if ($successful) {
                $borrow->status = 2;
                $borrow->transaction_id = $notify->transaction_id;
                $borrow->paid_at = Carbon::now();
            } else {
                $borrow->status = 0;
            }
            $borrow->save();

            return true;
        });
    }

    public function fillSpace($string, $length = 10)
    {
        return str_pad($string, $length, '0', STR_PAD_LEFT);
    }

    public function getDetail($id)
    {
        $detail = $this->borrow->where('id', $id)->first();

        if (!$detail) $this->response()->errorNotFound();

        return $this->response()->item($detail, new BorrowDetailTransformer());
    }

    // ==========================================

    public function scan(Request $request)
    {
        $borrow = $this->validateUserRole($request);

        return $this->response()->item($borrow, new BorrowDetailTransformer());
    }

    public function control(Request $request)
    {
        $borrow = $this->validateUserRole($request);

        if ($borrow->status == 2) {
            $borrow->update([
                'status'      => 3,
                'borrowed_at' => Carbon::now(),
            ]);
        } elseif ($borrow->status == 3) {
            $borrow->update([
                'status'      => 4,
                'restored_at' => Carbon::now(),
            ]);

            $this->location->where('id', $borrow->location_id)->update(['status' => 1]);
        } else {
            $this->response()->error('当前状态不正确，请刷新后重试', 403);
        }

        return $this->response()->noContent();
    }

    public function validateUserRole(Request $request)
    {
        $arr = explode('|', $request->input('str'));

        if (count($arr) != 2) $this->response()->error('二维码错误', 422);

        $admin = JWTAuth::authenticate($request->input('token'));

        $user = JWTAuth::authenticate($arr[0]);

        if ($admin->role < 100) $this->response()->error('没有权限', 403);

        $borrow = $this->borrow->where('id', $arr[1])->first();

        if (!$borrow || $borrow->user_id != $user->id) $this->response()->errorNotFound();

        return $borrow;
    }

    public function change(Request $request)
    {
        $borrow = $this->borrow->where('id', $request->input('id'))->first();

        $this->location->where('id', $borrow->location_id)->update(['status' => 2]);

        $borrow->update([
            'status'  => 2,
            'paid_at' => Carbon::now(),
        ]);
    }
}
