<?php

namespace App\Http\Controllers;

use App\Http\Requests\Login\OtpGenerateRequest;
use App\Http\Requests\Login\OtpVerifyRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        try {
            if(auth()->check() && !in_array(auth()->user()?->role->role_name, ['Super Admin','Admin'], true)) {
                return redirect()->route('booking.special');
            }
            return view('login');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * OTP generate function for login
     *
     * @param OtpGenerateRequest $request
     * @return void
     */
    public function otpGenerate(OtpGenerateRequest $request)
    {
        try {

            $role_id = Role::where($request->safe(['role_name']))->firstOrFail()->role_id;

            $user = User::where(['role_id' => $role_id, 'phone' => $request->phone])->first();

            if (!$user) {
                User::create([
                    'role_id' => $role_id,
                    'phone' => $request->phone
                ]);
            }

            do {
                $otp = random_int(100000, 999999);
            } while (User::where(['role_id' => $role_id, 'otp' => $otp])->first());

            $otp = 123456;

            $update = User::where(['role_id' => $role_id, 'phone' => $request->phone])->update(['otp' => $otp]);

            $errData = [
                "message" => "The given data was invalid.",
                "errors" => ['phone' => ['There was some error in generating OTP. Please try again after sometime.']]
            ];

            if($update) {

                // $response = $this->sendOtpApi($request->phone,$otp);

                // if (json_decode($response)->type == 'success') {
                    return response()->json([
                        'status' => 'success',
                        'call' => 'enterOtp',
                        'info' => $request->validated(),
                    ], 200);
                // }
            }
            return response()->json($errData, 422);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * OTP verification function after entering of OTP
     *
     * @param OtpVerifyRequest $request
     * @return void
     */
    public function otpVerify(OtpVerifyRequest $request)
    {
        try {

            $role_id = Role::where($request->safe(['role_name']))->firstOrFail()->role_id;

            $user = User::where([
                'role_id' => $role_id,
                'is_deleted' => 0,
                'is_active' => 1,
                'phone' => $request->safe()->only('phone'),
            ])->firstOrFail();

            $user->update(['otp' => Null]);

            if (!$user->email) {
                session()->put('unregistered_user', $user);
                return response()->json([
                    'status' => 'not registered',
                    'url' => route('guidelines'),
                ], 200);
            }

            auth()->login($user);

            // session()->flash('SuccessToastr', "Login successful");
            return 'success';
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

            $lang = session()->get('lang_locale');

            auth()->logout();
            session()->invalidate();
            session()->regenerateToken();

            session()->put('lang_locale', $lang);

            return redirect()->route('login');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
