<?php
class User {
  public $id;
  public $email;
  public $password;
  public $name;

  function __construct() {
    $this->id = null;
  }

  public function save() {
    try {
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $params = [
        ":email" => $this->email,
        ":password" => $this->password,
        ":name" => $this->name
      ];
      if ($this->id === null) {
        $sql = "INSERT INTO users (email, password, name) VALUES (:email, :password, :name)";
      }
      else {
        $sql = "UPDATE users SET email = :email, password = :password, name = :name WHERE id = :id" ;
        $params[":id"] = $this->id;
      }
      $stmt = $conn->prepare($sql);
      $status = $stmt->execute($params);

      if (!$status) {
        $error_info = $stmt->errorInfo();
        $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($stmt->rowCount() !== 1) {
        throw new Exception("Failed to save user.");
      }

      if ($this->id === null) {
        $this->id = $conn->lastInsertId();
      }
    }
    finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }
  }

  public function delete() {
    $db = null;
    try {
      if ($this->id !== null) {
        $db = new DB();
        $db->open();
        $conn = $db->get_connection();

        $sql = "DELETE FROM users WHERE id = :id" ;
        $params = [
          ":id" => $this->id
        ];
        $stmt = $conn->prepare($sql);
        $status = $stmt->execute($params);

        if (!$status) {
          $error_info = $stmt->errorInfo();
          $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
          throw new Exception("Database error executing database query: " . $message);
        }

        if ($stmt->rowCount() !== 1) {
          throw new Exception("Failed to delete user.");
        }
      }
    }
    finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }
  }

  public static function findAll() {
    $users = array();

    try {
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $select_sql = "SELECT * FROM users";
      $select_stmt = $conn->prepare($select_sql);
      $select_status = $select_stmt->execute();

      if (!$select_status) {
        $error_info = $select_stmt->errorInfo();
        $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($select_stmt->rowCount() !== 0) {
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        while ($row !== FALSE) {
          $user = new User();
          $user->id = $row['id'];
          $user->email = $row['email'];
          $user->password = $row['password'];
          $user->name = $row['name'];
          $users[] = $user;

          $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        }
      }
    }
    finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }

    return $users;
  }

  public static function findById($id) {
    $user = null;

    try {
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $select_sql = "SELECT * FROM users WHERE id = :id";
      $select_params = [
        ":id" => $id
      ];
      $select_stmt = $conn->prepare($select_sql);
      $select_status = $select_stmt->execute($select_params);

      if (!$select_status) {
        $error_info = $select_stmt->errorInfo();
        $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($select_stmt->rowCount() !== 0) {
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        $user = new User();
        $user->id = $row['id'];
        $user->email = $row['email'];
        $user->password = $row['password'];
        $user->name = $row['name'];
      }
    }
    finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }

    return $user;
  }

  public static function findByEmail($email) {
    $user = null;

    try {
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $select_sql = "SELECT * FROM users WHERE email = :email";
      $select_params = [
        ":email" => $email
      ];
      $select_stmt = $conn->prepare($select_sql);
      $select_status = $select_stmt->execute($select_params);

      if (!$select_status) {
        $error_info = $select_stmt->errorInfo();
        $message = "SQLSTATE error code = ".$error_info[0]."; error message = ".$error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($select_stmt->rowCount() !== 0) {
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        $user = new User();
        $user->id = $row['id'];
        $user->email = $row['email'];
        $user->password = $row['password'];
        $user->name = $row['name'];
      }
    }
    finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }

    return $user;
  }
}
?>
