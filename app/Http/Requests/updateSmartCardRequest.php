<?php

namespace App\Http\Requests;

use App\Rules\Phone;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class updateSmartCardRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'              => ['required', 'string'],
            'department'        => ['required', 'string'],
            'designation'       => ['required', 'string'],
            'pf_number'         => ['required', 'numeric', Rule::unique('nu_smart_cards', 'pf_number')->ignore($this->nu_smart_card->id)],
            'id_card_number'    => ['required', 'numeric', Rule::unique('nu_smart_cards', 'id_card_number')->ignore($this->nu_smart_card->id)],
            'mobile_number'     => ['required','numeric',new Phone(), Rule::unique('nu_smart_cards', 'mobile_number')->ignore($this->nu_smart_card->id)],
            'birth_date'        => 'required|date',
            'blood_id'          => 'required',
            'order_position'    => 'nullable|numeric',
            'emergency_contact' => ['required','numeric',new Phone(), Rule::unique('nu_smart_cards', 'emergency_contact')->ignore($this->nu_smart_card->id)],
            'present_address'   => 'required|string',
            'image'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048', 'dimensions:width=531,height=649'],
            'signature'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048', 'dimensions:width=300,height=80'],
        ];
    }
}
