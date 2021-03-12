<?php require_once 'config.php'; ?>

<?php
if (!$request->is_logged_in()) {
  $request->redirect("/index.php");
}
$request->session()->forget('email');
$request->session()->forget('name');

$request->redirect("/index.php");
?>