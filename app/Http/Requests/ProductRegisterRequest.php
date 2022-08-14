<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRegisterRequest extends FormRequest
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
            'name'             => 'string|required|min:2|max:45,unique:products',
            'description'      => 'string|sometimes|nullable',
            'unit_box'         => 'required_if:conteo,2|sometimes|nullable|numeric|min:1',
            'tipo'             => 'required',
            'cod_lot'          => 'required|min:1|unique:lots',
            'quantity'         => 'required|numeric|min:1',
            'price_dollar'     => 'required|min:1|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'sell_price'       => 'required|min:1|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'expiration'       => ['required','date','after_or_equal:'.now()->format('Y-m-d')],
            'price_bs'         => 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'sales_measure_id' => 'required',
            'bar_code'         => 'required|numeric|digits:13',
        ];
    }
}
