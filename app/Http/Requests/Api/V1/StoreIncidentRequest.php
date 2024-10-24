<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentRequest extends FormRequest
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
            'ref_user' => ['required', 'integer', 'exists:users,id'],
            'ref_category' => ['required', 'integer', 'exists:category,id'],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'value' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'ref_user.required'     => 'The user field is required.',
            'ref_user.integer'      => 'The user field must be an integer.',
            'ref_user.exists'       => 'The selected user must exist in the users table.',
            'ref_category.required' => 'The category field is required.',
            'ref_category.integer'  => 'The category field must be an integer.',
            'ref_category.exists'   => 'The selected category must exist in the category table.',
            'latitude.required'     => 'The latitude field is required.',
            'latitude.numeric'      => 'The latitude field must be a number.',
            'longitude.required'    => 'The longitude field is required.',
            'longitude.numeric'     => 'The longitude field must be a number.',
            'value.required'        => 'The value field is required.',
            'value.text'            => 'The value field must be text.'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'ref_user' => $this->ref_user,
            'ref_category' => $this->ref_category,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ]);
    }
}
