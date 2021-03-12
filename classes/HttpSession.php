<?php
class HttpSession {
  public function __construct() {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
  }
  public function get($key) {
    if (isset($_SESSION) && is_array($_SESSION) && array_key_exists($key, $_SESSION)) {
      return $_SESSION[$key];
    }
    else return null;
  }
  public function has($key) {
    return (isset($_SESSION) && is_array($_SESSION) && array_key_exists($key, $_SESSION));
  }
  public function set($key, $value) {
    if (isset($_SESSION) && is_array($_SESSION)) {
      $_SESSION[$key] = $value;
    }
  }
  public function forget($key) {
    if (isset($_SESSION) && is_array($_SESSION) && array_key_exists($key, $_SESSION)) {
      unset($_SESSION[$key]);
    }
  }
  public function flush() {
    if (isset($_SESSION)) {
      session_unset ();
    }
  }
}
