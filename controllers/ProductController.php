<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 18.01.2019
 * Time: 7:13
 */

namespace app\controllers;


use app\models\Product;

class ProductController
{
  protected $action;
  protected $defaultAction = 'index';
  protected $layout = "main";
  protected $useLayout = true;

  public function runAction($action = null) {
    $this->action=$action ?: $this->defaultAction;
    $method= "action" . ucfirst($this->action);

    if (method_exists($this, $method)) {
      $this->$method();
    } else {
      echo "404";
    }
  }

  public function actionIndex() {
    echo "catalog";
  }

  public function actionCard() {
    $this->useLayout=false;
    $id = $_GET['id'];
    $product = Product::getOne($id);
   echo $this->render("card", ['product'=>$product]);
  }

  protected function render($template, $params=[]) {
    if ($this->useLayout) {
      return $this->renderTemplate(
        "layouts/{$this->layout}", ['content' => $content = $this->renderTemplate($template, $params)]);
    }
    return $this->renderTemplate($template, $params);
  }

  protected function renderTemplate ($template, $params=[]){
    ob_start();
    $templatePath = TEMPLATES_DIR . $template . ".php";
    extract($params);
    include $templatePath;
    return ob_get_clean();
  }
}