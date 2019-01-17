<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 11.01.2019
 * Time: 15:02
 */

namespace app\interfaces;


interface IDb
{
  function execute (string $sql, array $params = []);
}