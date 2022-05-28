<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileEditRequest extends FormRequest
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
            'current_password' => 'required_with:password|sometimes|nullable|current_password:web',
            'password' => 'sometimes|nullable|min:8|alpha_num|confirmed',
            'password_confirmation' => 'sometimes|nullable|min:8|alpha_num',
        ];
    }
}
