<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function login(Request $request)
    {
        $input = $request->all();
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
        if (auth()->attempt(array('username' => $input['username'], 'password' => $input['password']))) {
            if (auth()->user()->is_admin == 1) {
                return redirect()->route('admin.home');
            } else {
                //first time login
                if (auth()->user()->is_admin == 0 && auth()->user()->is_profilecompleted < 2 && auth()->user()->is_active == 0) {
                    return redirect()->route('profile.editView');
                } elseif (auth()->user()->is_admin == 0 && auth()->user()->last_logged_at != null && auth()->user()->is_profilecompleted == 2 && auth()->user()->is_active == 1) {
                    //profile completed and valid users
                    $user = Auth::user();
                    $user->last_logged_at = date("Y-m-d H:i:s");
                    $user->save();
                    return redirect()->route('home');
                } else {
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Your profile is not vaild.');
                }
            }
        } else {
            return redirect()->route('login')->with('error', 'Username And Password Are Wrong.');
        }
    }
}