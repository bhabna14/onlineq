<?php

namespace App\Http\Requests\Booking;

use App\Rules\CheckBooking;
use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'full_name.*' => 'required|max:255',
            'phone.*' => [
                'required',
                'numeric',
                'digits:10',
                'regex:/^[6-9]\d{9}$/',
            ],
            'gender.*' => 'required|not_in:--Select Gender--',
            'age.*' => 'required|integer',
            'booking_date' => [
                'required',
                'date',
                'date_format:d-m-Y',
                'after_or_equal:'.now()->addDays(5)->format('d-m-Y'),
                'before_or_equal:'.now()->addDays(11)->format('d-m-Y')
            ],
            'id_proof.*' => 'required|not_in:--Select Id Proof--',
            'id_number.*' => 'required|max:255',
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
            'full_name.*' => 'full name',
            'phone.*' => 'mobile number',
            'gender.*' => 'gender',
            'age.*' => 'age',
            'booking_date' => 'booking date',
            'id_proof.*' => 'id proof',
            'id_number.*' => 'id number',
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
