<?php
class Category{
public $name;
public $dbname;
public $host;
public $dbuser;
public $upasswd;
public $uri;
public $connector ;


public function __construct()
{
    $this->dbname="cafeteria";
    $this->host="localhost";
    $this->dbuser="root";
    $this->upasswd="";
    $this->uri = "mysql:host=$this->host;dbname=$this->dbname";
    $this->connector = new PDO($this->uri, $this->dbuser,$this->upasswd);
    $this->connector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

public function getCategories()
{
  $query="select * from Category";
  $select_cats=$this->connector->prepare($query);
  $select_cats->execute();
  return $select_cats;
}


public function addCategory()
{
  $query=" insert into Category (name) values(?);";
  $select_cats=$this->connector->prepare($query);
  $param=[$this->name];
  $select_cats->execute($param);
  return $select_cats;
}

 public function checkCategory()
 {
  $query="select name from Category where name= ? ";
  $param=[$this->name];
  $cat_name=$this->connector->prepare($query);
  $cat_name->execute($param);
  return $cat_name->rowcount();
 }

}

?>
