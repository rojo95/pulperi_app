<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class ProductUpdateRequest extends FormRequest
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
        $product = Crypt::decrypt($this->route('inventory'));
        return [
            'name'             => 'string|required|min:2|max:45|unique:products,name,'.$product,
            'description'      => 'string|sometimes|nullable',
            'unit_box'         => 'sometimes|nullable|numeric|min:1',
            'tipo'             => 'required',
            'sales_measure_id' => 'required',
        ];
    }
}
