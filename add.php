<?php
// vypis aut
require_once('Cars.php');
include('DbConnect.php');

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
}
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
  <nav class="navbar navbar-expand-lg yellow-bg">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Auta</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Seznam aut</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="edit.php">Uprav auto</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="add.php">Přidej auto</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
    <h2 class="h2 dark-grey-color my-3">Přidání nového auta</h2>
    <form action="add.php" method="post">
      <input type="hidden" name="id" value="">
      <input class="form-control my-2" name="brand" type="text" value="" placeholder="Zadejte značku" required />
      <input class="form-control my-2" name="model" type="text" value="" placeholder="Zadejte model" required />
      <input class="form-control my-2" name="reg" type="text" value="" placeholder="Zadejte registraci" required />
      <input class="form-control my-2" name="km" type="number" value="" placeholder="Zadejte kilometry" required />
      <input class="form-control my-2" name="year" type="number" value="" placeholder="Zadejte rok" required />
      <input class="btn btn-main my-2" type="submit" name="add" value="Vlož auto" />
    </form>
  </div>


  <!-- SKRIPT BOOTSTRAP -->
  <script src="./bootstrap.bundle.min.js"></script>
  <!-- ^^^^^ -->
</body>

</html>