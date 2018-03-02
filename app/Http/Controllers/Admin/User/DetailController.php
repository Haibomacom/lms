<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\Controller;
use App\Models\UserInfo;
use EasyWeChat\Foundation\Application;

class DetailController extends Controller
{
    protected $info;
    protected $application;

    public function __construct(UserInfo $info, Application $application)
    {
        $this->info = $info;
        $this->application = $application;
    }

    public function show($id)
    {
        $id = (int)$id;

        $user = $this->info->where('id', $id)->firstOrFail();

        return view('admin.user.detail', ['user' => $user]);
    }
}
