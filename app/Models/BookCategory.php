<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    protected $table = 'book_category';

    public $timestamps = false;

    protected $fillable = [
        'parent_id', 'name', 'intro',
    ];

    protected $hidden = [];

    public function parent()
    {
        return $this->belongsTo(BookCategory::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(BookCategory::class, 'parent_id', 'id');
    }
}
