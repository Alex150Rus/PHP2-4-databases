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

  // 1)создаётся соединение через объект PDO и используется метод отложенной инициализации
  private function getConnection()
  {
    if (is_null($this->conn)) {
      $this->conn = new \PDO(
        $this->prepareDsnString(),
        $this->config['login'],
        $this->config['password']
      );

      /*PDO можно настроить на разные режимы работы. В частности, на режим фетча, указав ему вид получения данных -
      ассоциативный массив,например,: PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC
      setAttribute устанавливает параметры PDO - предопределённые константы внутри класса PDO
      певый аргумент - параметр, второй - его значение*/
      $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
    }
    return $this->conn;
  }

  // 2) метод получения доступа к соединению и выполения запроса
  private function query(string $sql, array $params = [])
  {
    // метод prepare вернёт объект, содержащий данные о готовящемся запросе
    $pdoStatement = $this->getConnection()->prepare($sql);

    /* execute выполняет запрос и привязывает значения, но он недостаточен для запросов, в которых нужно получить данные
    (Read)ниже мы для этого используем fetchAll()*/
    $pdoStatement->execute($params);
    return $pdoStatement;
  }

  // 3) метод извлечения результата
  public function queryOne(string $sql, $class, array $params = [])
  {
    return $this->queryAll($sql, $class, $params)[0];
  }

  // 3) метод извлечения результата
  public function queryAll(string $sql, $class, array $params = [])
  {
    // в fetchAll() мы можем указать тип данных, в котором хотим получить результат - массив объектов?
    return $this->query($sql, $params)->fetchAll(\PDO::FETCH_CLASS, $class);
  }

  // 3) метод извлечения результата для запросов без выборки: update, insert, delete
  public function execute(string $sql, array $params = [])
  {
    $this->query($sql, $params);
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