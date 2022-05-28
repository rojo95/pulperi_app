<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleStoreRequest extends FormRequest
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
            'prods' => 'required|array',
            'prods.*.id' => 'required|numeric|min:1',
            'prods.*.sale' => 'required|numeric',
            // 'prods.*.sale' => 'required|numeric|min:1',
            'prods.*.sale_measure' => 'required|numeric|min:1',
            'prods.*.price' => 'required|array',
            'prods.*.price.*.price' => 'required|numeric',
            'prods.*.price.*.divisa' => 'required|numeric',
            'prods.*.price.*.selected' => 'required',
            'client_id' => 'required|numeric',
            'transaction_type' => 'required|numeric|min:1',
            'payment_method_id' => 'required_if:transaction_type,1|sometimes|nullable|array|min:1',
        ];
    }
}
