<?php
    require 'db.php';
    session_start();
    if (!isset($_SESSION["user"])) {
      header("Location:index.php");
    }
    $error=null;
    //Identificar el usuario
    $id= $_GET['id'];
    $statement = $conn->prepare("SELECT * FROM users WHERE id=:id LIMIT 1");
    $statement->bindParam(":id",$id);
    $statement->execute();
    if ($statement->rowCount()===0) {
      $error = "404 not found";
    }
    $user = $statement->fetch(PDO::FETCH_ASSOC);
    if ($user["password"]!==$_SESSION["user"]["password"]) {
      $error = "No authorized";
    }
    //Verificar metodo del request: POST
    if ($_SERVER["REQUEST_METHOD"]==="POST" && count($user)>0 && $error===null) {
    //Validar datos correctos
      if (empty($_POST['name']) || empty($_POST['email'] || empty($_POST['password']))) {
        $error="Please fill all fields";
        header("Location:settings.php?id=$id");
        return;
      }
      //Validar email
      if($error!==null){
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        if (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
          $error = "Invalid email";
        }
      }
    }
  ?>
<?php require 'components/head.php';?>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Settings you perfil</div>
        <div class="card-body">
          <?php if(isset($error)) :?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif; ?>
          <form method="POST" action="settings.php?id=<?=$user['id']?>">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">New name</label>
              <div class="col-md-6">
                <input value="<?=$user['name']?>" id="name" type="text" class="form-control" name="name"  autocomplete="name">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="email" class="col-md-4 col-form-label text-md-end">New email</label>
              <div class="col-md-6">
                <input value="<?=$user['email']?>" id="email" type="text" class="form-control" name="email"  autocomplete="phone_number">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="password" class="col-md-4 col-form-label text-md-end">Confirm password*</label>
              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password"  autocomplete="phone_number" placeholder="*****">
              </div>
            </div>
            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require 'components/footer.php';?>
