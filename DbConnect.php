<?php
class DbConnect
{
  private $server = 'sql304.ezyro.com';
  private $dbname = 'ezyro_35453681_carsdb';
  private $user = 'ezyro_35453681';
  private $pass = 'Bible1914';
  private $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false,
  );
  public function connect()
  {
    try {
      $conn = new PDO('mysql:host=' . $this->server . ';dbname=' . $this->dbname . ';charset=utf8', $this->user, $this->pass, $this->options);
      return $conn;
    } catch (PDOException $e) {
      echo "Database Error: " . $e->getMessage();
    }
  }
}
