<?php
namespace App\Services\Factories;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BaseRequestFactory
{
    public static function make($module, $MyClass, Request $request = null)
    {
        $className = "App\\Http\\Requests\\{$module}\\{$MyClass}Request";
        if (!class_exists($className)) {
            $className = "App\\Http\\Requests\\{$MyClass}";
            if (!class_exists($className)) {
                throw new \Exception("Request class {$className} does not exist.");
            }
        }

        try {
            $formRequest = app()->make($className);

            // 确保 $request 不为 null
            $currentRequest = $request ?: request();

            $formRequest->setContainer(app())
                ->setRedirector(app()->make('redirect'))
                ->initialize(
                    $currentRequest->query(),
                    $currentRequest->request->all(), // 获取请求体数据
                    $currentRequest->attributes->all(),
                    $currentRequest->cookies->all(),
                    $currentRequest->files->all(),
                    $currentRequest->server->all(),
                    $currentRequest->getContent()
                );

            // 手动调用 validate 方法触发验证
            $formRequest->validateResolved();

            // 不需要手动调用 fails 方法，如果验证失败，将自动抛出 ValidationException
            return $formRequest;

        } catch (ValidationException $e) {
            // 处理验证失败情况
            throw $e;
        } 
    }
}
