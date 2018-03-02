<?php

namespace App\Api\V1\Controllers\Book;

use App\Api\V1\Controllers\Controller;
use App\Models\BookCategory;
use App\Transformers\CategoryListTransformer;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(BookCategory $category)
    {
        $this->category = $category;
    }

    public function getAll()
    {
        return $this->response()->collection($this->category->get(), new CategoryListTransformer());
    }
}
