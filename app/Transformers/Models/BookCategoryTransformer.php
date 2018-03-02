<?php

namespace App\Transformers\Models;

use App\Models\BookCategory;
use League\Fractal\TransformerAbstract;

class BookCategoryTransformer extends TransformerAbstract
{
    public function transform(BookCategory $category)
    {
        return [
            'name'  => $category['name'],
            'intro' => $category['intro'],
        ];
    }
}
