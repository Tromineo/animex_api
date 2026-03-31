<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreComentarioRequest extends FormRequest
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
            'usuario_id' => isset($this->usuario_id) ? (int) $this->usuario_id : $this->usuario_id,
            'anime_id'   => isset($this->anime_id) ? (int) $this->anime_id : $this->anime_id,
            'texto'      => isset($this->texto) ? trim(strip_tags($this->texto)) : $this->texto,
        ]);
    }

    public function rules(): array
    {
        return [
            'usuario_id' => 'required|exists:usuarios,id',
            'anime_id' => 'required|exists:animes,id',
            'texto' => 'required|string|max:1000',
        ];
    }
}
