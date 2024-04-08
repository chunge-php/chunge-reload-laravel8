<?php

namespace App\Http\Requests;


class BaseUpNameRequest extends BaseRequest
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

    public function rules()
    {
        return [
            'name' => 'required|string|max:90',
        ];  
    }
    public function messages()
    {
        return [
            "name.required" => "名称不能为空",
            "name.string" => "名称填写类型有误",
            "name.max" => "名称最大长度不能超过90位数",
        ];
    }
}
