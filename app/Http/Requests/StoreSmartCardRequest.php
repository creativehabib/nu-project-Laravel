<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSmartCardRequest extends FormRequest
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
            'name'              => ['required', 'string'],
            'department'        => ['required', 'string'],
            'designation'       => ['required', 'string'],
            'pf_number'         => 'required|string|max:255',
            'mobile_number'     => 'required|string|max:255',
            'birth_date'        => 'required|date',
            'blood_id'          => 'required',
            'emergency_contact' => 'required|string|max:255',
            'present_address'   => 'required|string',
            'image'             => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'signature'         => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ];
    }
}
