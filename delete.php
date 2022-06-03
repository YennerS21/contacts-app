<?php
  require 'db.php';
  session_start();
  if (!isset($_SESSION["user"])) {
    header("Location:login.php");
  }
  $id = $_GET['id'];
  $statement = $conn->prepare("SELECT id, user_id, name FROM contacts WHERE id=:id LIMIT 1");
  $statement->execute([':id'=>$id]);
  if($statement->rowCount()==0){
    http_response_code(404);
    $_SESSION["flash"] = [
      "message"=>"Http 404 not found",
      "alert" => "danger"
    ];
    header("Location:home.php");
    // echo "Http 404 not found";
    return;
  }
  $contact = $statement->fetch(PDO::FETCH_ASSOC);
  if (intval($_SESSION["user"]["id"]) !== intval($contact['user_id'])) {
    http_response_code(403);
    $_SESSION["flash"] = [
      "message"=>"Http 403 unauthorized",
      "alert" => "danger"
    ];
    header("Location:home.php");
    // echo "Http 403 unauthorized";
    return;
  }
  $conn->prepare("DELETE FROM contacts WHERE id=:id")->execute([':id'=>$id]);
  $_SESSION["flash"] = [
    "message"=>"Contact {$contact['name']} deleted.",
    "alert" => "danger"
  ];
  header("Location:home.php");
  return;
?>
