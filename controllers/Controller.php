<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 19.01.2019
 * Time: 0:55
 */

namespace app\controllers;


abstract class Controller
{
  //храним текущий экшн
  protected $action;
  //храним дефолтный экшн
  protected $defaultAction = 'index';
  //храним статическую часть сайта (хэдер, футер)
  protected $layout = "main";
  //храним состояние использования статической части сайта
  protected $useLayout = true;

  //метод запускает действие, которое примает в параметр из папки public index от объекта этого класса
  public function runAction($action = null) {
    //записываем текущий экшн, если он передан, если нет - используем дефолтный
    $this->action = $action ?: $this->defaultAction;
    //формируем наименование метода конкатенацией и увеличиваем первую букву
    $method= "action" . ucfirst($this->action);

    if (method_exists($this, $method)) {
      //если метод существет, то запускаем его
      $this->$method();
      //иначе
    } else {
      echo "404";
    }
  }

  //дефолтный экшн - рисует каталог
  public function actionIndex() {
    echo "catalog";
  }

  //рисует карточку товара
  public function actionCard() {
    // для этого метода не применяем статическую часть сайта
    $this->useLayout=false;
    //получаем id us url (прилетит туда гет запросом)
    $id = $_GET['id'];
    //создаём необходимую сущность для отрисовки, вытаскивая нужную инфу из БД
    $product = Product::getOne($id);
    // отправляем на отрисовку
    echo $this->render("card", ['product'=>$product]);
  }
  //метод для отрисовки принимает имя вьюхи и массив с параметрами
  protected function render($template, $params=[]) {
    //проверяем использовать статическуб часть сайта или нет
    if ($this->useLayout) {
      // если true - возвращаем шаблон, отрисованный методом renderTemplate и статическую часть сайта
      return $this->renderTemplate(
        "{$this->layout}", ['content' => $content = $this->renderTemplate($template, $params)]);
    }
    // если не использовать, то просто отрисовываем шаблон
    return $this->renderTemplate($template, $params);
  }
//метод для отрисовки шаблона
  protected function renderTemplate ($template, $params=[]){
    //начинаем буферизацию
    ob_start();
    //загоняем в переменную путь к шаблону
    $templatePath = TEMPLATES_DIR . "layouts/$template" . ".php";
    //разворачиваем массив с параметрами и записываем их в переменные
    extract($params);
    include $templatePath;
    // заканчиваем буферизацию и возвращаем данные в виде строки - без этого у нас произойдёт моментальная отрисовка в
    // этом месте
    return ob_get_clean();
  }
}