<?php

namespace App\Transformers;

use App\Models\UserInfo;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserInfoTransformer extends TransformerAbstract
{
    public function transform(UserInfo $info)
    {
        return [
            'id'         => $info['id'],
            'role'       => $info['role'],
            'mobile'     => $info['mobile'],
            'token'      => JWTAuth::fromUser($info),
            'created_at' => (string)$info['created_at'],
            'updated_at' => (string)$info['updated_at'],
        ];
    }
}
