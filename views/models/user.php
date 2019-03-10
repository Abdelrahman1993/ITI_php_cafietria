<?php

class User
{
 public $id;
 public $name;
 public $room_num;
 public $extra_room;
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

 public function Edit_User()
 {
    $query="update User,Room set User.name=?,Room.room_number=?,Room.ext =? where Room.id=User.room_id and id =?";
    $edit_statm=$this->connector->prepare($query);
    $edit_parameters=[$this->name,$this->room_num,$this->extra_room,$this->id];
    $edit_statm->execute($edit_parameters);
    return $edit_statm->rowcount();
 }

public function getAllUsers()
{
  $query="select User.id,User.name,Room.room_number,User.img_path, Room.ext from  User ,Room where Room.id=User.room_id";
  $users=$this->connector->prepare($query);
  $users->execute();
  return $users;
}

public function deleteUser()
{
     $query="delete from User where id= ?";
     $param=[$this->id];
     $usr=$this->connector->prepare($query);
      $usr->execute($param);
      return $usr->rowcount();

}

public function get_user()
{
  $query="select * from  User where id = ? ";
  $param=[$this->id];
  $select_product=$this->connector->prepare($query);
  $select_product->execute($param);
  return $select_product;
}

}

?>
