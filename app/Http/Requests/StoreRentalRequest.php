<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return false;
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
            'name'            => ['required','string','max:150'],
            'phone'           => ['required','string','max:30'],
            'address'         => ['required','string'],
            'institution_id'  => ['required','exists:institutions,id'],
            'asset_id'        => ['required','exists:assets,id'],
            'photo'           => ['required','image','mimes:jpg,jpeg,png','max:2048'], // 2MB
        ];
    }
}
