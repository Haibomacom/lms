<?php

namespace App\Transformers\Models;

use App\Models\BookAuthor;
use League\Fractal\TransformerAbstract;

class BookAuthorTransformer extends TransformerAbstract
{
    public function transform(BookAuthor $author)
    {
        return [
            'id'         => $author['id'],
            'name_cn'    => $author['name_cn'],
            'name_en'    => $author['name_en'],
            'gender'     => $this->filterGender($author['gender']),
            'intro'      => $author['intro'],
            'birth_time' => $author['birth_time'],
            'death_time' => $author['death_time'],
            'birthplace' => $author['birthplace'],
        ];
    }

    public function filterGender($gender)
    {
        switch ($gender) {
            case 1:
                return '男';
            case 2:
                return '女';
            default:
                return '未知';
        }
    }
}
