<?php
include_once __DIR__ . '/../../inc/config.php';

class ContactUs extends SimpleWebPage {

  protected function get_twig_path() {
    return '/pages/about/contact_us.twig';
  }
}

$page = new ContactUs();
$page->serve();
