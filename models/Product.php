<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 10.01.2019
 * Time: 23:29
 */

namespace app\models;

class Product extends Model
{
  public $id;
  public $name;
  public $description;
  public $price;
  public $vendor_id;

public function __construct($id = null, $name = null, $description = null, $price = null, $vendor_id = null)
{
  parent::__construct();
  $this->id=$id;
  $this->name=$name;
  $this->description=$description;
  $this->price=$price;
  $this->vendor_id=$vendor_id;
}

  public function getTableName(): string
  {
    return 'products';
  }
}