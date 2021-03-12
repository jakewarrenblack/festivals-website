<?php require_once 'config.php'; ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Form validation example</title>

  <link href="<?= APP_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?= APP_URL ?>/assets/css/template.css" rel="stylesheet">
  <link href="<?= APP_URL ?>/assets/css/style.css" rel="stylesheet">
</head>

<body>
  <div class="container-fluid p-0">
    <!-- <?php /*require 'include/header.php';*/ ?> -->
    <?php require 'include/navbar.php'; ?>
    <?php require "include/flash.php"; ?>









    <main role="main">
      <div class="row d-flex justify-content-center">
        <h1 class="t-peta engie-head mt-5 pt-5 pb-5">Register</h1>
      </div>

      <div class="row d-flex justify-content-center pt-4">
        <div class="col-lg-10">
          <form name='register' action="register.php" method="post">
            <div class="form-group">
              <label class="labelHidden" for="email">Email:</label>
              <input placeholder="Email" class="form-control" type="text" name="email" id="email" value="<?= old("email") ?>" />
              <span class="error"><?= error("email") ?></span>
            </div>

            <div class="form-group">
              <label class="labelHidden" for="password">Password:</label>
              <input placeholder="Password" class="form-control" type="password" name="password" id="password" />
              <span class="error"><?= error("password") ?></span>
            </div>

            <div class="form-group">
              <label class="labelHidden" for="name">Name:</label>
              <input placeholder="Name" class="form-control" type="text" name="name" id="name" value="<?= old("name") ?>" />
              <span class="error"><?= error("name") ?></span>
            </div>
            <button type="submit" class="btn myBtn btn-primary" name="submit" value="Submit">Submit</button>
          </form>
        </div>
      </div>
    </main>
    <?php require 'include/footer.php'; ?>
  </div>
  <script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
  <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>