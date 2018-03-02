<?php

namespace App\Transformers;

use App\Models\BookInfo;
use App\Transformers\Models\BookAuthorTransformer;
use App\Transformers\Models\BookCategoryTransformer;
use App\Transformers\Models\BookLocationTransformer;
use League\Fractal\TransformerAbstract;

class BookDetailTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'author', 'category', 'location', 'author_book',
    ];

    public function transform(BookInfo $info)
    {
        return [
            'id'              => $info['id'],
            'title'           => $info['title'],
            'img'             => $info['img'],
            'isbn'            => $info['isbn'],
            'publish_house'   => $info['publish_house'],
            'publish_time'    => $info['publish_time'],
            'object'          => $info['object'],
            'intro'           => $info['intro'],
            'favorite_number' => $info['favorite_number'],
            'borrow_number'   => $info['borrow_number'],
            'view_number'     => $info['view_number'],
            'buylinks'        => json_decode($info['douban_price'], true),
        ];
    }

    public function includeCategory(BookInfo $info)
    {
        return $this->item($info->category, new BookCategoryTransformer());
    }

    public function includeAuthor(BookInfo $info)
    {
        return $this->item($info->author, new BookAuthorTransformer());
    }

    public function includeLocation(BookInfo $info)
    {
        return $this->collection($info->location, new BookLocationTransformer());
    }

    public function includeAuthorBook(BookInfo $info)
    {
        return $this->collection($info->author->book, new BookDetailTransformer());
    }
}
