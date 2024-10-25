<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
            'name' =>  [ 'required', 'string' ],
            'email' => [ 'required', 'email' ],
            'document' => [ 'required','unique:users,document', 'min:8', 'max:14' ],
            'password' => [ 'required', 'string', 'min:8', 'max:16', Password::min(8)->mixedCase()->letters()->numbers()->symbols() ]
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'O campo nome é obrigatório.',
            'name.string'       => 'O campo nome deve ser uma string.',
            'email.required'    => 'O campo email é obrigatório.',
            'email.email'       => 'O campo email deve ser um email válido, contendo @, domínio e extensão. Ex: abigail@test.com.',
            'document.required' => 'O campo documento é obrigatório.',
            'document'          => 'O campo documento deve conter apenas números, sem pontos ou traços, deve ser único e ter no mínimo 8 e no máximo 14 caracteres.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.string'   => 'O campo senha deve ser uma string.',
            'password.min'      => 'O campo senha deve ter pelo menos 8 caracteres.',
            'password.max'      => 'O campo senha deve ter no máximo 16 caracteres.',
            'password' => 'O campo senha deve conter letras maiúsculas e minúsculas, números e símbolos.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'name' => $this->name,
            'email' => $this->email,
            'document' => $this->document,
            'password' => $this->password
        ]);
    }
}
