<?php

namespace App\Http\Controllers\Admin\Book;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {

    }

    public function show()
    {
        return view('admin.book.search');
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
    }
}
