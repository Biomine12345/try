<?php
include_once __DIR__ . '/../config.php';
include_once __DIR__ . '/user_service.php';

function call_service($url, $parameters = ['' => ''], $privilege = false) {
  $curl = curl_init();

  // Set options.
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_URL, URL_WEB_SERVICE . $url);
  curl_setopt($curl, CURLOPT_ENCODING, ''); // Support All encodings for the response.

//  // Print header lines for debugging.
//  curl_setopt($curl, CURLOPT_HEADERFUNCTION, 'print_header');
//  function print_header($curl, $header_line) {
//    echo '<br>' . $header_line;
//    return strlen($header_line);
//  }

  // Encode JSON request.
  $parameters = empty($parameters) ? ['' => ''] : $parameters;
  $request_body = json_encode(create_request_body($parameters));
  curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);
  curl_setopt($curl, CURLOPT_HTTPHEADER, array_merge(create_request_header($url, $privilege), [
      'Content-Type: application/json',
      'Content-Length: ' . strlen($request_body)
  ]));
  $response = curl_exec($curl);
  curl_close($curl);

  // Decode JSON response.
  return json_decode($response, true);
}

function call_privilege_service($url, $parameters = ['' => '']) {
  if (is_login()) {
    $response = call_service($url, $parameters, true);
    if (is_api_token_invalid($response)) {
      destroy_session();
      redirect_login();
    } else {
      return $response;
    }
  } else {
    redirect_login();
  }
  exit;
}

function create_request_header($url, $privilege = false) {
  // Create header array.
  $header = ['Url: ' . $url];
  array_push($header, 'X-Client-IP: ' . $_SERVER['REMOTE_ADDR']);
  if ($privilege) {
    array_push($header, 'User-Id: ' . (!empty(get_user_id()) ? get_user_id() : 0));
    array_push($header, 'Authorization: Bearer ' . create_hash(get_api_token(), $url));
  }
  return $header;
}

function create_request_body($parameters) {
  return ['parameters' => $parameters];
}

function create_hash() {
  return hash('sha512', implode('_', array_map('strval', func_get_args())));
}

// http://php.net/manual/en/function.session-destroy.php
function destroy_session() {
  // Initialize the session.
  // If you are using session_name("something"), don't forget it now!
  session_start();

  // Unset all of the session variables.
  $_SESSION = [];

  // If it's desired to kill the session, also delete the session cookie.
  // Note: This will destroy the session, and not just the session data!
  if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
  }

  // Finally, destroy the session.
  session_destroy();
}
