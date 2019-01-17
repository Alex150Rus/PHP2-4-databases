<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 11.01.2019
 * Time: 14:56
 */

namespace app\services;

use app\interfaces\IDb;
use app\traits\TSingleton;


class Db implements IDb
{

  use TSingleton;

  private $config = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'login' => 'root',
    'password' => 'Alex123belka',
    'database' => 'shop-php',
    'charset' => 'utf8',
  ];

  //хранится соединение
  private $conn = null;


  private function getConnection()
  {
    if (is_null($this->conn)) {
      $this->conn = new \PDO(
        $this->prepareDsnString(),
        $this->config['login'],
        $this->config['password']
      );


      $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }
    return $this->conn;
  }

  private function query(string $sql, array $params = [])
  {

    $pdoStatement = $this->getConnection()->prepare($sql);

    $pdoStatement->execute($params);
    var_dump($sql);
    var_dump($pdoStatement);
    return $pdoStatement;
  }

  public function queryObject($sql, $className, $params = []) {
    $pdoStatement = $this->query($sql, $params);
    $pdoStatement->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, $className);
    return $pdoStatement->fetchAll();
  }

  public function getLastInsertId() {
    return $this->getConnection()->lastInsertId();
  }

  public function execute(string $sql, array $params = [])
  {
    var_dump($this->query($sql, $params));
    return true;
  }

  private function prepareDsnString()
  {
    return sprintf("%s:host=%s;dbname=%s;charset=%s",
      $this->config['driver'],
      $this->config['host'],
      $this->config['database'],
      $this->config['charset']
    );
  }
}