<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    public function adminHome()
    {
        $users = User::all()->whereNotIn('id', 1);
        return view('admin.home', compact('users'));
    }
    public function userActiveStatus(Request $request)
    {
        $uuid = base64_decode($request->uuid);
        $user__ = User::findorFail($uuid);
        $activeStatus = $user__->is_active;
        $user__->is_active = ($activeStatus == 1 && $user__->is_profilecompleted == 2) ? 0 : 1;
        $user__->save();
        if (isset($user__->userdetails->is_active)) {
            $user__->userdetails->is_active = ($activeStatus == 1 && $user__->is_profilecompleted == 2) == 1 ? 0 : 1;
            $user__->userdetails->save();
        }
        return Response()->json([
            "success" => true,
            "activestatus" => $user__->is_active
        ]);
    }
}