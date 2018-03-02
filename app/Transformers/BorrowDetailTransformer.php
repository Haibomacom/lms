<?php

namespace App\Transformers;

use App\Models\BookBorrow;
use App\Transformers\Models\BookLocationTransformer;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class BorrowDetailTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'location', 'book',
    ];

    protected $availableIncludes = [
        'user',
    ];

    public function transform(BookBorrow $borrow)
    {
        return [
            'id'     => $borrow->id,
            'status' => $this->filterStatus($borrow['status']),
            'origin' => [
                'created_at'  => (string)$borrow['created_at'],
                'paid_at'     => $borrow['paid_at'] ?: 0,
                'borrowed_at' => $borrow['borrowed_at'] ?: 0,
                'restored_at' => $borrow['restored_at'] ?: 0,
            ],
            'format' => [
                'created_at'  => $borrow['created_at'] ? Carbon::parse($borrow['created_at'])->diffForHumans() : null,
                'paid_at'     => $borrow['paid_at'] ? Carbon::parse($borrow['paid_at'])->diffForHumans() : null,
                'borrowed_at' => $borrow['borrowed_at'] ? Carbon::parse($borrow['borrowed_at'])->diffForHumans() : null,
                'restored_at' => $borrow['restored_at'] ? Carbon::parse($borrow['restored_at'])->diffForHumans() : null,
            ],
        ];
    }

    public function includeLocation(BookBorrow $borrow)
    {
        return $this->item($borrow->location, new BookLocationTransformer());
    }

    public function includeBook(BookBorrow $borrow)
    {
        return $this->item($borrow->location->book, new BookDetailTransformer());
    }

    public function includeUser(BookBorrow $borrow)
    {
        return $this->item($borrow->user, new UserInfoTransformer());
    }

    public function filterStatus($status)
    {
        switch ($status) {
            case 0:
                return '取消借阅';
            case 1:
                return '等待付款';
            case 2:
                return '付款成功';
            case 3:
                return '正在借阅';
            case 4:
                return '借阅完成';
            default:
                return '错误状态';
        }
    }
}
