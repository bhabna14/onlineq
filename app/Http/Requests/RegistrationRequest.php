<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
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
        $rule = [
            'user_first_name' => 'required|string|max:255',
            'user_last_name' => 'required|string|max:255',
            // 'email' => [
            //     'required',
            //     'string',
            //     'email:rfc,dns',
            //     Rule::unique('users')->where(function ($query) {
            //         $query->where('role_id', Role::where('role_name', 'User')->first()->role_id);
            //     }),
            //     'max:255'
            // ],
            'phone' => [
                'required',
                'numeric',
                'regex:/^[6-9]\d{9}$/',
                'digits:10',
                // Rule::unique('users')->where(function ($query) {
                //     $query->where('role_id', Role::where('role_name', 'User')->first()->role_id);
                // }),
            ],
            'user_gender' => 'required|string|not_in:--Select Gender--',
            'user_dob' => 'required|date',
            'id_proof_type_id' => 'required|numeric',
            'user_address' => 'required|string|max:500',
        ];

        if (request('id_proof_type_id') == 1) {
            $rule['user_id_number'] = [
                'required',
                'numeric',
                'regex:/^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$/',
                'digits:12'
            ];
        } else {
            $rule['user_id_number'] = [
                'required',
                'string',
                'regex:/^[A-Z]{3}[0-9]{7}$/',
                'max:10'
            ];
        }

        return $rule;
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
            'id_proof_type_id' => __('id proof type'),
            'user_id_number' => __('id card number'),
            'user_first_name' => __('first name'),
            'user_last_name' => __('last name'),
            'user_gender' => __('gender'),
            'user_dob' => __('date of birth'),
            'user_address' => __('address'),
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
            'user_id_number.regex' => __('Invalid').' :attribute',
        ];
    }
}
