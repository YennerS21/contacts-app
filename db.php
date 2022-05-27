<?php

//Datos de la conexion
$database="contacts_app";
$host="127.0.0.1";
$user="root";
$password="3213049684";

try {
  $conn = new PDO("mysql:host=$host;dbname=$database",$user, $password);
  // foreach ($conn->query("SHOW DATABASES") as $row){
  //   print_r($row);
  // }
} catch (PDOException $e) {
  echo $e->getMessage();
}
