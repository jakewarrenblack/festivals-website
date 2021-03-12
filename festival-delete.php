<?php require_once 'config.php';

try {
  $rules = [
    'festival_id' => 'present|integer|min:1'
  ];
  $request->validate($rules);
  if (!$request->is_valid()) {
    throw new Exception("Illegal request");
  }
  $festival_id = $request->input('festival_id');
  /*Retrieving a customer object*/
  $festival = Festival::findById($festival_id);
  if ($festival === null) {
    throw new Exception("Illegal request parameter");
  }

  $festival->delete();

  $request->session()->set("flash_message", "The festival was successfully deleted from the database");
  $request->session()->set("flash_message_class", "alert-info");
  $request->redirect("/home.php");
} catch (Exception $ex) {
  /*If something goes wrong, catch the message and store it as a flash message.*/
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alert-warning");

  $request->redirect("/home.php");
}
