<?php

namespace App\Transformers\Models;

use App\Models\BookLocation;
use League\Fractal\TransformerAbstract;

class BookLocationTransformer extends TransformerAbstract
{
    public function transform(BookLocation $location)
    {
        return [
            'id'       => $location['id'],
            'status'   => $location['status'],
            'money'    => $location['money'],
            'location' => $location['location'],
        ];
    }
}
