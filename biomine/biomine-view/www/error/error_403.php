<?php
include_once __DIR__ . '/../../inc/config.php';

class Error403 extends SimpleWebPage {

  protected function get_page_path() {
    return URL_ERROR_403_PAGE;
  }

  protected function get_twig_path() {
    return '/pages/error/error_403.twig';
  }
}

$page = new Error403();
$page->serve();
