<?php
$servername ='localhost';
$user = 'root';
$password = '';
$db = 'foodmaster';



$conn = new mysqli($servername,$user,$password,$db);

if ($conn  -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}else{
    //   echo 'connected';
}
?>