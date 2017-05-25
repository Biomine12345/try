<?php
/**
 * Commonly used helper functions. For convenience, all functions
 * are defined in the global namespace.
 */
include_once __DIR__ . '/../config.php';

function isRunningInDEVEL() {
  return isset($_SERVER['SERVER_TYPE']) && $_SERVER['SERVER_TYPE'] === 'DEVEL';
}

// This method avoids the Undefined index notices by PHP in the log files.
function _get($name){
  return isset($_GET[$name]) ? $_GET[$name] : null;
}

// This method avoids the Undefined index notices by PHP in the log files.
function _post($name){
  return isset($_POST[$name]) ? $_POST[$name] : null;
}

// This method avoids the Undefined index notices by PHP in the log files.
function _session($name){
  return isset($_SESSION[$name]) ? $_SESSION[$name] : null;
}

function get_user_id() {
  return _session(USER_ID);
}

function get_user_name() {
  return _session(USER_NAME);
}

function get_user_type() {
  return isset($_SESSION[USER_TYPE]) ? $_SESSION[USER_TYPE] : UNKNOWN;
}

function get_api_token() {
  return _session(API_TOKEN);
}

function get_user_model() {
  return _session(USER_MODEL);
}

function is_user() {
  return get_user_type() === USER;
}

function is_admin() {
  return get_user_type() === ADMIN;
}

/**
 * Only checks at the UI server side, does not check the API session.
 */
function is_login() {
  return isset($_SESSION[USER_ID]) && isset($_SESSION[USER_NAME])
      && isset($_SESSION[USER_TYPE]) && isset($_SESSION[API_TOKEN]);
}

function redirect($url) {
  header('Location: ' . $url);
  exit;
}

function redirect_login() {
  header('Location: ' . URL_LOGIN_PAGE . '?from=' . get_request_uri());
  exit;
}

function echo_forbidden() {
  header('HTTP/1.1 403 Forbidden');
  echo include(__DIR__ . '/../../www/error/error_403.php');
}

function get_php_self() {
  return htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8');
}

function get_request_uri() {
  return htmlspecialchars($_SERVER['REQUEST_URI'], ENT_QUOTES, 'UTF-8');
}

function current_time_millis() {
  list($usec, $sec) = explode(' ', microtime());
  return $sec . substr($usec, 2, 3);
}

function join_array($strings, $joiner = ',') {
  return $strings !== null ? implode($joiner, $strings) : null;
}

function sanitize($arr) {
  $new_array = [];
  foreach ($arr as $key => $value) {
    if ($key !== 'password') {
      $new_array[$key] = is_array($value) ? sanitize($value) : sanitize_str($value);
    } else {
      $new_array[$key] = $value;
    }
  }
  return $new_array;
}

function sanitize_str($text) {
  if (!empty($text)) {
    $text = trim($text);
    $text = stripslashes($text);
    $text = htmlspecialchars($text);
  }
  return $text;
}

function filter_array_nulls($arr) {
  return array_filter($arr, function ($value) {
    return $value !== null;
  });
}

function msec_to_us_date($milliseconds) {
  if (!empty($milliseconds)) {
    $date = DateTime::createFromFormat('U', $milliseconds / 1000);
    return $date->format("m/d/Y");
  } else {
    return null;
  }
}

function msec_to_std_date($milliseconds) {
  return us_to_std_date(msec_to_us_date($milliseconds));
}

function us_to_std_date($us_date) {
  if (!empty($us_date)) {
    $values = explode('/', $us_date);
    if (sizeof($values) === 3) {
      return $values[2] . '-' . $values[0] . '-' . $values[1];
    }
  }
  return $us_date;
}

function us_to_std_datetime($us_datetime) {
  if (!empty($us_datetime)) {
    $values = explode(' ', $us_datetime);
    return us_to_std_date($values[0]) . ' ' . $values[1];
  }
  return $us_datetime;
}

function ends_with($str, $test) {
  return substr_compare($str, $test, strlen($str)-strlen($test), strlen($test)) === 0;
}
