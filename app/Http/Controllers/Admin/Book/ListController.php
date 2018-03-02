<?php

namespace App\Http\Controllers\Admin\Book;

use App\Http\Controllers\Admin\Controller;
use App\Models\BookInfo;
use App\Transformers\BookDetailTransformer;
use Yajra\Datatables\Facades\Datatables;

class ListController extends Controller
{
    public function show()
    {
        return view('admin.book.list');
    }

    public function data()
    {
        return Datatables::eloquent(BookInfo::query())->setTransformer(new BookDetailTransformer())->make(true);
    }
}
