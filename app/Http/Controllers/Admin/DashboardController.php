<?php

namespace App\Http\Controllers\Admin;

use App\Models\BookBorrow;
use App\Models\UserInfo;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $info;
    protected $borrow;

    public function __construct(UserInfo $info, BookBorrow $borrow)
    {
        $this->info = $info;
        $this->borrow = $borrow;
    }

    public function show()
    {
        return view('admin.dashboard', [
            'data' => [
                'newUser'      => $this->info->where('created_at', '>=', Carbon::today())->count(),
                'activeUser'   => $this->info->where('updated_at', '>=', Carbon::today())->count(),
                'newBorrow'    => $this->borrow->where('created_at', '>=', Carbon::today())->count(),
                'finishBorrow' => $this->borrow->where('paid_at', '>=', Carbon::today())->count(),
            ],
        ]);
    }
}
