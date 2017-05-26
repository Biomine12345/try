<?php
include_once __DIR__ . '/../inc/config.php';

class Index extends SimpleWebPage {

  protected function get_twig_path() {
    return '/pages/index.twig';
  }
}

$page = new Index();
$page->serve();
