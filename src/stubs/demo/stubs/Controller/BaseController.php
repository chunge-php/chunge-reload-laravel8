<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Factories\BaseServiceFactory;
use App\Services\Factories\BaseRequestFactory;

class BaseController extends Controller
{

    /**
     * 列表
     */
    public function BaseIndex(Request $request)
    {
        $route_info = $this->getRouteInfo($request->route()->getName());
        $module_name =  isset($route_info[0]) ? $route_info[0] : '';
        $class_name =  isset($route_info[3]) ? $route_info[3] : '';
        $formRequest = $this->baseRequestVerify($module_name, $class_name);
        try {
            $all = $formRequest->all();
            $fun_name = $route_info[4];
            $LogicModel = $this->baseRequestForm($route_info);
            $list = $LogicModel->$fun_name($all, $request->limit, $request->offset);
            success(array_merge($list, ['page' => $request->page, 'limit' => $request->limit, 'offset' => $request->offset]));
        } catch (\Exception $e) {
            error(errorCode()::ERROR_CATCH, __('api.error_catch') . $e->getMessage());
        }
    }
    /**
     * 详情
     */
    public function BaseShow(Request $request)
    {
        $route_info = $this->getRouteInfo($request->route()->getName());
        $module_name =  isset($route_info[0]) ? $route_info[0] : '';
        $formRequest =  $this->baseRequestVerify($module_name, 'BaseIdRequest');
        try {
            $all = $formRequest->all();
            $fun_name = $route_info[4];
            $LogicModel = $this->baseRequestForm($route_info);
            $info = $LogicModel->$fun_name($all);
            success($info);
        } catch (\Exception $e) {
            // 处理验证失败情况
            error(errorCode()::ERROR_CATCH, __('api.error_catch') . $e->getMessage());
        }
    }
    /**
     * 创建
     */
    public function BaseCreate(Request $request)
    {
        $route_info = $this->getRouteInfo($request->route()->getName());
        $module_name =  isset($route_info[0]) ? $route_info[0] : '';
        $class_name =  isset($route_info[3]) ? $route_info[3] : '';
        $formRequest = $this->baseRequestVerify($module_name, $class_name);
        try {
            $all = $formRequest->all();
            $LogicModel = $this->baseRequestForm($route_info);
            $id = $request->input('id') ?? 0;
            if ($id > 0) {
                $LogicModel->update($id, $all);
            } else {
                $LogicModel->create($all);
            }
        } catch (\Exception $e) {
            error(errorCode()::ERROR_CATCH, __('api.error_catch') . $e->getMessage());
        }
    }
    /**
     * 删除
     */
    public function BaseDestroy(Request $request)
    {
        $route_info = $this->getRouteInfo($request->route()->getName());
        $module_name =  isset($route_info[0]) ? $route_info[0] : '';
        $formRequest =  $this->baseRequestVerify($module_name, 'BaseIdRequest');
        try {
            $all = $formRequest->all();
            $LogicModel = $this->baseRequestForm($route_info);
            $info = $LogicModel->destroy($all);
            success($info);
        } catch (\Exception $e) {
            error(errorCode()::ERROR_CATCH, __('api.error_catch') . $e->getMessage());
        }
    }
    /**
     * 字段验证
     * @param string $module_name 模块名称
     * @param string $class_name 类名称
     * @return Request
     */
    private function baseRequestVerify($module_name, $class_name, Request $request = null)
    {
        if (empty($module_name) || empty($class_name)) {
            error(errorCode()::ERROR, __('api.error'));
        }
        return BaseRequestFactory::make(ucfirst($module_name), ucfirst($class_name), $request);
    }
    private function baseRequestForm($route_info)
    {
        $module_name = ucfirst($route_info[0]);
        $version_name = $route_info[1];
        $box_name = ucfirst($route_info[3]);
        return BaseServiceFactory::make($module_name, $version_name, $box_name);
    }
    /**
     * 获取路由信息
     */
    private function getRouteInfo($name): array
    {
        $arr = explode('.', $name);
        return $arr;
    }
}
