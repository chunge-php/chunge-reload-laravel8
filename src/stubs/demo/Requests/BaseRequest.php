<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $error = $validator->errors()->all();
        $message = isset($error[0]) ? $error[0] : 'error';
        $res =  response()->json(['status' => 1001, 'message' => $message, 'data' => (object)[], 'attache' =>[] , 'token' => session('token', '')]);
        throw new HttpResponseException($res);
    }
}
