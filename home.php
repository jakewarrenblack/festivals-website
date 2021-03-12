<?php
require_once 'config.php';

if (!$request->is_logged_in()) {
  $request->redirect("/login-form.php");
}

try {
  $festivals = Festival::findAll();
} catch (Exception $ex) {
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alrt-warning");
  $festivals = [];
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Festivals</title>

  <link href="<?= APP_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?= APP_URL ?>/assets/css/template.css" rel="stylesheet">
  <link href="<?= APP_URL ?>/assets/css/style.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap" rel="stylesheet">


</head>

<body>
  <?php require 'include/backTop.php'; ?>
  <div class="container-fluid p-0">
    <!-- <?php /*require 'include/header.php';*/ ?> -->
    <?php require 'include/navbar.php'; ?>

    <main role="main">
      <br class="mt-5">
      <h1 class="text-center">Festivals</h1>
      <p class="text-center">Welcome, <?= $request->session()->get("name") ?>. This is your home page!</p>
      <br>

      <?php require "include/flash.php"; ?>
      <br>


      <div class="row justify-content-center">
        <div class="col-11 pr-0 d-flex justify-content-end">
          <a href="<?= APP_URL . '/festival-create.php' ?>">
            <button class="btn w-100 myBtn ml-0 btn-primary">Add</button>
          </a>
        </div>

        <form class="col-lg-11 p-0" method="get">
          <div class="col-lg-12 p-0 d-flex flex-column w-100 userTableCont">
            <table id="#userTable" class="table userTable w-100 table-borderless">
              <thead>
                <tr>
                  <th>&nbsp;</th>
                  <th scope="col">
                    <div classs="th-align">
                      Title<i class="ml-4 fas fa-angle-down"></i>
                    </div>
                  </th>
                  <th scope="col">
                    <div class="th-align">
                      Description<i class="ml-4 fas fa-angle-down"></i>
                    </div>
                  </th>
                  <th scope="col">
                    <div class="th-align">
                      Location<i class="ml-4 fas fa-angle-down"></i>
                    </div>
                  </th>
                  <th scope="col">
                    <div class="th-align">
                      Start Date<i class="ml-4 fas fa-angle-down"></i>
                    </div>
                  </th>
                  <th scope="col">
                    <div class="th-align">
                      End Date<i class="ml-4 fas fa-angle-down"></i>
                    </div>
                  </th>
                  <th scope="col">
                    <div class="th-align">
                      Contact Name<i class="ml-4 fas fa-angle-down"></i>
                    </div>
                  </th>
                  <th scope="col">
                    <div class="th-align">
                      Contact Email<i class="ml-4 fas fa-angle-down"></i>
                    </div>
                  </th>
                  </th>
                  <th scope="col">
                    <div class="th-align">
                      Contact Phone<i class="ml-4 fas fa-angle-down"></i>
                    </div>
                  </th>
                  <th>&nbsp;</th>
                  <th scope="col">Edit<i class="ml-4 fas fa-angle-down"></i></th>
                  <th scope="col">Delete<i class="ml-4 fas fa-angle-down"></i></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($festivals as $festival) { ?>
                  <tr>
                    <td><input type="radio" name="festival_id" value="<?= $festival->id ?>" /></td>
                    <td><?= $festival->title ?></td>
                    <!--Descriptions are too long, get 20char substring-->
                    <td><?= substr($festival->description, 0, 20) ?></td>
                    <td><?= $festival->location ?></td>
                    <td><?= $festival->start_date ?></td>
                    <td><?= $festival->end_date ?></td>
                    <td><?= $festival->contact_name ?></td>
                    <td><?= $festival->contact_email ?></td>
                    <td><?= $festival->contact_phone ?></td>
                    <td><?php
                        $festival_image = Image::findById($festival->image_id);
                        if ($festival_image !== null) {
                        ?>
                        <img src="<?= APP_URL . "/" . $festival_image->filename ?>" width="50px" />
                      <?php
                        }
                      ?>
                    </td>
                    <td scope="row"><i class="ml-4 fas fa-pen"></i></td>
                    <td scope="row"><i class="ml-4 fas fa-trash"></i></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <div class="row d-flex p-0 m-0 ml-2 mb-2">
              <button class="btn btn-info mr-2 btn-festival" formaction="<?= APP_URL ?>/festival-view.php">View</button>
              <button class="btn btn-warning mr-2 btn-festival" formaction="<?= APP_URL ?>/festival-edit.php">Edit</button>
              <button class="btn btn-danger mr-2 btn-festival btn-festival-delete" formaction="<?= APP_URL ?>/festival-delete.php">Delete</button>
            </div>
          </div>
        </form>
      </div>
    </main>
    <?php require 'include/footer.php'; ?>
  </div>
  <script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
  <script src="<?= APP_URL ?>/assets/js/script.js"></script>
  <script src="<?= APP_URL ?>/assets/js/festival.js"></script>
  <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/fca6ae4c3f.js" crossorigin="anonymous"></script>
</body>

</html>