<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderPost extends FormRequest
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
            'quantity' => 'required|numeric|min:1|max:100',
            'inventory' => 'required',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'quantity.required' => '请至少购买一件商品哦~',
            'quantity.numeric' => '请至少购买一件商品哦',
            'quantity.min' => '请至少购买一件商品哦',
            'quantity.max' => '购买的商品不能超过100件',
            'inventory.required'=>'请选择商品属性'
        ];
    }
}
