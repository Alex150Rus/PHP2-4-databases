<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 11.01.2019
 * Time: 0:46
 */

namespace app\models;


class Order extends Record
{
  public $id;
  public $user;
  public $address;
  public $orderJson;
  public $status;

  static function getTableName(): string
  {
    return 'orders';
  }
}