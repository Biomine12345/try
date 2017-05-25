<?php
include_once __DIR__ . '/../../inc/config.php';

class Error500 extends SimpleWebPage {

  protected function get_page_path() {
    return URL_ERROR_500_PAGE;
  }

  protected function get_twig_path() {
    return '/pages/error/error_500.twig';
  }
}

$page = new Error500();
$page->serve();
