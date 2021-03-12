<?php
define('APP_URL', 'http://localhost/awdd/festivals-website-1-jakewarrenblack');

define('DB_SERVER', 'localhost');
define('DB_DATABASE', 'festivals');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

set_include_path(
  get_include_path() . PATH_SEPARATOR . dirname(__FILE__)
);

spl_autoload_register(function ($class_name) {
  require_once 'classes/' . $class_name . '.php';
});

require_once "lib/global.php";

if (!isset($request)) {
  $request = new HttpRequest();
}
