<?php
include_once __DIR__ . '/locale.php';
include_once __DIR__ . '/permissions.php';
include_once __DIR__ . '/services/service_functions.php';
include_once __DIR__ . '/services/service_response.php';
include_once __DIR__ . '/services/service_response_code.php';
include_once __DIR__ . '/templates/simple_web_page.php';
include_once __DIR__ . '/templates/web_page.php';
include_once __DIR__ . '/twig/twig_config.php';
include_once __DIR__ . '/twig/twig_filters.php';
include_once __DIR__ . '/twig/twig_tests.php';
include_once __DIR__ . '/utils/constants.php';
include_once __DIR__ . '/utils/enums.php';
include_once __DIR__ . '/utils/utils.php';

// A non-empty session name is required to change the session.cookie_domain.
session_name('biomine');

// Compute and set the cookie domain. This is needed to share sessions across sub-domains.
if (substr_count($_SERVER['SERVER_NAME'], '.') <= 1) {
  $cookie_domain = '.' . $_SERVER['SERVER_NAME'];
  ini_set('session.cookie_domain', $cookie_domain);
} else {
  $cookie_domain = substr($_SERVER['SERVER_NAME'], strpos($_SERVER['SERVER_NAME'], '.'));
  ini_set('session.cookie_domain', $cookie_domain);
}

// Start a new session if not yet started.
if (empty(session_id())) {
  // Server should keep session data for at least 8 hours.
  ini_set('session.gc_maxlifetime', 28800);

  // Each client should remember their session id for exactly 8 hours.
  session_set_cookie_params(28800);

  session_start();
}

date_default_timezone_set('America/New_York');
