<?php

namespace App\Transformers;

use App\Models\BookBorrow;
use League\Fractal\TransformerAbstract;

class OrderTransformer extends TransformerAbstract
{
    public function transform(BookBorrow $borrow)
    {
        $payment = json_decode($borrow['payment'], true);
        return [
            'timeStamp' => $payment['timeStamp'],
            'nonceStr'  => $payment['nonceStr'],
            'package'   => $payment['package'],
            'signType'  => $payment['signType'],
            'paySign'   => $payment['paySign'],
        ];
    }
}
