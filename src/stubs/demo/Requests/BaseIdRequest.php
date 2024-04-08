<?php

namespace App\Http\Requests;


class BaseIdRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required',
        ];  
    }
    public function messages()
    {
        return [
            "id.required" => "请选择编号",
        ];
    }
}
