<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorized via middleware
    }

    public function rules(): array
    {
        return [
            'name_th' => ['required', 'string', 'max:255'],
            'name_en' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:50'],
            'is_active' => ['boolean'],
        ];
    }
}
