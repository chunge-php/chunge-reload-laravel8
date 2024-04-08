<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class UpYqgPhoneRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     * 洋钱罐
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
        ];  
    }
    public function messages()
    {
        return [
            "name.required" => "名称不能为空",
            "name.string" => "名称格式不对",
        ];
    }
}
