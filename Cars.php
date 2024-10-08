<?php
// ulozeni vsech aut tady (skripta str. 14)
// pridani parametru konstruktoru pripojeni
// predavat pripojeni ze skriptu kde bude pouzivat cars metody
// uchovat spojeni
// vytvoreni privatniho properties
// $p_dbConn parametr p_dbConn
// $stmt je statement
// oznameni funkci getCars ze chci vysledek v asociativnim poli
// PDO nespolupracuje jen s mysql ale i s jinymi datatbazemi

class Cars
{
  private $dbConn;
  // predani konstruktoru jako parametr pripojeni do db
  public function __construct($dbConn)
  {
    $this->dbConn = $dbConn;
  }
  // metoda, ktera vrati z db vsechna auta (bez parametru)
  // zaslani dotazu do databaze
  public function getCars()
  {
    $query = 'SELECT * FROM cars';
    $stmt = $this->dbConn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


  // metoda, hledajici auta na zaklade zadanych parametru
  public function filterCars($brand, $model, $reg)
  {
    // pravdivostni podminka 1=1 (zdelsena verze WHERE brand LIKE '"%" . $p_brand . "%"') zjistovani jestli je pri vyhledavani neco jako jako treba "skoda" nebo "Skoda"
    $sql = 'SELECT * FROM cars WHERE 1=1';
    $params = [];


    //  pridani podminek do dotazu podle parametru
    // ochrana proti sequal injection
    if (!empty($brand)) {
      $sql .= " AND brand LIKE :brand";
      $params[':brand'] = '%' . $brand . '%';
    }
    if (!empty($model)) {
      $sql .= " AND model LIKE :model";
      $params[':model'] = '%' . $model . '%';
    }
    if (!empty($p_brand)) {
      $sql .= " AND reg LIKE :reg";
      $params[':reg'] = '%' . $reg . '%';
    }

    //  priprava SQL dotazu
    $stmt = $this->dbConn->prepare($sql);

    // bindovani hodnot, pokud byly parametry pridany
    // projizdeni asociativniho pole
    foreach ($params as $param => $value) {
      $stmt->bindValue($param, $value, PDO::PARAM_STR);
      // vysledky
    }
    // Vykonání SQL dotazu
    $stmt->execute();
    // Návrat výsledků jako pole asociativních polí
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  // mazani auta
  public function deleteCar($id)
  {
    $sql = 'DELETE FROM cars WHERE id = :id';
    $stmt = $this->dbConn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  // vraceni konkretniho auta
  public function getCar($id)
  {
    $sql = 'SELECT * FROM cars WHERE id = :id';
    $stmt = $this->dbConn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  // aktualizace existujiciho auta
  public function updateCar($id, $brand, $model, $reg, $km, $year)
  {
    $sql = "UPDATE cars SET brand = :brand, model =:model, reg = :reg, km =:km, year = :year WHERE id = :id";
    $stmt = $this->dbConn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
    $stmt->bindParam(':model', $model, PDO::PARAM_STR);
    $stmt->bindParam(':reg', $reg, PDO::PARAM_STR);
    $stmt->bindParam(':km', $km, PDO::PARAM_INT);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    return $stmt->execute();
  }

  // pridani auta
  public function addCar($brand, $model, $reg, $km, $year)
  {
    $sql = "INSERT INTO cars (brand,model,reg,km, year) VALUES (:brand, :model, :reg, :km, :year)";
    $stmt = $this->dbConn->prepare($sql);
    $stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
    $stmt->bindParam(':model', $model, PDO::PARAM_STR);
    $stmt->bindParam(':reg', $reg, PDO::PARAM_STR);
    $stmt->bindParam(':km', $km, PDO::PARAM_INT);
    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
    return $stmt->execute();
  }
}
