<?php

namespace App\Transformers;

use App\Models\BookFavorite;
use League\Fractal\TransformerAbstract;

class FavoriteTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'book'
    ];

    public function transform(BookFavorite $favorite)
    {
        return [];
    }

    public function includeBook(BookFavorite $favorite)
    {
        return $this->item($favorite->book, new BookDetailTransformer());
    }
}
