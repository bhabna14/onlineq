<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        try {
            if(auth()->check() && in_array(auth()->user()?->role->role_name, ['Super Admin','Admin'], true)) {
                return redirect()->route('admin.bookings');
            }
            return view('admin.login');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Login page submission
     *
     * @param Request $request
     * @return string
     */
    public function loginPost(LoginRequest $request)
    {
        try {
            if (Auth::attempt($request->validated())) {
                return redirect()->route('admin.bookings');
            }
            return back()->withInput($request->input())->withErrors(['password' => 'Incorrect password']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Logout functionality
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        try {
            // session()->flush();
            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();

            return redirect()->route('admin.login');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
