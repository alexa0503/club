<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressPost extends FormRequest
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
            'name' => 'required|max:20',
            'detail' => 'required|max:60',
            'mobile' => ['required','regex:/^1\d{10}/'],
            'telephone' => 'max:20',
            //'email' => 'email',
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
            'name.required'=>'请输入收货人姓名',
            'name.max'=>'收货人姓名不能超过20个字符',
            'detail.required'=>'请输入地址',
            'mobile.required'=>'请输入手机号码',
            'mobile.regex'=>'手机号格式不正确',
            'telephone.max'=>'固定不能超过20位',
            //'email.email'=>'必须是有效的邮箱地址',
        ];
    }
}
