<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_name' => 'required|min:3|string',
            'first_name' => 'min:3|string',
            'last_name' => 'string',
            'primary_email' => 'string|required|min:6|unique:client_contacts',
            'phone_number' => 'string|min:10',
        ];
    }
}
