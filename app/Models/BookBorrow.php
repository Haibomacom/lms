<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookBorrow extends Model
{
    protected $table = 'book_borrow';

    protected $fillable = [
        'status', 'user_id', 'location_id', 'trade_number', 'payment', 'result', 'transaction_id',
        'paid_at', 'borrowed_at', 'restored_at',
    ];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(UserInfo::class, 'user_id', 'id');
    }

    /**
     * 某个未知 BUG
     */
    public function book()
    {
        return $this->belongsTo(BookLocation::class, 'location_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(BookLocation::class, 'location_id', 'id');
    }
}
