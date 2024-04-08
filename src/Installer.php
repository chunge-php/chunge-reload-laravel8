<?php

namespace Chunge\ReloadLaravel8;

class Installer
{
    private $commands_path = '\app\Console\Commands';
    private $Middleware_path = '\app\Http\Middleware';
    private $MyClass_path = '\app\MyClass';
    private $Support_path  = '\app\Support';
    private $Config_path  = '\config';
    private $routes_path  = '\routes';
    private $logic_path  = 'app\Logic';

    public  function copyFiles()
    {
        echo '开始执行安装ces';
        
        $this->createCommands();
        $this->CreateMiddleware();
        $this->CreateMyClass();
        $this->CreateSupport();
        $this->updateKernel();
        $this->CreateRouteServiceProvider();
        $this->CreateRoutes();
        $this->CreateConfig();
        $this->CopyStubFile();
        $this->CopyRequestsFile();
        $this->CreateEnv();
        $this->CopyControllerDir();
        $this->CopyServicesDir();
        $this->CreateDatabase();
        $this->CreateModels();
        $this->CreateLogicBase();
        $this->CreateLogicFileBase();
        //创建安装记录标识
        $this->CreateInstallJosinFile();
        echo "执行成功 successfully!" . PHP_EOL;
        echo "开始卸载 chunge/laravel !" . PHP_EOL;
        $path =  'composer remove chunge/laravel';
        exec($path);
        echo "卸载成功 chunge/laravel !" . PHP_EOL;
        sleep(4);
        $this->CreateComposer();
    }
    public function CopyServicesDir()
    {
        $sourcePath = __DIR__ . '/stubs/demo/stubs/Controller'; // 指定要复制的文件夹路径
        $project_path = $this->getBasePath();
        $destinationPath = $project_path . '/app/Http/Controllers';
        // 执行文件复制操作
        $this->recursiveCopy($sourcePath, $destinationPath);
    }
    public function CopyControllerDir()
    {
        $sourcePath = __DIR__ . '/stubs/demo/stubs/Services'; // 指定要复制的文件夹路径
        $project_path = $this->getBasePath();
        $destinationPath = $project_path . '/app/Services';
        // 执行文件复制操作
        $this->recursiveCopy($sourcePath, $destinationPath);
    }

    //创建安装标识文件
    private function CreateInstallJosinFile()
    {
        $content = file_get_contents(__DIR__ . '\stubs\InstallDemo.stub');
        $project_path = $this->getBasePath();
        $logic_file = $this->Config_path . '\install.php';
        $file_dir_path =  $project_path . $logic_file;
        $this->overwriteFileContent($file_dir_path, $content);
    }

    //创建artisan自定义命令
    private  function createCommands()
    {
        //创建数据库初始化命令
        $this->createInitTable();
        //创建增删改业务接口
        $this->CreateLogic();
        //创建清除缓存命令
        $this->CacheLog();
        //创建逻辑层命令文件
        $this->Logic();
        //创建错误状态码
        $this->ErrCode();
        //创建多语言文件
        $this->CreateLangApi();
    }
    //创建中间件
    private function CreateMiddleware()
    {
        //创建api中间键
        $this->CreateApiToken();
        //创建Admin中间键
        $this->CreateAdminToken();
        $this->CreatePage();
    }
    //-----------------------------命令层------------------------------------//

    //创建数据库初始化命令
    private function createInitTable()
    {
        //createInitTableDemo.stub
        $file_name = 'InitTable';
        $demo_name = 'createInitTableDemo';
        $message = '创建数据库初始化文件命令';
        $this->BaseCommands($file_name, $demo_name, $message);
    }

