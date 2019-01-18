<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 19.01.2019
 * Time: 0:45
 */

namespace app\controllers;

use app\models\Product;
class CartController extends Controller
{
  public function actionIndex() {
    echo "cart";
  }
  //рисует карточку товара
  public function actionCard()
  {
    // для этого метода не применяем статическую часть сайта
    $this->useLayout = true;
    //получаем id us url (прилетит туда гет запросом)
    $id = $_GET['id'];
    //создаём необходимую сущность для отрисовки, вытаскивая нужную инфу из БД
    $product = Product::getOne($id);
    // отправляем на отрисовку
    echo $this->render("../{$this->getClassName()}/card", ['product' => $product]);
  }

  public function getClassName() {
    return 'cart';
  }
}
