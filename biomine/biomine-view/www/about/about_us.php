<?php
include_once __DIR__ . '/../../inc/config.php';

class About extends SimpleWebPage {

  protected function get_twig_path() {
    return '/pages/about/about_us.twig';
  }
}

$page = new About();
$page->serve();
