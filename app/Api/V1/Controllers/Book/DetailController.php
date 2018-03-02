<?php

namespace App\Api\V1\Controllers\Book;

use App\Api\V1\Controllers\Controller;
use App\Models\BookInfo;
use App\Models\BookLocation;
use App\Transformers\BookDetailTransformer;
use App\Transformers\Models\BookLocationTransformer;

class DetailController extends Controller
{
    protected $info;
    protected $location;

    public function __construct(BookInfo $info, BookLocation $location)
    {
        $this->info = $info;
        $this->location = $location;
    }

    public function getDetail($id)
    {
        $book = $this->info->find($id);

        return $this->responseBookDetail($book);
    }

    public function getDetailByIsbn($isbn)
    {
        $book = $this->info->where('isbn', $isbn)->first();

        return $this->responseBookDetail($book);
    }

    /**
     * 返回图书详细信息
     *
     * @param BookInfo $book
     * @return \Dingo\Api\Http\Response
     */
    public function responseBookDetail(BookInfo $book)
    {
        if (!$book) $this->response()->errorNotFound();

        // 图书上次更新时间大于 24 小时更新豆瓣数据
        if ($book->douban_id && (!$book->updated_at || $book->updated_at->diffInHours() >= 24)) {
            $book->updateDouban($book->id, $book->douban_id);
        }

        $book = $this->info->find($book->id);

        return $this->response()->item($book, new BookDetailTransformer());
    }

    public function getLocationDetail($id)
    {
        $location = $this->location->find($id);

        if (!$location) $this->response()->errorNotFound();

        return $this->response()->item($location, new BookLocationTransformer());
    }
}
