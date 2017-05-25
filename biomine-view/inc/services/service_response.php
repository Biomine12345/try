<?php
include_once __DIR__ . '/../config.php';

/**
 * To avoid double submission when a user refreshes a POST response page, we use
 * the Post/Redirect/Get design pattern, which, instead of redirecting the user to
 * the response page, tells (through 303 response code) the browser to initiate a
 * GET request to the page which we want the user to redirected to.
 *
 * @param $response     : the response.
 * @param $redirect_url : the url which the browser should redirect to.
 */
function redirect_post_response($response, $redirect_url = null) {
  save_post_response($response);

  $redirect_url = empty($redirect_url) ? get_request_uri() : $redirect_url;

  // Use a 303 response code to tell the browser to send a GET request to $redirect_url.
  header('Location: ' . $redirect_url, true, 303);
  exit;
}

function save_post_response($response) {
  $_SESSION[POST_RESPONSE] = $response;
}

function has_post_response() {
  return isset($_SESSION[POST_RESPONSE]);
}

function get_post_response() {
  return has_post_response() ? $_SESSION[POST_RESPONSE] : null;
}

function clear_post_response() {
  unset($_SESSION[POST_RESPONSE]);
}

function is_call_succeeded($response) {
  return $response['error_code'] === SUCCESS;
}

function is_api_token_invalid($response) {
  return $response['error_code'] === INVALID_TOKEN;
}
