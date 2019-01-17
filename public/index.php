<?php

include ('../services/Autoloader.php');
include ('../config/main.php');
use app\services\Autoloader;
use app\models\Product;

spl_autoload_register([new Autoloader(), 'loadClass']);

$product1 = new Product();

$product1->name = 'Робот';


$product1->price= 360;
$product1->description="ss";
$product1->vendor_id= 760;
var_dump($product1);
$product1->insert();

/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 10.01.2019
 * Time: 23:04
 */