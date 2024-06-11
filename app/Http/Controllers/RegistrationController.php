<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\IdProofType;
use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            if (session()->has('unregistered_user')) {
                $unregistered_user = session()->pull('unregistered_user');

                $data['user'] = User::wherePhone($unregistered_user->phone)->first();
                $data['id_proof']= IdProofType::where(['is_active'=>1,'is_deleted'=>0])->get();

                return view('register',$data);
            } elseif (auth()->check()) {
                return redirect()->route('booking.special');
            }
            return redirect()->route('login')->with('InfoToastr', __("Please try again after sometime."));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegistrationRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::where('user_id', $request->user_id)->first();
            $user->email = $request->email;
            $user->save();

            UserMeta::create([
                'user_first_name' => $request->user_first_name,
                'user_last_name' => $request->user_last_name,
                'user_dob' => $request->user_dob,
                'user_gender' => $request->user_gender,
                'id_proof_type_id' => $request->id_proof_type_id,
                'user_id_number' => $request->user_id_number,
                'user_address' => $request->user_address,
                'user_id' => $user->user_id,
            ]);

            auth()->login($user);

            DB::commit();
            session()->flash('SuccessToastr', 'Registered Successfully.');
            return 'success';
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function guidelines(Request $request)
    {
        try {
            if (session()->has('unregistered_user')) {
                return view('guidelines');
            }
            return back()->with('InfoToastr', __("Please try again after sometime."));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
