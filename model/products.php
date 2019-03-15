<?php

class Product 
{

public $id;
public $name;
public $price;
public $quantity;
public $category_id;
public $imagepath;
public $dbname;
public $host;
public $dbuser;
public $upasswd;
public $uri;
public $connector ;


public function __construct()
{
    $this->dbname="ITI_Cafeteria";
    $this->host="localhost";
    $this->dbuser="root";
    $this->upasswd="01111451253";
    $this->uri = "mysql:host=$this->host;dbname=$this->dbname";
    $this->connector = new PDO($this->uri, $this->dbuser,$this->upasswd);
    $this->connector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}


 public function addProduct()
 {

   $query="insert into Products (name,price,quantity,category_id,imagepath) values (?,?,?,?,?)";
   $insert_statm=$this->connector->prepare($query);
   $insert_parameters=[$this->name,$this->price,$this->quantity,$this->category_id,$this->imagepath];
    $insert_statm->execute($insert_parameters);
 }

 public function editProduct()
 {
   $query="update Products set name=?,price=?,status=?,cat_id=? where id=?";
   $edit_statm=$this->connector->prepare($query);
   $edit_parameters=[$this->name,$this->price,$this->quantity,$this->category_id,$this->id];
   $edit_statm->execute($edit_parameters);
   return $edit_statm->rowcount();
 }

 public function getProductNames()
 {
   $query="select name from  Products where name= ? ";
   $param=[$this->name];
   $product_name=$this->connector->prepare($query);
   $product_name->execute($param);
   return $product_name->rowcount();
 }

public function getAllProducts()
{
   $query="select id, name, price, status, img_path from  Products ";
   $select_products=$this->connector->prepare($query);
   $select_products->execute();
   return $select_products;
}

public function deleteProduct()
{
    $query="delete FROM Products where id= ?";
    $param=[$this->id];
    $usr=$this->connector->prepare($query);
    $usr->execute($param);
    return $usr->rowcount();
}



public function getProduct()
{
   $query="select * from  Products where id = ? ";
   $param=[$this->id];
   $select_product=$this->connector->prepare($query);
   $select_product->execute($param);
   return $select_product;
}

/*
* Selecting available products
*/
public function selectProducts()
{
    $query = sprintf("select * from Products where quantity > 0");

    if(! $result_set = $this->prepareStmt($query)){
      echo $this->conn->connect_error;
      return false;
    }
    return $this->getData($result_set);
 }

}

?>
