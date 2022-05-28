<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class PermissionEditRequest extends FormRequest
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
        $permission = Crypt::decrypt($this->route()->permission);
        return [
            'name' => 'regex:/[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/x|required|min:2|max:25|unique:permissions,name,'.$permission,
        ];
    }
}
