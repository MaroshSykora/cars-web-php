<?php
// vypis aut
include('DbConnect.php');
require_once('Cars.php');

// zavolani metody connect pro pripojeni do db (databaze)
$conn = new DbConnect();
$dbConnection = $conn->connect();
// vytvoreni instance Cars pomoci konstruktoru s parametrem pripojeni do db
$instanceCars = new Cars($dbConnection);
// zavolani metody pomoci instance
$cars = $instanceCars->getCars();
// $selCars = $cars;

// pokud jsme odeslali form pomoci metody get a jsou zadany tyto hodnoty v asoc. poli _GET, spusti se cast podminky za if index.php?brandneco&model=neco&reg=neco
if (isset($_GET['brand']) || isset($_GET['model']) || isset($_GET['reg'])) {
  $selBrand = $_GET['brand'];
  $selModel = $_GET['model'];
  $selReg = $_GET['reg'];
  $selCars = $instanceCars->filterCars($selBrand, $selModel, $selReg);
} else {
  // pokud nejsou vybrany vsechny polozky ve vyberu tak to i tak ukaze vysledek
  // pokud jsme nic neodeslali, pak tabulka vypise vsechny auta
  $selCars = $cars;
}


// mazani auta
// index.php?delete=10
if (isset($_GET['delete'])) {
  $carId = $_GET['delete'];
  $instanceCars->deleteCar($carId);
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
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
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
    <h2 class="h2">Vyhledávání</h2>
    <form action="index.php" method="get">
      <input class="form-control my-2" name="brand" type="text" placeholder="Zadejte značku" />
      <input class="form-control my-2" name="model" type="text" placeholder="Zadejte model" />
      <input class="form-control my-2" name="reg" type="text" placeholder="Zadejte registraci" />
      <input class="btn btn-primary my-2" type="submit" placeholder="Odešli" />
    </form>
    <?php
    if (sizeof($selCars) > 0) {

    ?>
      <table class="table">
        <tr>
          <th>ID</th>
          <th>Značka</th>
          <th>Model</th>
          <th>Registrace</th>
          <th>Kilometry</th>
          <th>Rok</th>
          <th>Akce</th>
        </tr>
        <?php foreach ($selCars as $car): ?>
          <tr>
            <td><?php echo $car['id']; ?></td>
            <td><?php echo $car['brand']; ?></td>
            <td><?php echo $car['model']; ?></td>
            <td><?php echo $car['reg']; ?></td>
            <td><?php echo $car['km']; ?></td>
            <td><?php echo $car['year']; ?></td>
            <td>
              <a class="btn btn-warning" href="edit.php?id=<?php echo $car['id']; ?>">Editovat</a>
              <a class="btn btn-warning" href="index.php?delete=<?php echo $car['id']; ?>" onclick="return confirm('Opravdu chcete smazat toto auto?');">Smazat</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>

    <?php
    } else { ?>
      <p>Žádná auta k zobrazení</p>
    <?php
    }
    ?>

  </div>

  <!-- SKRIPT BOOTSTRAP -->
  <script src="./bootstrap.bundle.min.js"></script>
  <!-- ^^^^^ -->
</body>

</html>