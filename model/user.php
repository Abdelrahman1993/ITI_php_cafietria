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
  $this->dbname="ITI_Cafeteria";
  $this->host="localhost";
  $this->dbuser="root";
  $this->upasswd="01111451253";

  $this->uri = "mysql:host=$this->host;dbname=$this->dbname";
  $this->connector = new PDO($this->uri, $this->dbuser,$this->upasswd);
  $this->connector->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

 public function Edit_User()
 {
    $query="update User,Room set User.name=?,Room.room_number=?,Room.ext =? where Room.id=User.room_id and User.id =?";
    $edit_statm=$this->connector->prepare($query);
    $edit_parameters=[$this->name,$this->room_num,$this->extra_room,$this->id];
    $edit_statm->execute($edit_parameters);
    return $edit_statm->rowcount();
 }

public function getAllUsers()
{
  $query="select User.id,User.name,Room.room_id,User.img_path, Room.ext from  User ,Room where Room.room_id=User.room_id";
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

public function getUser()
{
  
  $query="select name,Room.room_id,ext,img_path from User , Room where Room.room_id=User.room_id and User.id =? ";
  $param=[$this->id];
  $select_product=$this->connector->prepare($query);
  $select_product->execute($param);
  return $select_product;
}

public function getRooms()
{
     $query="select room_id from Room";
     $select_rooms=$this->connector->prepare($query);
      $select_rooms->execute();
    return $select_rooms;
}

public function getRoomsExt()
{
     $query="select ext from Room";
     $select_rooms=$this->connector->prepare($query);
      $select_rooms->execute();
    return $select_rooms;

}
}

?>
