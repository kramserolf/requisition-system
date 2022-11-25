<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectTo()
    {
        $role = auth()->user()->is_role;
        switch ($role) 
        {
            case '0':
                return '/admin/home';
                session()->flash('success', 'You are logged in', compact('role'));
                break;
            case '1':
                return '/vp-admin/home';
                session()->flash('success', 'You are logged in', compact('role'));
                break;
            case '2':
                return '/president/home';
                session()->flash('success', 'You are logged in', compact('role'));
                break;
        }
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => "Username or Password is Incorrect",
        ]);
    }
}
