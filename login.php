  <?php
    require 'db.php';
    $error=null;
    //Verificar metodo del request: POST
    if ($_SERVER["REQUEST_METHOD"]==="POST") {
      //Validar datos correctos
      if (!empty($_POST['email'] && !empty($_POST['password']))) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        //Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Correo invalido";
        }
        $statement = $conn->prepare("SELECT email, password FROM users WHERE email=:email LIMIT 1");
        $statement->bindParam(":email",$email);
        $statement->execute();
        //Verificar si el correo existe
        if ($statement->rowCount()<0) {
          $error = "Credentials incorrect.";
        }
        if ($error===null) {
          $user=$statement->fetch(PDO::FETCH_ASSOC);
          if (!password_verify($password,$user["password"])) {
            $error = "Credentials incorrect.";
          }else{
            unset($user['password']);
            session_start();
            $_SESSION["user"] = $user;
            header("Location:home.php");
          }
        }
      }else{
        $error = "Please fill all fields";
      }
    }
  ?>
<?php require 'components/head.php';?>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Login</div>
        <div class="card-body">
          <?php if($error) :?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif; ?>
          <form method="POST" action="login.php">
            <div class="mb-3 row">
              <label for="email" class="col-md-4 col-form-label text-md-end">Email</label>
              <div class="col-md-6">
                <input id="email" type="text" class="form-control" name="email"  autocomplete="phone_number" autofocus>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
              <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password"  autocomplete="phone_number" autofocus>
              </div>
            </div>
            <div class="mb-3 row">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require 'components/footer.php';?>
