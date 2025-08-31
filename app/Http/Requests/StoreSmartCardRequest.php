<?php

namespace App\Http\Requests;

use App\Rules\Phone;
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
            'department_id'     => ['required', 'integer', 'exists:departments,id'],
            'designation_id'    => ['required', 'integer', 'exists:designations,id'],
            'pf_number'         => 'required|numeric|unique:nu_smart_cards,pf_number',
            'id_card_number'    => 'nullable|numeric',
            'mobile_number'     => ['required','numeric',new Phone(),'unique:nu_smart_cards,mobile_number'],
            'birth_date'        => 'required|date',
            'blood_id'          => 'required',
            'emergency_contact' => ['required','numeric', new Phone(),'unique:nu_smart_cards,emergency_contact'],
            'present_address'   => 'required|string',
            'image'             => 'required|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:width=531,height=649',
            'signature'         => 'required|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:width=300,height=80'
        ];
    }
}
