  <?php
    require 'db.php';
    $error=null;
    //Verificar metodo del request: POST
    if ($_SERVER["REQUEST_METHOD"]==="POST") {
      //Validar datos correctos
      if (!empty($_POST['name']) && !empty($_POST['email'] && !empty($_POST['password']))) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        //Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Correo invalido";
        }
        $statement = $conn->prepare("SELECT * FROM users WHERE email=:email");
        $statement->bindParam(":email",$email);
        $statement->execute();
        //Verificar si el correo existe
        if ($statement->rowCount()>0) {
          $error = "This email is already registered.";
        }
        if ($error===null) {
          $conn->prepare("INSERT INTO users(name, email, password) VALUES(:name, :email, :password)")
                ->execute([
                  ":name" =>$name,
                  ":email"=>$email,
                  ":password"=>$password,
                ]);
          header("Location:home.php");
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
        <div class="card-header">Register</div>
        <div class="card-body">
          <?php if($error) :?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif; ?>
          <form method="POST" action="register.php">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name"  autocomplete="name" autofocus>
              </div>
            </div>
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
