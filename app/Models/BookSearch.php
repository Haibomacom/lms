<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookSearch extends Model
{
    protected $table = 'book_search';

    public $incrementing = false;

    protected $fillable = [
        'user_id', 'param',
    ];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(UserInfo::class, 'user_id', 'id');
    }
}
