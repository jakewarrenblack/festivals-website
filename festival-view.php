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
  <title>View Customer</title>

  <link href="<?= APP_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?= APP_URL ?>/assets/css/template.css" rel="stylesheet">
  <link href="<?= APP_URL ?>/assets/css/style.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap" rel="stylesheet">


</head>

<body>
  <div class="container-fluid p-0">
    <?php require 'include/navbar.php'; ?>
    <main role="main">
      <div>
        <div class="row d-flex justify-content-center">
          <h1 class="t-peta engie-head pt-5 pb-5">View Festival</h1>
        </div>

        <div class="row justify-content-center pt-4">
          <div class="col-lg-10">
            <form method="get">
              <!--This is how we pass the ID-->
              <input type="hidden" name="festival_id" value="<?= $festival->id ?>" />

              <!--Disabled so the user can't intereact. This form is for viewing only.-->
              <div class="form-group">
                <label class="labelHidden" for="ticketPrice">Title</label>
                <input placeholder="Title" type="text" id="title" class="form-control" value="<?= $festival->title ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="date">Description</label>
                <textarea name="description" rows="3" id="description" class="form-control" disabled><?= $festival->description ?></textarea>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="location">Location</label>
                <select class="form-control" name="location" id="location" disabled>
                  <option value="USA" <?= (($festival->location === "USA") ? "selected" : "") ?>>USA</option>
                  <option value="Belgium" <?= (($festival->location === "Belgium") ? "selected" : "") ?>>Belgium</option>>
                  <option value="Brazil" <?= (($festival->location === "Brazil") ? "selected" : "") ?>>Brazil</option>
                  <option value="UK" <?= (($festival->location === "UK") ? "selected" : "") ?>>UK</option>
                  <option value="Germany" <?= (($festival->location === "Germany") ? "selected" : "") ?>>Germany</option>
                  <option value="Japan" <?= (($festival->location === "Japan") ? "selected" : "") ?>>Japan</option>
                  <option value="Netherlands" <?= (($festival->location === "Netherlands") ? "selected" : "") ?>>Netherlands</option>
                  <option value="Hungary" <?= (($festival->location === "Hungary") ? "selected" : "") ?>>Hungary</option>
                  <option value="Morocco" <?= (($festival->location === "Morocco") ? "selected" : "") ?>>Morocco</option>
                  <option value="Spain" <?= (($festival->location === "Spain") ? "selected" : "") ?>>Spain</option>
                  <option value="Canada" <?= (($festival->location === "Canada") ? "selected" : "") ?>>Canada</option>
                  <option value="Croatia" <?= (($festival->location === "Croatia") ? "selected" : "") ?>>Croatia</option>
                  <option value="Philippines" <?= (($festival->location === "Philippines") ? "selected" : "") ?>>Philippines</option>
                </select>
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueCapacity">Start Date</label>
                <input placeholder="Start Date" type="date" class="form-control" id="startDate" value="<?= $festival->start_date ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueCapacity">End Date</label>
                <input placeholder="End Date" type="date" class="form-control" id="endDate" value="<?= $festival->end_date ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Contact Name</label>
                <input placeholder="Contact Name" type="text" id="contactName" class="form-control" value="<?= $festival->contact_name ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Contact Email</label>
                <input placeholder="Contact Email" type="email" id="contactEmail" class="form-control" value="<?= $festival->contact_email ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Contact Phone</label>
                <input placeholder="Contact Phone" type="text" id="contactPhone" class="form-control" value="<?= $festival->contact_phone ?>" disabled />
              </div>

              <div class="form-group">
                <label class="labelHidden" for="venueDescription">Image</label>
                <?php
                try {
                  $image = Image::findById($festival->image_id);
                } catch (Exception $e) {
                }
                if ($image !== null) {
                ?>
                  <img src="<?= APP_URL . "/" . $image->filename ?>" width="205px" alt="image" class="mt-2 mb-2" />
                <?php
                }
                ?>
              </div>

              <div class="form-group">
                <a class="btn btn-default" href="<?= APP_URL ?>/home.php">Cancel</a>
                <button class="btn btn-warning" formaction="<?= APP_URL ?>/festival-edit.php">Edit</button>
                <button class="btn btn-danger btn-festival-delete" formaction="<?= APP_URL ?>/festival-delete.php">Delete</button>
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