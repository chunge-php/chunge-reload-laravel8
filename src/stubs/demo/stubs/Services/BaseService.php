
<?php

namespace App\Services;

class BaseService
{
    public const DELETE_YES = 1; //回收站
    public const DELETE_NO = 0; //正常

    public function __construct()
    {
    }
}
