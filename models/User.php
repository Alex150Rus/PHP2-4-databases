<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 11.01.2019
 * Time: 0:41
 */

namespace app\models;


class User extends Record
{
 public $id;
 public $login;
 public $password;
 public $email;

 static function getTableName(): string
 {
  return 'users';
 }
}