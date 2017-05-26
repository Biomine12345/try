<?php
include_once __DIR__ . '/../config.php';
include_once __DIR__ . '/twig_config.php';

$twig->addTest(new Twig_SimpleTest('success', function($response) {
  return isset($response['error_code']) && is_call_succeeded($response);
}));

$twig->addTest(new Twig_SimpleTest('failure', function($response) {
  return isset($response['error_code']) && !is_call_succeeded($response);
}));

$twig->addTest(new Twig_SimpleTest('admin', function() {
  return is_admin();
}));
