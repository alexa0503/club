<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemPost extends FormRequest
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
            'name' => 'required|max:120',
            'price' => 'required|numeric',
            'point' => 'required|numeric',
            'quantities' => 'required',
            'colors' => 'required',
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
            'name.required' => '请输入产品名称',
            'price.required'=>'请输入市场价格',
            'price.numeric'=>'价格必须是数字',
            'point.required'=>'请输入风迷币',
            'point.numeric'=>'风迷币必须是数字',
            'quantities.required'=>'请输入库存',
            'colors.required'=>'请输入产品颜色',
        ];
    }
}
