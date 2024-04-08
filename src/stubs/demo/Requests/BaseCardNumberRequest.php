<?php

namespace App\Http\Requests;


class BaseCardNumberRequest extends BaseRequest
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
            'card_number' => 'required|string',
        ];  
    }
    public function messages()
    {
        return [
            "card_number.required" => "请输入卡号",
            "card_number.string" => "卡号输入格式有误",
        ];
    }
}
