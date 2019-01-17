<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 14.01.2019
 * Time: 0:06
 */

namespace app\traits;

//неполноценный класс. Мы от него не можем создать экземпляр, но можем его подмешивать в другие классы с помощью use
trait TSingleton
{
  //здесь хранится единственный экземпляр объекта
  private static $instance = null;

  /* приватный метод конструктор нигде нельзя использовать, т.е. нельзя будет создать от него объект: new Db() или
  другие экземпляры класса, в которых будет использоваться этот синглтон. Но нам нужен 1 объект и мы можем создать
   его внутри класса! - см ниже getInstance */
  private function __construct(){}

  //используется при клонировании объекта
  private function __clone(){}

  //используется при восстановлении объекта из сериализованных данных
  private function __wakeup(){}

  // метод отложенной инициализации для возврата объекта, созданного в классе. Теперь везде будем получать один и тот же
  // оьъект
  public static function getInstance()
  {
    if (is_null(static::$instance)) {
      static::$instance = new static();
    }
    return static::$instance;
  }
}