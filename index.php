<?php require_once 'config.php'; ?>
<?php
$festivals = Festival::findAll();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Music festivals</title>

  <link href="<?= APP_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?= APP_URL ?>/assets/css/template.css" rel="stylesheet">
  <link href="<?= APP_URL ?>/assets/css/style.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap" rel="stylesheet">


</head>

<body>
  <?php require 'include/backTop.php'; ?>
  <div class="container-fluid p-0">
    <?php require 'include/navbar.php'; ?>
    <main role="main">
      <div>
        <div class="row d-flex justify-content-center">
          <h1 class="t-peta engie-head mt-5 pt-5 pb-5">Our Festivals</h1>
        </div>



        <div class="row d-flex justify-content-center">
          <?php foreach ($festivals as $festival) { ?>
            <div class="col-md-12 col-lg-3 col-sm-12 pb-4">
              <div class="card card-block">
                <div class="myCard">
                  <?php
                  $festival_image = Image::findById($festival->image_id);
                  if ($festival_image !== null) {
                  ?>
                    <img src="<?= APP_URL . "/" . $festival_image->filename ?>" class="card-img-top" alt="...">
                  <?php
                  }
                  ?>
                  <div class="card-body underline myCardBody">
                    <h5 class="card-title t-deca myTitle"><?= $festival->title ?></h5>
                    <p class="card-text"><?= get_words($festival->description, 20) ?></p>
                    <p class="card-text">Location: <?= $festival->location ?></p>
                    <p class="card-text">Start date: <?= $festival->start_date ?></p>
                    <p class="card-text">End date: <?= $festival->end_date ?></p>
                    <div>
                      <a href="#" target="_new" class="findTickets">FIND YOUR TICKETS</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>

      </div>
    </main>
    <?php require 'include/footer.php'; ?>
  </div>
  <script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
  <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= APP_URL ?>/assets/js/script.js"></script>
  <script src="https://kit.fontawesome.com/fca6ae4c3f.js" crossorigin="anonymous"></script>

</body>

</html>