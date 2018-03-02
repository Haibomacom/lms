<?php

namespace App\Http\Controllers\Admin\Book;

use App\Http\Controllers\Admin\Controller;
use App\Models\BookInfo;
use Illuminate\Http\Request;

class AddController extends Controller
{
    protected $info;

    public function __construct(BookInfo $info)
    {
        $this->info = $info;
    }

    public function show()
    {
        return view('admin.book.add');
    }

    public function add(Request $request)
    {
        $data = array_merge($request->only([
            'title', 'isbn', 'publish_house', 'publish_time', 'object', 'intro', 'douban_id',
        ]), [
            'category_id'  => 1,
            'author_id'    => 1,
            'img'          => 'https://img3.doubanio.com/lpic/s28397415.jpg',
            'douban_price' => '[]',
        ]);

        $id = $this->info->insertGetId($data);

        return redirect()->intended('admin/book/' . $id);
    }
}
