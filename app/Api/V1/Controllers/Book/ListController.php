<?php

namespace App\Api\V1\Controllers\Book;

use App\Api\V1\Controllers\Controller;
use App\Models\BookInfo;
use App\Transformers\BookDetailTransformer;
use Dingo\Api\Http\Request;

class ListController extends Controller
{
    protected $info;

    public function __construct(BookInfo $info)
    {
        $this->info = $info;
    }

    public function getList(Request $request)
    {
        if ($request->input('type')) {
            $list = $this->info->where(
                $request->input('type') . '_id', $request->input('data')
            )->orderByDesc('id')->paginate();
        } else {
            $list = $this->info->orderByDesc('id')->paginate();
        }

        return $this->response()->paginator($list, new BookDetailTransformer());
    }
}
