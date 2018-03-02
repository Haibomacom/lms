<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookLocation extends Model
{
    protected $table = 'book_location';

    protected $fillable = [
        'book_id', 'status', 'money', 'location',
    ];

    protected $hidden = [];

    public function book()
    {
        return $this->belongsTo(BookInfo::class, 'book_id', 'id');
    }
}
