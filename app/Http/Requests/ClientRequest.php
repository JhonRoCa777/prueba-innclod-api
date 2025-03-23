<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

class ClientRequest extends FormRequest
{
    public function failedValidation($validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fullname'  => 'required|string|max:60',
            'document'  => 'required|string|min:8|max:15|unique:clients,document,' . $this->id,
            'email'     => 'required|email|max:60|unique:clients,email,' . $this->id,
        ];
    }

    public function messages(): array
    {
        return [
            'fullname.required' => 'Campo obligatorio.',
            'fullname.string'   => 'Campo debe ser texto.',
            'fullname.max'      => 'Máximo 60 caracteres.',

            'document.required' => 'Campo obligatorio.',
            'document.string'   => 'Campo debe ser texto.',
            'document.min'      => 'Mínimo 8 caracteres.',
            'document.max'      => 'Máximo 15 caracteres.',
            'document.unique'   => 'Registro ya existente.',

            'email.required' => 'Campo obligatorio.',
            'email.email'    => 'Campo debe ser correo válido.',
            'email.max'      => 'Máximo 60 caracteres.',
            'email.unique'   => 'Registro ya existente.',
        ];
    }
}
