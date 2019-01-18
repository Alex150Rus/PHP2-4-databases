<?php

include ('../services/Autoloader.php');
include ('../config/main.php');
use app\services\Autoloader;
use app\models\Product;

spl_autoload_register([new Autoloader(), 'loadClass']);

echo DEFAULT_CONTROLLER;

$controllerName = ($_GET['c']) ?? DEFAULT_CONTROLLER;
$actionName = (isset($_GET['a']) ? $_GET['a'] : 0);

$controllerClass = CONTROLLER_NAMESPACE . ucfirst($controllerName) . "Controller";

if (class_exists($controllerClass)){
  $controller = new $controllerClass($actionName);
  $controller->runAction($actionName);
};

/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 10.01.2019
 * Time: 23:04
 */

