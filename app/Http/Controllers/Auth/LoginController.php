<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function form()
    {
        return view('login');
    }

    public function login(LoginRequest $request)
    {       
        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password]))
        {
            return redirect()->route('admin.show');
        } else {
            return redirect()->route('login-form')->with('message', 'Email hoặc Mật khẩu không chính xác');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login-form');
    }

}
