<?php

namespace App\Http\Controllers\Admin;

class IndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function show()
    {
        return redirect('admin/dashboard');
    }
}
