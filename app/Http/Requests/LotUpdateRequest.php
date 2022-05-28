<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Crypt;

class LotUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make th
     *
     *
     *
     * is request.
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
        $lot = Crypt::decrypt($this->route('id'));
        return [
            'cod_lot' => 'required|alpha_num|min:1|unique:lots,cod_lot,'.$lot,
            'quantity' => 'required|numeric|min:1',
            'expiration' => ['required','date'],
        ];
    }
}
