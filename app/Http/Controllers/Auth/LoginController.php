<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle an authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // Check if the user's status is not equal to 1
        if ($user->status != 1) {
            // Log the user out and redirect back to login with a general error message
            auth()->logout();

            return redirect('/login')->with('error', 'Your account is not active. Please <a href="' . route('support') . '"><u>contact support</u></a>.');
        }

        // If the status is active, proceed with the default redirect
        return redirect()->intended($this->redirectPath());
    }

    public function showLoginForm()
    {
        return view('auth.login'); // Make sure the view name matches the actual view file
    }
}

