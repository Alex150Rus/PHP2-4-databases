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

  function insert()
  {
    $params = [];
    $columns = [];
    foreach ($this as $key => $value) {
      if ($key == 'id') {
        continue;
      }
      if ($key == 'db') {
        continue;
      }
      $params[":{$key}"] = "$value";
      $columns[] = "{$key}";
    }
    $columns = implode(", ", $columns);
    $placeholders = implode(", ", array_keys($params));
    $tableName = $this->getTableName();
    $sql = "INSERT INTO {$tableName} ({$columns}) VALUES ({$placeholders})";
    $this->db->execute($sql, $params);
    $this->id= $this->db->getLastInsertId();
  }

   public function update()
  {
    $arrayOfObjectProperties = (get_object_vars($this));
    array_pop($arrayOfObjectProperties);
    $id = $arrayOfObjectProperties['id'];
    $expression = null;
    foreach ($arrayOfObjectProperties as $key => $value) {
      $expression .= "$key" . "=" . "$value, ";
    }
    $sql = "UPDATE {$this->getTableName()} SET {$expression} WHERE id={$id}";
    return $this->db->execute($sql);
  }

  public function delete()
  {
    $tableName = $this->getTableName();
    $sql = "DELETE FROM {$tableName} WHERE id = :id";
    return $this->db->execute($sql, [":id" => $this->id]);
  }

}