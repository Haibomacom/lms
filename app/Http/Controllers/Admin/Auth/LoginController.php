<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Admin\Controller;
use App\Models\Admin;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $admin;
    protected $maxAttempts = 5;
    protected $decayMinutes = 1;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
    }

    public function show()
    {
        return view('admin.auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $this->validator($request);

        if ($this->hasTooManyAttempts($request)) {
            $seconds = $this->limiter()->availableIn($this->throttleKey($request));

            return $this->responseError($request, trans('auth.throttle', ['seconds' => $seconds]));
        }

        if ($admin = $this->attempt($request)) {
            $this->success($request, $admin);

            return redirect()->intended('admin/dashboard');
        }

        $this->incrementAttempts($request);

        return $this->responseError($request, trans('auth.failed'));
    }

    /**
     * @param Request $request
     * @param string $errors
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function responseError(Request $request, $errors)
    {
        return redirect()->back()
            ->withInput($request->only(['username', 'password']))
            ->withErrors(['username' => $errors]);
    }

    protected function success(Request $request, $admin)
    {
        $this->clearAttempts($request);

        $request->session()->regenerate();

        $request->session()->put([
            'admin.id'       => $admin->id,
            'admin.username' => $admin->username,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    protected function validator(Request $request)
    {
        $this->validate($request, [
            'username' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'max:20'],
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Model|false
     */
    protected function attempt(Request $request)
    {
        $admin = $this->admin->where('username', $request->input('username'))->first();

        if ($admin && Hash::check($request->input('password'), $admin->password)) {
            return $admin;
        }

        return false;
    }

    /**
     * @return \Illuminate\Cache\RateLimiter
     */
    protected function limiter()
    {
        return app(RateLimiter::class);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        return $request->ip();
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    protected function incrementAttempts(Request $request)
    {
        $this->limiter()->hit($this->throttleKey($request));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function hasTooManyAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts($this->throttleKey($request), $this->maxAttempts, $this->decayMinutes);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    protected function clearAttempts(Request $request)
    {
        $this->limiter()->clear($this->throttleKey($request));
    }
}
