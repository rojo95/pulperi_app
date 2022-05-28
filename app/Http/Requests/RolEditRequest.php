<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class RolEditRequest extends FormRequest
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
        $role = Crypt::decrypt($this->route('role'));
        return [
            'name' => 'regex:/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/x|required|min:2|max:25,unique:roles,id,'.$role,
            'guard_name' => 'unique:permissions,'.$role,
        ];
    }
}
