<?php require_once 'config.php';
?>

<!--Unlike in our festival-view.php, we don't have to find a customer ID in here.
All we want is a blank form.-->


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Create Festival</title>

  <link href="<?= APP_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?= APP_URL ?>/assets/css/template.css" rel="stylesheet">
  <link href="<?= APP_URL ?>/assets/css/style.css" rel="stylesheet">
  <link href="<?= APP_URL ?>/assets/css/form.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap" rel="stylesheet">


</head>

<body>
  <div class="container-fluid p-0">
    <?php require 'include/navbar.php'; ?>
    <main role="main">
      <div>
        <div class="row d-flex justify-content-center">
          <h1 class="t-peta engie-head pt-5 pb-5">Create Festival</h1>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <?php require "include/flash.php"; ?>
          </div>
        </div>

        <div class="row justify-content-center pt-4">
          <div class="col-lg-10">
            <!--Enctype tells the web server to send this off as a multipart request. We're telling the browser we want to attach a file to the request body.-->
            <form method="post" action="<?= APP_URL ?>/festival-store.php" enctype="multipart/form-data">
              <!--This is how we pass the ID-->

              <div class="form-group">
                <label class="labelHidden" for="ticketPrice">Title</label>
                <input placeholder="Title" name="title" type="text" id="title" class="form-control" value="<?= old('title') ?>" />
                <span class="error"><?= error("title") ?></span>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="date">Description</label>
                <textarea placeholder="Description" name="description" rows="3" id="description" class="form-control" value="<?= old('description') ?>"></textarea>
                <span class="error"><?= error("description") ?></span>
              </div>

              <div class="form-group">
                <label class="t-deci" for="location">Select your country</label>
                <select class="form-control" name="location" id="location">
                  <!--Check to see if the data in our form value was this location.-->
                  <option value="USA" <?= chosen("location", "USA") ? "selected" : "" ?>>USA</option>
                  <option value="Belgium" <?= chosen("location", "Belgium") ? "selected" : "" ?>>Belgium</option>
                  <option value="Brazil" <?= chosen("location", "Brazil") ? "selected" : "" ?>>Brazil</option>
                  <option value="UK" <?= chosen("location", "UK") ? "selected" : "" ?>>UK</option>
                  <option value="Germany" <?= chosen("location", "Germany") ? "selected" : "" ?>>Germany</option>
                  <option value="Japan" <?= chosen("location", "Japan") ? "selected" : "" ?>>Japan</option>
                  <option value="Netherlands" <?= chosen("location", "Netherlands") ? "selected" : "" ?>>Netherlands</option>
                  <option value="Hungary" <?= chosen("location", "Hungary") ? "selected" : "" ?>>Hungary</option>
                  <option value="Morocco" <?= chosen("location", "Morocco") ? "selected" : "" ?>>Morocco</option>
                  <option value="Spain" <?= chosen("location", "Spain") ? "selected" : "" ?>>Spain</option>
                  <option value="Canada" <?= chosen("location", "Canada") ? "selected" : "" ?>>Canada</option>
                  <option value="Croatia" <?= chosen("location", "Croatia") ? "selected" : "" ?>>Croatia</option>
                  <option value="Philippines" <?= chosen("location", "Philippines") ? "selected" : "" ?>>Philippines</option>
                </select>
                <span class="error"><?= error("location") ?></span>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="startDate">Start Date</label>
                <input placeholder="Start Date" type="date" name="start_date" class="dateInput form-control" id="startDate" value="<?= old("start_date") ?>" />
                <span class="error"><?= error("start_date") ?></span>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="endDate">End Date</label>
                <input placeholder="End Date" type="date" name="end_date" class="dateInput form-control" id="endDate" value="<?= old("end_date") ?>" />
                <span class="error"><?= error("end_date") ?></span>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Contact Name</label>
                <input placeholder="Contact Name" type="text" name="contact_name" id="contactName" class="form-control" value="<?= old("contact_name") ?>" />
                <span class="error"><?= error("contact_name") ?></span>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Contact Email</label>
                <input placeholder="Contact Email" type="email" name="contact_email" id="contactEmail" class="form-control" value="<?= old("contact_email") ?>" />
                <span class="error"><?= error("contact_email") ?></span>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Contact Phone</label>
                <input placeholder="Contact Phone" type="text" name="contact_phone" id="contactPhone" class="form-control" value="<?= old("contact_phone") ?>" />
                <span class="error"><?= error("contact_phone") ?></span>
              </div>

              <div class="form-group">
                <!--An uploaded file is moved into a temporary directory-->
                <label for="profile">Profile image:</label>
                <input type="file" name="profile" id="profile">
                <span class="error"><?= error("profile") ?></span>
              </div>

              <div class="form-group">
                <a class="btn btn-default" href="<?= APP_URL ?>/home.php">Cancel</a>
                <button type="submit" class="btn btn-primary">Store</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
    <?php require 'include/footer.php'; ?>
  </div>
  <script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
  <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= APP_URL ?>/assets/js/festival.js"></script>

  <script src="https://kit.fontawesome.com/fca6ae4c3f.js" crossorigin="anonymous"></script>

</body>

</html>