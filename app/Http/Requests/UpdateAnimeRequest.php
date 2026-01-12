<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnimeRequest extends FormRequest
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
            'titulo' => 'nullable|string|max:255',
            'sinopse' => 'nullable|string|max:1000',
            'ano_lancamento' => 'nullable|integer|min:1900|max:' . date('Y'),
            'url_imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'id_status' => 'nullable|integer',
        ];
    }
}
