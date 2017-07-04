<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlockPost extends FormRequest
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
            'title' => 'required|max:120',
            'name' => 'required|max:120',
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
            'title.required' => '请输入标题',
            'name.required' => '必须选择区块类别',
        ];
    }
}
