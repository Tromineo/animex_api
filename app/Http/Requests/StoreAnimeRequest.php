<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnimeRequest extends FormRequest
{
    /**
     * Determina se o usuário está autorizado a fazer esta requisição.
     */
    public function authorize(): bool
    {

        return true;
    }

    /**
     * Retorna regras de validação para criação de um anime
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
            'titulo' => [
                'required',
                'string',
                'max:255'
            ],
            'sinopse' => [
                'required',
                'string',
                'max:255'
            ],
            'ano_lancamento' => [
                'required',
                'integer',
                'min:1900',
                'max:' . date('Y')
            ],
            'url_imagem' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif,webp',
                'max:5120', // 5MB
            ],
            'id_status' => [
                'required',
                'integer'
            ],
        ];
    }
}
