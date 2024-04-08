<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\BaseRequest;

class UpUserRequest extends BaseRequest
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
     * 用户管理
     * @return array
     */
    public function rules()
    {
        return [
            'user_name' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "名称不能为空",
            "name.string" => "名称格式不对",

            "user_name.required" => "用户名不能为空",
            "role_type.required" => "请选择用户类型",
        ];
    }
}
