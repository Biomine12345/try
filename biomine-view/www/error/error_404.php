<?php
include_once __DIR__ . '/../../inc/config.php';

class Error404 extends SimpleWebPage {

  protected function get_page_path() {
    return URL_ERROR_404_PAGE;
  }

  protected function get_twig_path() {
    return '/pages/error/error_404.twig';
  }
}

$page = new Error404();
$page->serve();
