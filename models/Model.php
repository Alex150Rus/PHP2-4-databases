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
    $class=$this->getClassName();
    return $this->db->queryOne($sql, $class, [":id" => $id]);
  }

  function getAll()
  {
    $tableName = $this->getTableName();
    $sql = "SELECT * FROM {$tableName}";
    $class=$this->getClassName();
    return $this->db->queryAll($sql, $class);
  }

  public function insert(){
    $sql= $this->sqlInsert();
    return $this->db->execute($sql);
  }

  protected function sqlInsert(){
    $arrayOfObjectProperties = (get_object_vars($this));
    array_pop($arrayOfObjectProperties);
    $columns = implode(", ", array_keys($arrayOfObjectProperties));
    $values = implode(", ", array_values($arrayOfObjectProperties));
    $sql = "INSERT INTO {$this->getTableName()} ($columns) VALUES ($values)";
    return $sql;
  }

  public function update() {
  $sql = $this->sqlUpdate();
    return $this->db->execute($sql);
  }

  protected function sqlUpdate(){
    $arrayOfObjectProperties = (get_object_vars($this));
    array_pop($arrayOfObjectProperties);
    $id=$arrayOfObjectProperties['id'];
    $expression= null;
    foreach ($arrayOfObjectProperties as $key=>$value) {
      $expression.="$key" . "=" . "$value, ";
    }
    $sql = "UPDATE {$this->getTableName()} SET {$expression} WHERE id={$id}";
    return $sql;
  }

  public function delete() {
    $id=get_object_vars($this)['id'];
    $sql = "DELETE FROM {$this->getTableName()} WHERE id={$id}";
    return $this->db->execute($sql);
  }

}