    //创建增删改业务接口
    private function CreateLogic()
    {
        $file_name = 'CreateLogic';
        $demo_name = 'CreateLogicDemo';
        $message = '创建增删改业务接口文件命令';
        $this->BaseCommands($file_name, $demo_name, $message);
    }
    //创建清除缓存命令
    private function CacheLog()
    {
        $file_name = 'CacheLog';
        $demo_name = 'CacheLogDemo';
        $message = '创建清除缓存命令文件';
        $this->BaseCommands($file_name, $demo_name, $message);
    }
    //创建逻辑层命令文件
    private function Logic()
    {
        $file_name = 'Logic';
        $demo_name = 'LogicDemo';
        $message = '创建逻辑层命令文件';
        $this->BaseCommands($file_name, $demo_name, $message);
    }
    private function CreateLogicBase()
    {
        $file_name = 'Logic';
        $demo_name = 'BaseLogicDemo';
        $message = '创建公用逻辑层文件';
        $this->BaseLogic($file_name, $demo_name, $message);
    }
    private function CreateLogicFileBase()
    {
        $file_name = 'LogicFile';
        $demo_name = 'LogicFileDemo';
        $message = '创建公用LogicFile逻辑层文件';
        $this->BaseLogic($file_name, $demo_name, $message);
    }
    private function CreateDatabase()
    {
        $content = file_get_contents(__DIR__ . '\stubs\DatabaseDemo.stub');
        $project_path = $this->getBasePath();
        $file_path = '\000_demo_table.php';
        $file_dir_path =  $project_path . 'database\migrations'  . $file_path;
        $this->createFileSend($file_dir_path, $content, '创建迁移模板文件');
    }
    //创建全局状态码
    private function ErrCode()
    {
        $content = file_get_contents(__DIR__ . '/stubs/ErrCodeDemo.stub');
        $project_path = $this->getBasePath();
        $file_path = '\ErrCode.php';
        $file_dir_path =  $project_path . 'app\Exceptions'  . $file_path;
        $this->createFileSend($file_dir_path, $content, '创建全局状态码文件');
    }
    private function CreateLangApi()
    {
        $content = file_get_contents(__DIR__ . '/stubs/ApiLangDemo.stub');
        $project_path = $this->getBasePath();
        $file_path = '\api.php';
        $file_dir_path =  $project_path . 'resources\lang\zh'  . $file_path;
        $this->createFileSend($file_dir_path, $content, '创建全局多语言文件');
    }
    //---------------------------中间件------------------------------------//
    //创建api中间键
    private function CreateApiToken()
    {
        $file_name = 'ApiToken';
        $demo_name = 'ApiTokenDemo';
        $message = '创建api中间键文件';
        $this->BaseMiddleware($file_name, $demo_name, $message);
    }
    //创建Admin中间键
    private function CreateAdminToken()
    {
        $file_name = 'AdminToken';
        $demo_name = 'AdminTokenDemo';
        $message = '创建Admin中间键文件';
        $this->BaseMiddleware($file_name, $demo_name, $message);
    }
    //创建分页中间键
    private function CreatePage()
    {
        $file_name = 'Page';
        $demo_name = 'PageDemo';
        $message = '创建Page中间键文件';
        $this->BaseMiddleware($file_name, $demo_name, $message);
    }
    //-----------------------------自定义类文件------------------------------------//
    private function CreateMyClass()
    {
        $this->CreateJwt();
        $this->CreateWxPay();
        $this->CreateAES();
    }
    private function CreateWxPay()
    {
        $file_name = 'WxPay';
        $demo_name = 'WxPayDemo';
        $message = '创建WxPay文件';
        $this->BaseMyClass($file_name, $demo_name, $message);
    }
    private function CreateAES()
    {
        $file_name = 'AES';
        $demo_name = 'AESDemo';
        $message = '创建AES文件';
        $this->BaseMyClass($file_name, $demo_name, $message);
    }
    //加密解密jwt文件
    private function CreateJwt()
    {
        $file_name = 'Jwt';
        $demo_name = 'JwtDemo';
        $message = '创建jwt文件';
        $this->BaseMyClass($file_name, $demo_name, $message);
    }

    //-----------------------------自定义方法文件------------------------------------//

