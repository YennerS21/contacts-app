<?php
  require 'db.php';
  session_start();
  if (!isset($_SESSION["user"])) {
    header("Location:index.php");
  }
  $id = intval($_SESSION["user"]["id"]);
  $contacts = $conn->query("SELECT * FROM contacts WHERE user_id={$id}");
?>
<?php require 'components/head.php' ?>
<div class="container pt-4 p-3">
  <div class="row">
    <!-- Validar lista de contactos vacia -->
    <?php if($contacts->rowCount()==0):?>
      <div class="col-md-4 mx-auto">
        <div class="card card-body text-center">
          <p>No contacts saved yet</p>
          <a href="add.php">Add One!</a>
        </div>
      </div>
    <?php endif;?>
    <!-- Leer y mostrar datos -->
    <?php foreach($contacts as $contact) :?>
      <div class="col-md-4 mb-3">
        <div class="card text-center">
          <div class="card-body">
            <h3 class="card-title text-capitalize"><?= $contact["name"]?></h3>
            <p class="m-2"><?= $contact["phone_number"] ?></p>
            <a href="edit.php?id=<?=$contact["id"]?>" class="btn btn-secondary mb-2">Edit Contact</a>
            <a href="delete.php?id=<?=$contact["id"]?>" class="btn btn-danger mb-2">Delete Contact</a>
          </div>
        </div>
      </div>
    <?php endforeach;?>
  </div>
</div>
<?php require 'components/footer.php' ?>

