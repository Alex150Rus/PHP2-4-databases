<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 11.01.2019
 * Time: 0:41
 */

namespace app\models;


class User extends Model
{
 public $id;
 public $login;
 public $password;
 public $email;

 public function getTableName(): string
 {
  return 'users';
 }
}