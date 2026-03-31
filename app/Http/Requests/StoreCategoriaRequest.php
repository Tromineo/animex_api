<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoriaRequest extends FormRequest
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
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name'        => isset($this->name) ? trim(strip_tags($this->name)) : $this->name,
            'slug'        => isset($this->slug) ? trim(strip_tags(strtolower($this->slug))) : $this->slug,
            'description' => isset($this->description) ? trim(strip_tags($this->description)) : $this->description,
        ]);
    }

    public function rules(): array
    {
        return [
        'name' => [
                'required',
                'string',
                'max:255'
            ],
        'slug' => [
                'required',
                'string',
                'max:255'
            ],
        'description' => [
                'nullable',
                'string'
            ],
        ];
    }
}
