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
    protected function prepareForValidation(): void
    {
        $this->merge([
            'titulo'         => isset($this->titulo) ? trim(strip_tags($this->titulo)) : $this->titulo,
            'sinopse'        => isset($this->sinopse) ? trim(strip_tags($this->sinopse)) : $this->sinopse,
            'ano_lancamento' => isset($this->ano_lancamento) ? (int) $this->ano_lancamento : $this->ano_lancamento,
            'id_status'      => isset($this->id_status) ? (int) $this->id_status : $this->id_status,
        ]);
    }

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
