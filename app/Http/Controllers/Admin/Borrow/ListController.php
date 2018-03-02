<?php

namespace App\Http\Controllers\Admin\Borrow;

use App\Http\Controllers\Admin\Controller;
use App\Models\BookBorrow;
use App\Transformers\BorrowDetailTransformer;
use Yajra\Datatables\Facades\Datatables;

class ListController extends Controller
{
    public function show()
    {
        return view('admin.borrow.list');
    }

    public function data()
    {
        return Datatables::eloquent(BookBorrow::query())->setTransformer(new BorrowDetailTransformer())->make(true);
    }
}
