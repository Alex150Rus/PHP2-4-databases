<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 10.01.2019
 * Time: 23:06
 */

namespace app\services;

class Autoloader
{

  public $fileExtension = ".php";

  public function loadClass($className)
  {
    $className = str_replace(["app\\", "\\"],[ROOT_DIR , "/"], $className);
    $className .= $this->fileExtension;

    if (file_exists($className)) {
      include $className;
    }
  }
}