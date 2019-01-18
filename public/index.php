<?php

include ('../services/Autoloader.php');
include ('../config/main.php');
use app\services\Autoloader;
use app\models\Product;

spl_autoload_register([new Autoloader(), 'loadClass']);

$product1 = new Product();
$product1->name = '7инсерт';
$product1->save();


$product1->id=4;
$product1->name = '8иzzнс';
$product1->save();



/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 10.01.2019
 * Time: 23:04
 */

