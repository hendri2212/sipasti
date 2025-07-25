<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentalRequest extends FormRequest {
    public function authorize(): bool {
        return auth()->check();
    }

    public function rules(): array {
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
