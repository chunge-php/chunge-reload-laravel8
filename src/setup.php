<?php

use Chunge\ReloadLaravel8\Installer;

$model  = new Installer();
if ($model->BaseJianCe()) {
    $model->copyFiles();
}
