<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class SpecialBookingRequest extends FormRequest
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
            'full_name.*' => 'required|max:255',
            'age.*' => 'required|integer',
            'gender.*' => 'required|not_in:--Select Gender--',
            'phone.*' => [
                'required',
                'numeric',
                'digits:10',
                'regex:/^[6-9]\d{9}$/',
            ],
            'id_proof_type_id.*' => 'required|numeric|not_in:--Select Id Proof--',
            // 'id_proof_type_id.1' => 'required|numeric|not_in:--Select Id Proof--',
            'booking_date' => [
                'required',
                'date',
                'date_format:d-m-Y',
                'after_or_equal:'.now()->addDays(5)->format('d-m-Y'),
                'before_or_equal:'.now()->addDays(11)->format('d-m-Y')
            ],
            // 'id_number.*' => 'required|max:255',
            'relation_id.*' => 'required|not_in:--Select Relation--',
            'file' => 'required|file|mimes:pdf,jpg,jpeg|max:1024',
            'image' => 'required|file|mimes:jpg,jpeg|max:1024',
        ];

        foreach (request('id_proof_type_id') as $key => $value) {
            if ($value == 1) {
                $rule["id_number.".$key] = [
                    'required',
                    'numeric',
                    'regex:/^[2-9]{1}[0-9]{3}[0-9]{4}[0-9]{4}$/',
                    'digits:12'
                ];
            } else {
                $rule["id_number.".$key] = [
                    'required',
                    'string',
                    'regex:/^[A-Z]{3}[0-9]{7}$/',
                    'max:10'
                ];
            }
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
            'booking_date' => __('booking date'),
            'full_name.*' => __('full name'),
            'age.*' => __('age'),
            'gender.*' => __('gender'),
            'phone.*' => __('mobile number'),
            'id_proof_type_id.*' => __('id proof'),
            'id_number.*' => __('id number'),
            // 'id_number.1' => 'id number',
            'relation_id.*' => __('relation'),
            'image' => __('full photo'),
            'file' => __('file'),
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
            'phone.regex' => 'Please enter a valid :attribute',
        ];
    }
}
