<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

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
     * 
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
    }

    public function showLoginForm()
    {
        return view('abstract.login');
    }
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended(route('dashboard.home'));
        }
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function show_dash()
    {
        return view('admin.pages.dashboard');
    }

    public function authGithubRedirect()
    {
        return Socialite::driver('github')->scopes(['read:user', 'public_repo'])->redirect();
    }
    public function authGithubCallback()
    {
        $user = Socialite::driver('github')->user();
        $userCreated = User::firstOrCreate(
            ['provider_id' => $user->getId()],
            [
                'provider_name' => 'github',
                'name' => $user->name,
                'email' => $user->email,
            ]
        );
        Auth::login($userCreated);
        return redirect()->route('dashboard.home');
    }
}
