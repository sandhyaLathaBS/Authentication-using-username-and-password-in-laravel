<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->is_admin == 0 && auth()->user()->last_logged_at != null && auth()->user()->is_profilecompleted == 2 && auth()->user()->is_active == 1) {
            return view('home');
        } else {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your profile is not vaild.');
        }
    }
    public function profile_updateView()
    {
        if (auth()->user()->is_admin == 0 &&  auth()->user()->is_profilecompleted < 2 && auth()->user()->is_active == 0) {
            $user = Auth::user();
            $user->is_profilecompleted = 1;
            $user->last_logged_at = date("Y-m-d H:i:s");
            $user->save();
            return view('profile.edit', compact('user'));
        } else {
            return redirect()->route('home');
        }
    }
    public function profile_updateAction(Request $request)
    {
        dd($request->all());
    }
}