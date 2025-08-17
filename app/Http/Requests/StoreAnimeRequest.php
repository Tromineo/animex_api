<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnimeRequest extends FormRequest
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
            // Cada chave é o nome do campo
            'titulo' => [
                'required',
                'string',
                'max:255'
            ],
            'genero' => [
                'required',
                'string',
                'max:255'
            ],
            'resumo' => [
                'nullable',
                'string',
                'max:255'
            ],
            'episodios' => [
                'nullable',
                'integer'
            ],
            'lancamento' => [
                'nullable',
                'date'
            ],
        ];
    }
}
