<?php
class Festival
{
  public $id;
  public $title;
  public $description;
  public $location;
  public $start_date;
  public $end_date;
  public $contact_name;
  public $contact_email;
  public $contact_phone;
  public $image_id;

  public function __construct()
  {
    $this->id = null;
  }

  public function save()
  {
    try {
      /*Create connection.*/
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $params = [
        ":title" => $this->title,
        ":description" => $this->description,
        ":location" => $this->location,
        ":start_date" => $this->start_date,
        ":end_date" => $this->end_date,
        ":contact_name" => $this->contact_name,
        ":contact_email" => $this->contact_email,
        ":contact_phone" => $this->contact_phone,
        ":image_id" => $this->image_id
      ];

      /*Before we fixed this, our update and add would do the same thing.
        Here we'll update our save method to only create a new festival if 
        the festival is new.*/


      if ($this->id === null) {
        $sql = "INSERT INTO festivals (" .
          "title, description, location, start_date, end_date, contact_name, contact_email, contact_phone, image_id" .
          ") VALUES (" .
          ":title, :description, :location, :start_date, :end_date, :contact_name, :contact_email, :contact_phone, :image_id" .
          ")";
      } else {
        $sql = "UPDATE festivals SET " .
          "title = :title, " .
          "description = :description, " .
          "location = :location, " .
          "start_date = :end_date, " .
          "end_date = :end_date, " .
          "contact_name = :contact_name, " .
          "contact_email = :contact_email, " .
          "contact_phone = :contact_phone, " .
          "image_id = :image_id " .
          "WHERE id = :id";
        $params[":id"] = $this->id;
      }


      $stmt = $conn->prepare($sql);
      $status = $stmt->execute($params);

      if (!$status) {
        $error_info = $stmt->errorInfo();
        $message = "SQLSTATE error code = " . $error_info[0] . "; error message = " . $error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($stmt->rowCount() !== 1) {
        throw new Exception("Failed to save festival.");
      }

      /*Customer won't have an ID, so retrieve the ID assigned by the DB.*/
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
    try {
      /*Create connection.*/
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $sql = "DELETE FROM festivals WHERE id = :id";
      $params = [
        ":id" => $this->id
      ];

      $stmt = $conn->prepare($sql);
      $status = $stmt->execute($params);

      if (!$status) {
        $error_info = $stmt->errorInfo();
        $message = "SQLSTATE error code = " . $error_info[0] . "; error message = " . $error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($stmt->rowCount() !== 1) {
        throw new Exception("Failed to delete festival.");
      }
    } finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }
  }

  public static function findAll()
  {
    $festivals = array();

    try {
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $select_sql = "SELECT * FROM festivals";
      $select_stmt = $conn->prepare($select_sql);
      $select_status = $select_stmt->execute();

      if (!$select_status) {
        $error_info = $select_stmt->errorInfo();
        $message = "SQLSTATE error code = " . $error_info[0] . "; error message = " . $error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($select_stmt->rowCount() !== 0) {
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        while ($row !== FALSE) {
          $festival = new Festival();
          $festival->id = $row['id'];
          $festival->title = $row['title'];
          $festival->description = $row['description'];
          $festival->location = $row['location'];
          $festival->start_date = $row['start_date'];
          $festival->end_date = $row['end_date'];
          $festival->contact_name = $row['contact_name'];
          $festival->contact_email = $row['contact_email'];
          $festival->contact_phone = $row['contact_phone'];
          $festival->image_id = $row['image_id'];
          $festivals[] = $festival;

          $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        }
      }
    } finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }

    return $festivals;
  }



  public static function findById($id)
  {
    $festival = null;


    try {
      $db = new DB();
      $db->open();
      $conn = $db->get_connection();

      $select_sql = "SELECT * FROM festivals WHERE id = :id";
      $select_params = [
        ":id" => $id
      ];

      $select_stmt = $conn->prepare($select_sql);
      $select_status = $select_stmt->execute($select_params);

      if (!$select_status) {
        $error_info = $select_stmt->errorInfo();
        $message = "SQLSTATE error code = " . $error_info[0] . "; error message = " . $error_info[2];
        throw new Exception("Database error executing database query: " . $message);
      }

      if ($select_stmt->rowCount() !== 0) {
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);

        $festival = new Festival();
        $festival->id = $row['id'];
        $festival->title = $row['title'];
        $festival->description = $row['description'];
        $festival->location = $row['location'];
        $festival->start_date = $row['start_date'];
        $festival->end_date = $row['end_date'];
        $festival->contact_name = $row['contact_name'];
        $festival->contact_email = $row['contact_email'];
        $festival->contact_phone = $row['contact_phone'];
        $festival->image_id = $row['image_id'];
      }
    } finally {
      if ($db !== null && $db->is_open()) {
        $db->close();
      }
    }

    return $festival;
  }











  /*Attempt at findbyid function*/

  // public static function findById($id)
  // {

  //   try {
  //     $db = new DB();
  //     $db->open();
  //     $conn = $db->get_connection();

  //     $select_sql = 'SELECT * FROM festivals'  . ' WHERE id = ' . $id;
  //     $select_stmt = $conn->prepare($select_sql);
  //     $select_status = $select_stmt->execute();

  //     if (!$select_status) {
  //       $error_info = $select_stmt->errorInfo();
  //       $message = "SQLSTATE error code = " . $error_info[0] . "; error message = " . $error_info[2];
  //       throw new Exception("Database error executing database query: " . $message);
  //     }

  //     if ($select_stmt->rowCount() !== 0) {
  //       $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  //       while ($row !== FALSE) {
  //         $data = $select_stmt->fetch();
  //       }
  //     }
  //   } finally {
  //     if ($db !== null && $db->is_open()) {
  //       $db->close();
  //     }
  //   }

  //   return $data;
  // }


  /*Attempt at find functon*/

  // public static function find($id)
  // {
  //   $params = array(
  //     'id' => $id
  //   );


  //   try {
  //     $db = new DB();
  //     $db->open();
  //     $conn = $db->get_connection();

  //     $select_sql = 'SELECT * FROM festivals WHERE id = :id';
  //     $select_stmt = $conn->prepare($select_sql);
  //     $select_status = $select_stmt->execute($params);

  //     if (!$select_status) {
  //       $error_info = $select_stmt->errorInfo();
  //       $message = "SQLSTATE error code = " . $error_info[0] . "; error message = " . $error_info[2];
  //       throw new Exception("Database error executing database query: " . $message);
  //     }

  //     if ($select_stmt->rowCount() !== 0) {
  //       $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  //       while ($row !== FALSE) {
  //         $festival = $select_stmt->fetchObject('Festival');
  //       }
  //     }
  //   } finally {
  //     if ($db !== null && $db->is_open()) {
  //       $db->close();
  //     }
  //   }

  //   return $festival;
  // }



  /*Attempt at selectAll function*/


  // public static function selectAll($tableName)
  // {

  //   try {
  //     $db = new DB();
  //     $db->open();
  //     $conn = $db->get_connection();

  //     $select_sql = 'SELECT * FROM ' . $tableName;
  //     $select_stmt = $conn->prepare($select_sql);
  //     $select_status = $select_stmt->execute();

  //     if (!$select_status) {
  //       $error_info = $select_stmt->errorInfo();
  //       $message = "SQLSTATE error code = " . $error_info[0] . "; error message = " . $error_info[2];
  //       throw new Exception("Database error executing database query: " . $message);
  //     }

  //     if ($select_stmt->rowCount() !== 0) {
  //       $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
  //       while ($row !== FALSE) {
  //         $data = $select_stmt->fetch();
  //       }
  //     }
  //   } finally {
  //     if ($db !== null && $db->is_open()) {
  //       $db->close();
  //     }
  //   }

  //   return $data;
  // }
}
