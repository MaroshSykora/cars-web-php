<?php
// vypis aut
include('DbConnect.php');
require_once('Cars.php');

// zavolani metody connect pro pripojeni do db (databaze)
$conn = new DbConnect();
$dbConnection = $conn->connect();
// vytvoreni instance Cars pomoci konstruktoru s parametrem pripojeni do db
$instanceCars = new Cars($dbConnection);
//
$carToEdit = [];

if (isset($_GET['id'])) {
  $carId = $_GET['id'];
  $carToEdit  = $instanceCars->getCar($carId);
}

// aktualizuje podle id zaznam konkretniho auta v db
if (isset($_POST['update'])) {
  $carId = $_POST['id'];
  $brand = $_POST['brand'];
  $model = $_POST['model'];
  $reg = $_POST['reg'];
  $km = $_POST['km'];
  $year = $_POST['year'];
  $instanceCars->updateCar($carId, $brand, $model, $reg, $km, $year);
  header("Location: index.php");
  exit();
}


?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="cs">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./scss/custom.css" rel="stylesheet">
  <title>Auta</title>
</head>

<body>
  <section>
    <div class="container">
      <h2>Editace auta</h2>
      <?php if ($carToEdit): ?>
        <form action="edit.php" method="post">
          <input type="hidden" name="id" value="<?php echo $carToEdit['id'] ?>" class="form-control my-2">
          <input type="text" name="brand" value="<?php echo $carToEdit['brand'] ?>" class="form-control my-2">
          <input type="text" name="model" value="<?php echo $carToEdit['model'] ?>" class="form-control my-2">
          <input type="number" name="reg" value="<?php echo $carToEdit['reg'] ?>" class="form-control my-2">
          <input type="km" name="km" value="<?php echo $carToEdit['km'] ?>" class="form-control my-2">
          <input type="year" name="year" value="<?php echo $carToEdit['year'] ?>" class="form-control my-2">
          <input type="submit" value="Aktualizuj" class="btn btn-primary my-2" name="update">
        </form>
      <?php else: ?>
        <p>Zadne nebo neexistujici auto k editaci</p>
      <?php endif; ?>
    </div>
  </section>


  <!-- SKRIPT BOOTSTRAP -->
  <script src="./bootstrap.bundle.min.js"></script>
  <!-- ^^^^^ -->
</body>

</html>