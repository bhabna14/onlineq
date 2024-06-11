<?php

namespace App\Http\Requests\Admin\BlockedDate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class UpdateBlockedDateRequest extends FormRequest
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
            'blocked_date' => 'required|date_format:Y-m-d|unique:blocked_dates,blocked_date,'.Crypt::decrypt(request('id')).'|after_or_equal:'.date('Y-m-d'),
            'reason' => 'required|string|max:255',
        ];
    }
}
