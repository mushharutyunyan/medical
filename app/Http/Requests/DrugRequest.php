<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DrugRequest extends FormRequest
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
            'trade_name' => 'required|unique:drugs,trade_name',
            'trade_name_ru' => 'required|unique:drugs,trade_name_ru',
            'trade_name_en' => 'required|unique:drugs,trade_name_en',
        ];
    }
}
