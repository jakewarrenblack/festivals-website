<?php
class DB {
  private $server = DB_SERVER;
  private $database = DB_DATABASE;
  private $username = DB_USERNAME;
  private $password = DB_PASSWORD;

  private $conn;
  private $dsn;

  public function __construct() {
    $this->dsn = "mysql:host={$this->server};dbname={$this->database}";
    $this->conn = null;
  }

  public function open() {
    if ($this->conn === null) {
      $this->conn = new PDO($this->dsn, $this->username,$this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
  }

  public function is_open() {
    return $this->conn !== null;
  }

  public function get_connection() {
    return $this->conn;
  }

  public function close() {
    $this->conn = null;
  }
}
?>