    private function CreateSupport()
    {
        $this->CreateHelper();
        $this->CreateGetValueAttribute();
    }
    private function CreateHelper()
    {
        $file_name = 'Helper';
        $demo_name = 'HelperDemo';
        $message = '创建Helper文件';
        $this->BaseSupport($file_name, $demo_name, $message);
    }
    private function CreateGetValueAttribute()
    {
        $file_name = 'GetValueAttribute';
        $demo_name = 'GetValueAttributeDemo';
        $message = '创建GetValueAttribute文件';
        $this->BaseSupport($file_name, $demo_name, $message);
    }

    //修改KernelDemo文件
    private function updateKernel()
    {
        if ($this->BaseJianCe()) {
            $content = file_get_contents(__DIR__ . '\stubs\KernelDemo.stub');
            $project_path = $this->getBasePath();
            $file_path = 'app/Http/Kernel.php';
            $file_dir_path =  $project_path   . $file_path;
            $this->overwriteFileContent($file_dir_path, $content);
        }
    }
    //-----------------------------配置层修改------------------------------------//


    private function CreateConfig()
    {
        $this->CreateApi();
        $this->CreateAdmin();
        $this->updateApp();
        $this->UpdateFilesystems();
    }


    private function CreateApi()
    {
        $content = file_get_contents(__DIR__ . '/stubs/ApiDemo.stub');
        $project_path = $this->getBasePath();
        $file_path = '/api.php';
        $file_dir_path =  $project_path . $this->Config_path  . $file_path;
        $this->overwriteFileContent($file_dir_path, $content);
    }
    private function CreateAdmin()
    {
        $content = file_get_contents(__DIR__ . '/stubs/AdminDemo.stub');
        $project_path = $this->getBasePath();
        $file_path = '/admin.php';
        $file_dir_path =  $project_path . $this->Config_path  . $file_path;
        $this->overwriteFileContent($file_dir_path, $content);
    }

    private function updateApp()
    {
        if ($this->BaseJianCe()) {
            $content = file_get_contents(__DIR__ . '/stubs/AppDemo.stub');
            $project_path = $this->getBasePath();
            $file_path = '/app.php';
            $file_dir_path =  $project_path . $this->Config_path  . $file_path;
            $this->overwriteFileContent($file_dir_path, $content);
        }
    }

    private function UpdateFilesystems()
    {
        if ($this->BaseJianCe()) {
            $content = file_get_contents(__DIR__ . '/stubs/FilesystemsDemo.stub');
            $project_path = $this->getBasePath();
            $file_path = '/filesystems.php';
            $file_dir_path =  $project_path . $this->Config_path  . $file_path;
            $this->overwriteFileContent($file_dir_path, $content);
        }
    }
    //-----------------------------创建路由文件------------------------------------//

    private function CreateRoutes()
    {
        $this->CreateApiRoutes();
        $this->CreateAdminRoutes();
        $this->CreateWebRoutes();
    }
    private function CreateWebRoutes()
    {
        if ($this->BaseJianCe()) {
            $content = file_get_contents(__DIR__ . '/stubs/Route/WebRoutesDemo.stub');
            $project_path = $this->getBasePath();
            $file_path = '/web.php';
            $file_dir_path =  $project_path . $this->routes_path  . $file_path;
            $this->overwriteFileContent($file_dir_path, $content);
        }
    }
    private function CreateAdminRoutes()
    {
        if ($this->BaseJianCe()) {
            $content = file_get_contents(__DIR__ . '/stubs/Route/AdminRoutesDemo.stub');
            $project_path = $this->getBasePath();
            $file_path = '/admin.php';
            $file_dir_path =  $project_path . $this->routes_path  . $file_path;
            $this->overwriteFileContent($file_dir_path, $content);
        }
    }
    private function CreateApiRoutes()
    {
        if ($this->BaseJianCe()) {
            $content = file_get_contents(__DIR__ . '/stubs/Route/ApiRoutesDemo.stub');
            $project_path = $this->getBasePath();
            $file_path = '/api.php';
            $file_dir_path =  $project_path . $this->routes_path  . $file_path;
            $this->overwriteFileContent($file_dir_path, $content);
        }
    }

