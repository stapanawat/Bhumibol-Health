<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title_th' => ['required', 'string', 'max:255'],
            'title_en' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'content_th' => ['nullable', 'string'],
            'content_en' => ['nullable', 'string'],
            'excerpt_th' => ['nullable', 'string'],
            'excerpt_en' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published,archived'],
            'is_pinned' => ['boolean'],
            'published_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:5120'], // 5MB Max
        ];
    }
}
