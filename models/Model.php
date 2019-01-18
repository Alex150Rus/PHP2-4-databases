<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 11.01.2019
 * Time: 0:05
 */

namespace app\models;

use app\interfaces\IModel;
use app\services\Db;


abstract class Model implements IModel
{

  protected $db;

  public function __construct()
  {
    $this->db = Db::getInstance();
  }

  function getOne(int $id)
  {
    $tableName = $this->getTableName();

    /* id = :id - :-плэйсхолдер, id - имя. Вместо него подстановится значение. Защита от sql инъекции, так как нельзя модифицировать
    sql запрос */
    $sql = "SELECT * FROM {$tableName} WHERE id = :id";
    return $this->db->queryObject($sql, get_called_class(), [":id" => $id])[0];
  }

  function getAll()
  {
    $tableName = $this->getTableName();
    $sql = "SELECT * FROM {$tableName}";
    return $this->db->queryObject($sql, get_called_class());
  }

  public function save() {
    $id = $this->id;
    if ($id === null) {
      $this->insert();
    } elseif ($id !== null && $this != $this->getOne($id)) {
      $objFromDb =$this->getOne($id);
      $params = [];
      $expression = [];
      foreach ($this as $key => $value) {
        foreach ($objFromDb as $dbKey => $dbValue) {
         if ($key == $dbKey && $key!= 'db') {
          $params[":{$key}"] = $value;
          $expression[] = "$key = :$key";
         }
        }
      }
      $this->update($params, $expression);
    }
  }

//UPDATE `shop-php`.`products` t SET t.`name` = 'клюква', t.`description` = '3в' WHERE t.`id` = 7
// поэтому (int)($this->db->getLastInsertId()

  function insert()
  {
    $params = [];
    $columns = [];
    foreach ($this as $key => $value) {
      if ($key == 'db' ) {
        continue;
      }
      $params[":{$key}"] = $value;
      $columns[] = "`{$key}`";
    }
    $columns = implode(", ", $columns);
    $placeholders = implode(", ", array_keys($params));
    $tableName = $this->getTableName();
    $sql = "INSERT INTO {$tableName} ({$columns}) VALUES ({$placeholders})";
    $this->db->execute($sql, $params);
    $this->id = $this->db->getLastInsertId();
  }

   public function update(array $params, array $expression)
  {
    $tableName = $this->getTableName();
    $expression = implode(", ",array_values($expression));
    $sql = "UPDATE {$tableName} SET {$expression} WHERE id= :id";
    return $this->db->execute($sql, $params);
  }

  public function delete()
  {
    $tableName = $this->getTableName();
    $sql = "DELETE FROM {$tableName} WHERE id = :id";
    return $this->db->execute($sql, [":id" => $this->id]);
  }

}