<?php
  require 'db.php';
  $id = $_GET['id'];
  $statement = $conn->prepare("SELECT id FROM contacts WHERE id=:id");
  $statement->execute([':id'=>$id]);
  if($statement->rowCount()==0){
    http_response_code(404);
    echo "Http 404 not found";
    return;
  }
  $conn->prepare("DELETE FROM contacts WHERE id=:id")->execute([':id'=>$id]);
  header("Location:home.php");
?>
