<?php

namespace App\Http\Middleware;

use Closure;

class AdminIsLogin
{
    /**
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (session('admin.id')) {
            return $next($request);
        }

        return redirect('admin/login');
    }
}