    //-----------------------------复制文件------------------------------------//


    private function CopyRequestsFile()
    {
        $sourcePath = __DIR__ . '/stubs/demo/Requests'; // 指定要复制的文件夹路径
        $project_path = $this->getBasePath();
        $destinationPath = $project_path . '/app/Http/Requests';
        // 执行文件复制操作
        $this->recursiveCopy($sourcePath, $destinationPath);
    }
    private function CopyStubFile()
    {
        $sourcePath = __DIR__ . '/stubs/demo/stubs'; // 指定要复制的文件夹路径
        $project_path = $this->getBasePath();
        $destinationPath = $project_path . '/stubs';
        // 执行文件复制操作
        $this->recursiveCopy($sourcePath, $destinationPath);
    }
    //-----------------------------重写ServiceProvider文件件------------------------------------//

    private function CreateRouteServiceProvider()
    {
        if ($this->BaseJianCe()) {
            $content = file_get_contents(__DIR__ . '/stubs/RouteServiceProviderDemo.stub');
            $project_path = $this->getBasePath();
            $file_path = 'app/Providers/RouteServiceProvider.php';
            $file_dir_path =  $project_path . $file_path;
            $this->overwriteFileContent($file_dir_path, $content);
        }
    }
    //-----------------------------重写.env文件------------------------------------//

    private function CreateEnv()
    {
        if ($this->BaseJianCe()) {
            $content = file_get_contents(__DIR__ . '/stubs/EnvDemo.stub');
            $project_path = $this->getBasePath();
            $file_path = '.env';
            $file_dir_path =  $project_path . $file_path;
            $this->overwriteFileContent($file_dir_path, $content);
        }
    }
    //-----------------------------重写composer.json文件------------------------------------//

    private function CreateComposer()
    {

        $project_path = $this->getBasePath();
        $content = file_get_contents($project_path . 'composer.json');
        $arr  = json_decode($content, true);
        $res = [
            "app\Support\Helper.php",
            "app\Support\GetValueAttribute.php"
        ];
        if (isset($arr['require']['chunge/laravel'])) {
            unset($arr['require']['chunge/laravel']);
        }
        if (isset($arr['autoload']['files'])) {
            foreach ($arr['autoload']['files'] as $v) {
                foreach ($res as $ks => $vs) {
                    if ($v == $vs) {
                        unset($res[$ks]);
                    }
                }
            }
            if (count($res) > 0) {
                $arr['autoload']['files'] = array_merge($arr['autoload']['files'], $res);
            } else {
                return true;
            }
        } else {
            $arr['autoload']['files'] = $res;
        }
        $json_content = json_encode($arr, JSON_UNESCAPED_SLASHES);
        $project_path = $this->getBasePath();
        $file_path = 'composer.json';
        $file_dir_path =  $project_path . $file_path;
        $this->overwriteFileContent($file_dir_path, $json_content);
    }

