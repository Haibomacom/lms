<?php

namespace App\Models;

use DiDom\Document;
use Illuminate\Database\Eloquent\Model;

class BookInfo extends Model
{
    protected $table = 'book_info';

    protected $fillable = [
        'category_id', 'title', 'author_id', 'img', 'isbn',
        'publish_house', 'publish_time', 'object', 'intro', 'douban_id', 'douban_price',
        'favorite_number', 'borrow_number', 'view_number',
    ];

    protected $hidden = [];

    public function category()
    {
        return $this->belongsTo(BookCategory::class, 'category_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(BookAuthor::class, 'author_id', 'id');
    }

    public function location()
    {
        return $this->hasMany(BookLocation::class, 'book_id', 'id');
    }

    /**
     * 豆瓣爬虫，爬取各大平台图书价格
     *
     * @param int $id
     * @param string $douban_id
     */
    public function updateDouban($id, $douban_id)
    {
        $price = [];

        $html = new Document();
        $html->loadHtmlFile('https://book.douban.com/subject/' . $douban_id . '/buylinks?sortby=price');
        $table = $html->find('#buylink-table');
        if ($table) {
            foreach ($table[0]->find('tr') as $tr) {
                $td = $tr->find('td');
                if ($td) {
                    $price = array_merge($price, [[
                        'shop'  => str_replace(["\n", " "], "", $td[1]->text()),
                        'url'   => $td[1]->find('a')[0]->getAttribute('href'),
                        'price' => str_replace(["\n", " "], "", $td[2]->text()),
//                        'other' => str_replace(["\n", " "], "", $td[4]->text()),
                    ]]);
                }
            }
        }

        $this->where('id', $id)->update(['douban_price' => json_encode($price)]);
    }
}
