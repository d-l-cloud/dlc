<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

    public function socialLogin($provider)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return Socialite::with(Str::lower($provider))->redirect();
    }

    public function socialCallBack(UserRepository $userRepository, $provider) {
        $socialNetwork = [
            'vkontakte' => 'vk',
            'facebook' => 'facebook',
            'microsoft' => 'microsoft',
            'github' => 'github',
            'odnoklassniki' => 'odnoklassniki',
            'yandex' => 'yandex',
        ];
        if (!Auth::check()) {
            $user = Socialite::with(Str::lower($provider))->user();
            $userInSystem = $userRepository->getUserBySocId($user, $socialNetwork[Str::lower($provider)]);
            Auth::login($userInSystem);

        }
        return redirect()->route('home');
    }
}
