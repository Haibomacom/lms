<?php

namespace App\Transformers;

use App\Models\BookCategory;
use League\Fractal\TransformerAbstract;

class CategoryListTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'children',
    ];

    public function transform(BookCategory $category)
    {
        return [
            'id'    => $category['id'],
            'name'  => $category['name'],
            'intro' => $category['intro'],
        ];
    }

    public function includeChildren(BookCategory $category)
    {
        return $this->collection($category->children, new CategoryListTransformer());
    }
}
