<?php

namespace App\Http\Requests;


class BaseStateRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required',
            'state' => 'required',
        ];  
    }
    public function messages()
    {
        return [
            "id.required" => "请选择编号",
            "state.required" => "请选择状态",
        ];
    }
}
