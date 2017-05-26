<?php
include_once __DIR__ . '/../config.php';

// Service response error codes.
define('SUCCESS', 0);
define('INTERNAL_FAILURE', 1);
define('INTERNAL_DATABASE_FAILURE', 2);
define('INVALID_CREDENTIAL', 3);
define('INVALID_USER_ID', 4);
define('INVALID_USER_NAME', 5);
define('INVALID_TOKEN', 6);
define('UNAUTHORIZED', 7);
define('ILLEGAL_ARGUMENT', 8);
define('ID_NOT_EXIST', 9);
define('USER_NAME_TAKEN', 10);
define('USER_NAME_NOT_EXIST', 11);

//define('CUSTOMER_PROFILE_EXIST', 100001);

class ResponseMessageMap {
  private static $response_message_map = [
      SUCCESS => 'Request completed successfully.',
      INTERNAL_FAILURE => 'Internal error. Please try again later.',
      INTERNAL_DATABASE_FAILURE => 'Internal database error. Please try again later.',
      INVALID_CREDENTIAL => 'Invalid user name or password.',
      INVALID_USER_ID => 'Invalid user id.',
      INVALID_USER_NAME => 'Invalid user name.',
      INVALID_TOKEN => 'Invalid user token.',
      UNAUTHORIZED => 'You are not authorized for this service call.',
      ILLEGAL_ARGUMENT => 'Some of the input values are invalid, please check again.',
      ID_NOT_EXIST => "Entity with id '%d' does not exist.",
      USER_NAME_TAKEN => "User name '%s' has already been taken.",
      USER_NAME_NOT_EXIST => "User name '%s' does not exist.",

//      CUSTOMER_PROFILE_EXIST => 'A customer profile already exists.',
  ];

  static function get_response_message($error_code) {
    return self::$response_message_map[$error_code];
  }
}

function response_message($response) {
  $message = ResponseMessageMap::get_response_message($response['error_code']);
  if (!empty($message)) {
    if (is_call_succeeded($response)) {
      return 'Success: ' . vsprintf($message, $response['ret_array']);
    } else {
      return 'Failure: ' . vsprintf($message, $response['ret_array']);
    }
  } else {
    return 'Unknown error code: ' . $response['error_code'];
  }
}
