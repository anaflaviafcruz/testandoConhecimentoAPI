<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'document' => 'required|unique:users|max:14',
            'password' => 'requerid|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.requerid' => "Nome é obrigatório.",
            'email.requerid' => "E-mail é obrigatório.",
            'password.requerid' => "Senha é obrigatório.",
            'email.unique' => 'Já existe esse e-mail cadastrado em nosso banco.',
            'document.unique' => 'Já existe esse cpf cadastrado em nosso banco.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(['errors' => $errors], 422)
        );
    }
}
