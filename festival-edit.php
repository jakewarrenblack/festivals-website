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
} catch (Exception $ex) {
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alert-warning");

  $request->redirect("/home.php");
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Edit Festival</title>

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
          <h1 class="t-peta engie-head pt-5 pb-5">Edit Festival</h1>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-8">
            <?php require "include/flash.php"; ?>
          </div>
        </div>

        <div class="row justify-content-center pt-4">
          <div class="col-lg-10">
            <form method="post" action="<?= APP_URL ?>/festival-update.php" enctype="multipart/form-data">

              <!--This is how we pass the ID-->
              <input type="hidden" name="festival_id" value="<?= $festival->id ?>" />


              <div class="form-group">
                <label class="labelHidden" for="ticketPrice">Title</label>
                <input placeholder="Title" name="title" type="text" id="title" class="form-control" value="<?= old('title', $festival->title) ?>" />
                <span class="error"><?= error("title") ?></span>
              </div>

              <!--textarea does not have a 'value' attribute, so in this case we have to put our php for filling in the old form data INSIDE the textarea tag.-->
              <div class="form-group">
                <label class="labelHidden" for="date">Description</label>
                <textarea placeholder="Description" name="description" rows="3" id="description" class="form-control"><?= old('description', $festival->description) ?></textarea>
                <span class="error"><?= error("description") ?></span>
              </div>

              <div class="form-group">
                <label class="t-deci" for="location">Select your country</label>
                <select class="form-control" name="location" id="location">
                  <!--Check to see if the data in our form value was this location.-->
                  <option value="USA" <?= chosen("location", "USA", $festival->location) ? "selected" : "" ?>>USA</option>
                  <option value="Belgium" <?= chosen("location", "Belgium", $festival->location) ? "selected" : "" ?>>Belgium</option>
                  <option value="Brazil" <?= chosen("location", "Brazil", $festival->location) ? "selected" : "" ?>>Brazil</option>
                  <option value="UK" <?= chosen("location", "UK", $festival->location) ? "selected" : "" ?>>UK</option>
                  <option value="Germany" <?= chosen("location", "Germany", $festival->location) ? "selected" : "" ?>>Germany</option>
                  <option value="Japan" <?= chosen("location", "Japan", $festival->location) ? "selected" : "" ?>>Japan</option>
                  <option value="Netherlands" <?= chosen("location", "Netherlands", $festival->location) ? "selected" : "" ?>>Netherlands</option>
                  <option value="Hungary" <?= chosen("location", "Hungary", $festival->location) ? "selected" : "" ?>>Hungary</option>
                  <option value="Morocco" <?= chosen("location", "Morocco", $festival->location) ? "selected" : "" ?>>Morocco</option>
                  <option value="Spain" <?= chosen("location", "Spain", $festival->location) ? "selected" : "" ?>>Spain</option>
                  <option value="Canada" <?= chosen("location", "Canada", $festival->location) ? "selected" : "" ?>>Canada</option>
                  <option value="Croatia" <?= chosen("location", "Croatia", $festival->location) ? "selected" : "" ?>>Croatia</option>
                  <option value="Philippines" <?= chosen("location", "Philippines", $festival->location) ? "selected" : "" ?>>Philippines</option>
                </select>
                <span class="error"><?= error("location") ?></span>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="startDate">Start Date</label>
                <input placeholder="Start Date" type="date" name="start_date" class="dateInput form-control" id="startDate" value="<?= old("start_date", $festival->start_date) ?>" />
                <span class="error"><?= error("start_date") ?></span>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="endDate">End Date</label>
                <input placeholder="End Date" type="date" name="end_date" class="dateInput form-control" id="endDate" value="<?= old("end_date", $festival->end_date) ?>" />
                <span class="error"><?= error("end_date") ?></span>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Contact Name</label>
                <input placeholder="Contact Name" type="text" name="contact_name" id="contactName" class="form-control" value="<?= old("contact_name", $festival->contact_name) ?>" />
                <span class="error"><?= error("contact_name") ?></span>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Contact Email</label>
                <input placeholder="Contact Email" type="email" name="contact_email" id="contactEmail" class="form-control" value="<?= old("contact_email", $festival->contact_email) ?>" />
                <span class="error"><?= error("contact_email") ?></span>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Contact Phone</label>
                <input placeholder="Contact Phone" type="text" name="contact_phone" id="contactPhone" class="form-control" value="<?= old("contact_phone", $festival->contact_phone) ?>" />
                <span class="error"><?= error("contact_phone") ?></span>
              </div>


              <div class="form-group">
                <label>Profile image:</label>
                <?php
                $image = Image::findById($festival->image_id);
                if ($image != null) {
                ?>
                  <img src="<?= APP_URL . "/" . $image->filename ?>" width="150px" />
                <?php
                }
                ?>
                <input type="file" name="profile" id="profile" />
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