  <?php
    require 'db.php';
    session_start();
    if (!isset($_SESSION["user"])) {
      header("Location:login.php");
    }
    $error=null;
    //Verificar metodo del request: POST
    if ($_SERVER["REQUEST_METHOD"]==="POST") {
      //Validar datos correctos
      if (empty($_POST['name']) || empty($_POST['phone_number'])) {
        $error = "Please fill all fields.";
      }elseif (!is_numeric($_POST['phone_number'])) {
        $error = "Phone number isnot number";
      }elseif ($error===null){
        $statement = $conn->prepare("INSERT INTO contacts(user_id, name, phone_number) 
                  VALUES(:id, :name, :phone_number)");
        $statement->bindParam(":id", $_SESSION["user"]["id"]);
        $statement->bindParam(":name",trim($_POST['name']));
        $statement->bindParam(":phone_number",trim($_POST['phone_number']));
        $statement->execute();
        header('Location:home.php');
      }  
    }
  ?>
<?php require 'components/head.php';?>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Contact</div>
        <div class="card-body">
          <?php if($error) :?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif; ?>
          <form method="POST" action="add.php">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
              <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name"  autocomplete="name" autofocus>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>
              <div class="col-md-6">
                <input id="phone_number" type="tel" class="form-control" name="phone_number"  autocomplete="phone_number" autofocus>
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
