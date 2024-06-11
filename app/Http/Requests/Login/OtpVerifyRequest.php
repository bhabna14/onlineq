<?php

namespace App\Http\Requests\Login;

use App\Models\Role;
use App\Rules\CheckOTP;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OtpVerifyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role_name' => [
                'required',
                Rule::in(Role::select('role_name')->whereIsActive(1)->get()->pluck('role_name')),
            ],
            'otp' => [
                'required',
                'numeric',
                'digits:6',
                new CheckOTP(),
            ],
            'phone' => [
                'required',
                'numeric',
                'digits:10',
                'regex:/^[6-9]\d{9}$/',
                Rule::exists('users')
                    ->where('role_id', Role::where('role_name', request('role_name'))->first()->role_id)
                    ->where('phone', request('phone'))
                    ->where('is_deleted', 0),
            ]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'phone' => __('mobile number'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.regex' => __('Invalid').' :attribute',
        ];
    }
}
