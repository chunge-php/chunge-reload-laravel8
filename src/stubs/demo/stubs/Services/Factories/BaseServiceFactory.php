<?php

namespace App\Services\Factories;


class BaseServiceFactory
{
    public static function make($module, $version, $box_name)
    {
        $class = "App\\Services\\{$module}\\{$version}\\{$box_name}";
        if (class_exists($class)) {
            return app($class);
        }

        throw new \Exception("Factory for {$box_name} {$module} {$version} not found.");
    }
}