    private function CreateModels()
    {
        $file_name = 'BaseModel';
        $demo_name = 'BaseModelDemo';
        $message = '创建BaseModel文件';
        $this->BaseModels($file_name, $demo_name, $message);
    }
    private function BaseModels($file_name, $demo_name, $message)
    {
        $content = file_get_contents(__DIR__ . '/stubs/' . $demo_name . '.stub');
        $project_path = $this->getBasePath();
        $file_path = 'app\\Models\\' . $file_name . '.php';
        $file_dir_path =  $project_path  . $file_path;
        $this->createFileSend($file_dir_path, $content, $message);
    }
    public function BaseJianCe()
    {
        $logic_file = $this->Config_path . '\install.php';
        $project_path = $this->getBasePath();
        $file_dir_path =  $project_path   . $logic_file;

        if (file_exists($file_dir_path)) {
            return false;
        }
        return true;
    }
    private function BaseMyClass($file_name, $demo_name, $message)
    {
        $content = file_get_contents(__DIR__ . '/stubs/' . $demo_name . '.stub');
        $project_path = $this->getBasePath();
        $file_path = '/' . $file_name . '.php';
        $file_dir_path =  $project_path . $this->MyClass_path  . $file_path;
        $this->createFileSend($file_dir_path, $content, $message);
    }
    private function BaseSupport($file_name, $demo_name, $message)
    {
        $content = file_get_contents(__DIR__ . '/stubs/' . $demo_name . '.stub');
        $project_path = $this->getBasePath();
        $file_path = '/' . $file_name . '.php';
        $file_dir_path =  $project_path . $this->Support_path  . $file_path;
        $this->createFileSend($file_dir_path, $content, $message);
    }
    private function BaseMiddleware($file_name, $demo_name, $message = '')
    {
        $content = file_get_contents(__DIR__ . '/stubs/' . $demo_name . '.stub');
        $project_path = $this->getBasePath();
        $file_path = '/' . $file_name . '.php';
        $file_dir_path =  $project_path . $this->Middleware_path  . $file_path;
        $this->createFileSend($file_dir_path, $content, $message);
    }
    private function BaseCommands($file_name, $demo_name, $message = '')
    {
        $content = file_get_contents(__DIR__ . '\stubs\Commands\\' . $demo_name . '.stub');
        $project_path = $this->getBasePath();
        $file_path = '/' . $file_name . '.php';
        $file_dir_path =  $project_path . $this->commands_path  . $file_path;
        $this->createFileSend($file_dir_path, $content, $message);
    }
    private function BaseLogic($file_name, $demo_name, $message = '')
    {
        $content = file_get_contents(__DIR__ . '\stubs\\' . $demo_name . '.stub');
        $project_path = $this->getBasePath();
        $file_path = '\\' . $file_name . '.php';
        $file_dir_path =  $project_path . $this->logic_path  . $file_path;
        $this->createFileSend($file_dir_path, $content, $message);
    }
    private function getBasePath()
    {
        $project_path = explode('vendor', __DIR__);
        $project_path = $project_path[0];
        return $project_path;
    }
    /**
     * 执行文件创建
     */
    private function createFileSend($file_path, $source, $message = '')
    {
        $dir_file = dirname($file_path); //返回路径中的目录部分
        if (file_exists($file_path)) {
            $this->error("{$message}文件已存在");
            return false;
        }
        //创建
        if (file_exists($dir_file) === false) {
            if (mkdir($dir_file, 0777, true) === false) {
                $this->error("{$message}目录" . $dir_file . '没有写入权限');
                return false;
            } else {
                $this->error('创建：' . $dir_file);
            }
        } else {
            $this->error('写入成功：' . $file_path);
        }
        //写入
        if (!file_put_contents($file_path, $source)) {
            $this->error("{$message}创建失败！");
            return false;
        }
        $this->error("{$message}创建成功！");
        return true;
    }
    //文件重写
    private  function overwriteFileContent($filePath, $newContent)
    {
        $logic_file = dirname($filePath); //返回路径中的目录部分
        //创建
        if (file_exists($logic_file) === false) {
            if (mkdir($logic_file, 0777, true) === false) {
                $this->error("{$logic_file}目录" . $logic_file . '没有写入权限');
                return false;
            } else {
                $this->error('创建：' . $logic_file);
            }
        }
        // 写入文件，覆盖原有内容
        if (!file_put_contents($filePath, $newContent)) {
            $this->error("{$logic_file}创建失败！");
            return false;
        } else {
            $this->error('写入成功：' . $filePath);
        }
        return true;
    }

    private function error($message)
    {
        echo $message . PHP_EOL;
    }
    private  function recursiveCopy($source, $destination)
    {
        $dir = opendir($source);

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        while (($file = readdir($dir)) !== false) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $sourcePath = $source . '/' . $file;
            $destinationPath = $destination . '/' . $file;

            if (is_dir($sourcePath)) {
                self::recursiveCopy($sourcePath, $destinationPath);
            } else {
                copy($sourcePath, $destinationPath);
            }
        }

        closedir($dir);
    }
}
