<?php
class Image
{
  public $id;
  public $filename;

  public function __construct()
  {
    $this->id = null;
  }

  public function save()
  {
    try {
      /*Connect to the database*/
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $params = [
        ":filename" => $this->filename
      ];

      /*Execute our SQL query*/
      if ($this->id === null) {
        $sql = "INSERT INTO images (filename) VALUES (:filename)";
      } else {
        /*If there's already an image, update it rather than add a new one.*/
        $sql = "UPDATE images SET filename = :filename WHERE id = :id";
        $params[":id"] = $this->id;
      }
      $stmt = $conn->prepare($sql);
      $status = $stmt->execute($params);

      /*Check to see if something goes wrong*/
      if (!$status) {
        $error_info = $stmt->errorInfo();
        $message = "SQLSTATE error code =  " . $error_info[0] . "; error message = " . $error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      /*Make sure we've inserted at least one row*/
      if ($stmt->rowCount() !== 1) {
        throw new Exception("Failed to save image.");
      }

      if ($this->id === null) {
        $this->id = $conn->lastInsertId();
      }
    } finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }
  }

  public function delete()
  {
    throw new Exception("Not yet implemented!");
  }

  public function findAll()
  {
    throw new Exception("Not yet implemented!");
  }

  public static function findById($id)
  {
    $image = null;
    try {
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $select_sql = "SELECT * FROM images WHERE id = :id";
      $params = [
        ':id' => $id
      ];
      $select_stmt = $conn->prepare($select_sql);
      $select_status = $select_stmt->execute($params);

      if (!$select_status) {
        $error_info = $select_stmt->errorInfo();
        $message = "SQLSTATE error code =  " . $error_info[0] . "; error message = " . $error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      /*If at least one row retrieved, store the details of that row in an image object.*/
      if ($select_stmt->rowCount() !== 0) {
        $row = $select_stmt->Fetch(PDO::FETCH_ASSOC);
        $image = new Image();
        $image->id = $row['id'];
        $image->filename = $row['filename'];
      }
    } finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }

    /*Return our image object.*/
    return $image;
  }
}
