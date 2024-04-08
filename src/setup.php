<?php

use Chunge\Laravel\Installer;

$model  = new Installer();
if ($model->BaseJianCe()) {
    $model->copyFiles();
}
