<a id="top"></a>
<div id="backTop" class="backTop">
  <a href="#top"> <i class="fas fa-chevron-up" aria-hidden="true"></i></a>
</div>
<nav class="navbar fixed-top t-base myNav navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><i class="fas fa-headphones"></i><strong>Festivals Co</strong></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse reverseNav navbar-collapse " id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-link" href="<?= APP_URL ?>/index.php">Home</a>
      <a class="nav-link" href="#contact">Contact</a>
      <a class="nav-link" href="#schedule">Schedule</a>
      <a class="nav-link" href="#packages">Packages</a>
      <ul class="navbar-nav ml-auto">
        <?php if (!$request->session()->has("email")) { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= APP_URL ?>/login-form.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= APP_URL ?>/register-form.php">Register</a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= APP_URL ?>/logout.php">Logout</a>
          </li>
        <?php } ?>
      </ul>

    </div>
  </div>
</nav>