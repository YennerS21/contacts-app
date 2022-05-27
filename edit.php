<?php
    require 'db.php';
    //Obtener identifidor del contacto a editar
    $id = $_GET['id'];
    //Identificar que exista tal usuario
    $statement = $conn->prepare("SELECT * FROM contacts WHERE id=:id LIMIT 1");
    $statement->execute([':id'=>$id]);
    //Validar para cuando no exista el usuario
    if($statement->rowCount()==0){
      http_response_code(404);
      echo "Http 404 not found";
      return;
    }
    //Convertir resultado del query a un array asociativo
    $contacts = $statement->fetch(PDO::FETCH_ASSOC);
    $error=null;
    //Verificar metodo del request: POST
    if ($_SERVER["REQUEST_METHOD"]==="POST") {
      //Validar datos correctos
      if (empty($_POST['name']) || empty($_POST['phone_number'])) {
        $error = "Please fill all fields.";
      }elseif (!is_numeric($_POST['phone_number'])) {
        $error = "Phone number isnot number";
      }elseif ($error===null){
        $statement = $conn->prepare(" 
          UPDATE contacts 
          SET name=:name, phone_number=:phoneNumber 
          WHERE id=:id");
        $statement->execute([
          ':id'=>$id,
          ':name'=>$_POST['name'],
          ':phoneNumber'=>$_POST['phone_number']
        ]);
        header('Location:index.php');
      }  
    }
?>
<?php require 'components/head.php';?>
<div class="container pt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Edit Contact</div>
        <div class="card-body">
          <?php if($error) :?>
            <p class="text-danger">
              <?= $error ?>
            </p>
          <?php endif; ?>
          <form method="POST" action="edit.php?id=<?=$contacts['id']?>">
            <div class="mb-3 row">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input value="<?= $contacts['name']?>" type="text" class="form-control" name="name"  autocomplete="name" autofocus>
              </div>
            </div>

            <div class="mb-3 row">
              <label for="phone_number" class="col-md-4 col-form-label text-md-end">Phone Number</label>

              <div class="col-md-6">
                <input value="<?= $contacts['phone_number']?>" id="phone_number" type="tel" class="form-control" name="phone_number"  autocomplete="phone_number" autofocus>
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
<?php require 'components/footer.php'?>
