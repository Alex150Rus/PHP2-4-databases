<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 11.01.2019
 * Time: 0:12
 */

namespace app\interfaces;


interface IRecord
{
  static function getOne(int $id);

  static function getAll();

  static function getTableName();

  function insert();
}