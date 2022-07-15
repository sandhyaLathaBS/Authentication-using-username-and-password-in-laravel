<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
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
            $user = Auth::user();
            return view('home', compact('user'));
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
        if (auth()->user()->is_admin == 0 &&  auth()->user()->is_profilecompleted < 2 && auth()->user()->is_active == 0) {
            $validated = $request->validate([
                'fullname' => 'required',
                'email' => 'required|email:rfc,dns',
                'mobile' => 'required|digits:10',
                'dob' => 'required|date',
                'organisation' => 'required',
                'file' => 'required|image',
            ]);
            $basicdetails = new UserDetails();
            $basicdetails->user_id = auth()->user()->id;
            $basicdetails->fullname = $validated['fullname'];
            $basicdetails->email  = $validated['email'];
            $basicdetails->mobile = $validated['mobile'];
            $basicdetails->dob = $validated['dob'];
            $basicdetails->organization = $validated['organisation'];
            $basicdetails->is_active = 1;
            $fileName = md5(auth()->user()->id) . '_' . time() . '.' . $request->file->extension();
            $basicdetails->image = $fileName;
            $request->file->move(public_path('uploads'), $fileName);
            if ($basicdetails->save()) {
                $user = Auth::user();
                $user->is_profilecompleted = 2;
                $user->is_active = 1;
                $user->save();
            }
        }
        return redirect()->route('home');
    }
    public function profile_imageUpdate(Request $request)
    {
        request()->validate([
            'image'  => 'required',
        ]);

        if ($request->file('image')) {
            $fileName = md5(auth()->user()->id) . '_' . time() . '.' . $request->image->extension();
            $userdetails = Auth::user();
            $oldFileName =  $userdetails->userdetails->image;
            $userdetails->userdetails->image = $fileName;
            $request->image->move(public_path('uploads'), $fileName);
            if ($userdetails->userdetails->save()) {
                if (file_exists(public_path("uploads/$oldFileName"))) {
                    unlink(public_path("uploads/$oldFileName"));
                }
                return Response()->json([
                    "success" => true,
                    "file" => $fileName
                ]);
            }
        }
        return Response()->json([
            "success" => false,
            "file" => ''
        ]);
    }
}