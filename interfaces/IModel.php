<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 11.01.2019
 * Time: 0:12
 */

namespace app\interfaces;


interface IModel
{
  function getOne(int $id);

  function getAll();

  function getTableName();

  function getClassName();
}