<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookFavorite extends Model
{
    protected $table = 'book_favorite';

    protected $fillable = [
        'user_id', 'book_id'
    ];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(UserInfo::class, 'user_id', 'id');
    }

    public function book()
    {
        return $this->hasOne(BookInfo::class, 'id', 'book_id');
    }
}
