<?php

include ('../services/Autoloader.php');
include ('../config/main.php');
use app\services\Autoloader;
use app\models\Product;

spl_autoload_register([new Autoloader(), 'loadClass']);

$product1 = new Product();
var_dump($product2 = $product1 ->getOne(5));
var_dump($product1);
$product2->insert();
var_dump($product2->update());

/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 10.01.2019
 * Time: 23:04
 */