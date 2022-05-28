<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
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
            'name' => 'regex:/[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/x|required|min:2|max:25',
            'lastname' => 'regex:/[a-zA-ZáéíóúÁÉÍÓÚÑñ\s]+$/x|required|min:2|max:25',
            'username' => 'required|min:3|max:20|unique:users',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:8|alpha_num',
            'identification' => 'required|min:1000000|numeric|unique:profiles',
            'genere' => 'required',
        ];
    }
}
