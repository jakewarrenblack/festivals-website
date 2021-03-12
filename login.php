<?php require_once 'config.php'; ?>
<?php
if ($request->is_logged_in()) {
  $request->redirect("/home.php");
}
try {
  $rules = [
    "email" => "present|email|minlength:7|maxlength:64",
    "password" => "present|minlength:8|maxlength:64"
  ];
  $request->validate($rules);
  if ($request->is_valid()) {
    $email = $request->input("email");
    $password = $request->input("password");
    $user = User::findByEmail($email);
    if ($user === null) {
      $request->set_error("email", "Email/password invalid");
    }
    else if ($user !== null) {
      if (!password_verify($password, $user->password)) {
        $request->set_error("email", "Email/password invalid");
      }
    }
  }
}
catch (Exception $ex) {
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alert-warning");
  $request->session()->set("flash_data", $request->all());
  $request->session()->set("flash_errors", $request->errors());

  $request->redirect("/login-form.php");  
}

if ($request->is_valid()) {
  $request->session()->set('email', $user->email);
  $request->session()->set('name', $user->name);
  $request->session()->forget("flash_data");
  $request->session()->forget("flash_errors");

  $request->redirect("/home.php");
}
else {
  $request->session()->set("flash_data", $request->all());
  $request->session()->set("flash_errors", $request->errors());

  $request->redirect("/login-form.php");
}
?>