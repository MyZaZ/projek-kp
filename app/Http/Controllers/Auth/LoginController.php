<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login_sneat');
    }

    public function showLoginFormWali()
    {
        return view('auth.login_sneat_wali');
    }

    public function authenticated(Request $request, $user)
    {
    if ($user->akses == 'operator' || $user->akses == 'admin') {
        return redirect()->route('operator.beranda');
    } elseif ($user->akses == 'wali') {
        return redirect()->route('wali.beranda');
    } else {
        $this->guard()->logout();
        flash('Anda tidak memiliki hak akses')->error();
        return redirect()->route('login');
    }
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
{
    $errors = [$this->username() => trans('auth.failed')];

    // Check if email is incorrect
    if ($request->filled('email')) {
        $errors[$this->username()] = trans('auth.failed');
    }

    // Check if password is incorrect
    if ($request->filled('password')) {
        $errors['password'] = trans('auth.password');
    }

    throw ValidationException::withMessages($errors);
}




}
