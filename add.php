<?php
// vypis aut
include('DbConnect.php');
require_once('Cars.php');

// zavolani metody connect pro pripojeni do db (databaze)
$conn = new DbConnect();
$dbConnection = $conn->connect();
// vytvoreni instance Cars pomoci konstruktoru s parametrem pripojeni do db
$instanceCars = new Cars($dbConnection);

// hlida jestli je v globalnim poli klic add a pokud ano, zavola se metoda addCar
if (isset($_POST['add'])) {
  $brand = $_POST['brand'];
  $model = $_POST['model'];
  $reg = $_POST['reg'];
  $km = $_POST['km'];
  $year = $_POST['year'];
  $instanceCars->addCar($brand, $model, $reg, $km, $year);
  header("Location: index.php");
  exit();

?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="cs">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./scss/custom.css" rel="stylesheet">
  <title>Pridani auta</title>
</head>

<body>
  <section>
    <div class="container">
      <h2>Pridani auta</h2>

      <form action="add.php" method="post">
        <input type="text" name="brand" value="" class="form-control my-2" placeholder="znacka vyrobce" required>
        <input type="text" name="model" value="" class="form-control my-2" placeholder="model vozidla" required>
        <input type="text" name="reg" value="" class="form-control my-2" placeholder="registracni znacka" required>
        <input type="number" name="km" value="" class="form-control my-2" placeholder="pocet najetych km" required>
        <input type="number" name="year" value="" class="form-control my-2" placeholder="rok vyroby" required>
        <input type="submit" value="Vloz auto" class="btn btn-primary my-2" name="add">
      </form>
    </div>
  </section>


  <!-- SKRIPT BOOTSTRAP -->
  <script src="./bootstrap.bundle.min.js"></script>
  <!-- ^^^^^ -->
</body>

</html>