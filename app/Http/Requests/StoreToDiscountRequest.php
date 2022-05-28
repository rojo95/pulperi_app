<?php

namespace App\Http\Requests;

use App\Rules\CantidadRetirar;
use Illuminate\Foundation\Http\FormRequest;

class StoreToDiscountRequest extends FormRequest
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
            'type_to_discount_id' => 'required|numeric',
            'reason' => 'required_if:type_to_discount_id,==,3||required_if:type_to_discount_id,==,4',
            'prods' => 'required|array',
            'prods.*.id' => 'required|numeric|min:1',
            'prods.*.name' => 'required',
            'prods.*.lots' => 'required|array',
            'prods.*.lots.*.id' => 'required|numeric|gt:0',
            'prods.*.lots.*.cod' => 'required',
            'prods.*.lots.*.price' => 'required|numeric|gt:0',
            'prods.*.lots.*.divisa' => 'required|numeric|min:1',
            'prods.*.lots.*.existencia' => 'required|numeric|min:1',
            'prods.*.lots.*.expiration' => 'required|date_format:d/m/Y',
            'prods.*.lots.*.quantity' => [
                'required',
                'min:1',
                'lte:prods.*.lots.*.existencia',
            ],
            'staff' => 'required_if:type_to_discount_id,==,4',
        ];
    }
}
