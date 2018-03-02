<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookAuthor extends Model
{
    protected $table = 'book_author';

    protected $fillable = [
        'name_cn', 'name_en', 'gender', 'intro', 'birth_time', 'death_time', 'birthplace',
    ];

    protected $hidden = [];

    public function book()
    {
        return $this->hasMany(BookInfo::class, 'author_id', 'id');
    }
}
