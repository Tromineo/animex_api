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
                'required',
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

    public function messages(): array
    {
        return [
            'titulo.required'          => 'O campo título é obrigatório.',
            'titulo.string'            => 'O campo título deve ser um texto.',
            'titulo.max'               => 'O campo título não pode ter mais de 255 caracteres.',

            'sinopse.required'         => 'O campo sinopse é obrigatório.',
            'sinopse.string'           => 'O campo sinopse deve ser um texto.',
            'sinopse.max'              => 'O campo sinopse não pode ter mais de 255 caracteres.',

            'ano_lancamento.required'  => 'O campo ano de lançamento é obrigatório.',
            'ano_lancamento.integer'   => 'O campo ano de lançamento deve ser um número inteiro.',
            'ano_lancamento.min'       => 'O campo ano de lançamento deve ser no mínimo 1900.',
            'ano_lancamento.max'       => 'O campo ano de lançamento não pode ser maior que o ano atual.',

            'url_imagem.required'      => 'A imagem do anime é obrigatória.',
            'url_imagem.image'         => 'O arquivo enviado deve ser uma imagem válida.',
            'url_imagem.mimes'         => 'A imagem deve estar nos formatos: jpeg, png, jpg, gif ou webp.',
            'url_imagem.max'           => 'A imagem não pode ser maior que 5MB.',

            'id_status.required'       => 'O campo status é obrigatório.',
            'id_status.integer'        => 'O campo status deve ser um número inteiro válido.',
        ];
    }
}
