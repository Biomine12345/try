<?php
include_once __DIR__ . '/config.php';
include_once __DIR__ . '/utils/constants.php';

const PERMISSIONS = [
    // ./
    URL_DEFAULT_PAGE             => [UNKNOWN => true, USER => true, MANAGER => true, ADMIN => true],
    URL_INDEX_PAGE               => [UNKNOWN => true, USER => true, MANAGER => true, ADMIN => true],
    URL_LOGIN_PAGE               => [UNKNOWN => true, USER => true, MANAGER => true, ADMIN => true],
    URL_LOGOUT_PAGE              => [UNKNOWN => true, USER => true, MANAGER => true, ADMIN => true],
    URL_REGISTER_PAGE            => [UNKNOWN => true, USER => true, MANAGER => true, ADMIN => true],
    URL_COMMON_PAGE              => [UNKNOWN => true, USER => true, MANAGER => true, ADMIN => true],

    // ./error/
    URL_ERROR_403_PAGE           => [UNKNOWN => true, USER => true, MANAGER => true, ADMIN => true],
    URL_ERROR_404_PAGE           => [UNKNOWN => true, USER => true, MANAGER => true, ADMIN => true],
    URL_ERROR_500_PAGE           => [UNKNOWN => true, USER => true, MANAGER => true, ADMIN => true],

    // ./about/
    URL_ABOUT_ABOUT_US_PAGE      => [UNKNOWN => true, USER => true, MANAGER => true, ADMIN => true],
    URL_ABOUT_CONTACT_US_PAGE    => [UNKNOWN => true, USER => true, MANAGER => true, ADMIN => true],
];

function check_permission($page_url) {
  // Get the current user's user type.
  $user_type = get_user_type();
  $user_type = empty($user_type) ? UNKNOWN : $user_type;

  // Remove page parameters.
  if (strpos($page_url, '?') !== false) {
    $page_url = substr($page_url, 0, strpos($page_url, '?'));
  }

  // Check permission in the permission matrix.
  if (!empty(PERMISSIONS[$page_url])) {
    return PERMISSIONS[$page_url][$user_type] === true; /* Use explicit comparison. */
  } else {
    return false;
  }
}
