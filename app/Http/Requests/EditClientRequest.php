<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditClientRequest extends FormRequest
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
            'ced'      => [
                'required',
                'numeric',
                'regex:/^(\d{7,13})$/',
            ],
            'name'     => 'required|regex:/^[A-Za-z ]+/i|min:3',
            'lastname' => 'required|regex:/^[A-Za-z ]+/i|min:3',
            'address'  => 'nullable|min:3'
        ];
    }
}
