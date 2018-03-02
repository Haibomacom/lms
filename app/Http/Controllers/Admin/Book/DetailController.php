<?php

namespace App\Http\Controllers\Admin\Book;

use App\Http\Controllers\Admin\Controller;
use App\Models\BookInfo;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    protected $info;

    public function __construct(BookInfo $info)
    {
        $this->info = $info;
    }

    public function show($id)
    {
        $book = $this->info->where('id', $id)->firstOrFail();

        return view('admin.book.detail', ['book' => $book]);
    }

    public function edit(Request $request)
    {
        $this->info->where('id', $request->input('id'))->update($request->only([
            'title', 'isbn', 'publish_house', 'publish_time', 'object', 'intro',
        ]));

        return redirect()->intended('admin/book/' . $request->id);
    }
}
