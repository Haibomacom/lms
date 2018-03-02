<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Admin\Controller;
use App\Models\UserInfo;
use App\Transformers\UserInfoTransformer;
use Yajra\Datatables\Facades\Datatables;

class ListController extends Controller
{
    public function show()
    {
        return view('admin.user.list');
    }

    public function data()
    {
        return Datatables::eloquent(UserInfo::query())->setTransformer(new UserInfoTransformer())->make(true);
    }
}
