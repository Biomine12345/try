<?php
/**
 * Parent class for all php files that serve as simple web pages. Such pages
 * do not handle http/ajax get or post requests.
 */
include_once __DIR__ . '/../config.php';
include_once __DIR__ . '/web_page.php';

abstract class SimpleWebPage extends WebPage {
  protected final function handle_simple_get() {}
  protected final function handle_simple_post() {}
  protected final function handle_ajax_get($method) {}
  protected final function handle_ajax_post($method) {}
}