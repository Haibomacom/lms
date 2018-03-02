<?php

namespace App\Api\V1\Controllers\Book;

use App\Api\V1\Controllers\Controller;
use App\Models\BookInfo;
use App\Transformers\BookDetailTransformer;

class SearchController extends Controller
{
    protected $info;

    public function __construct(BookInfo $info)
    {
        $this->info = $info;
    }

    public function search()
    {
        $keywords = request()->input('search');

        $xs = new \XS(config_path('book.ini'));
        $search = $xs->getSearch();
        $search->setQuery($keywords);
        $docs = $search->search();
        $search->close();

        $book_id = [];
        foreach ($docs as $doc) {
            $book_id = array_merge($book_id, [(int)$doc->id]);
        }
        $books = $this->info->whereIn('id', $book_id)->get();

        return $this->response()->collection($books, new BookDetailTransformer());
    }
}
