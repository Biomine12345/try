<?php
include_once __DIR__ . '/config.php';

switch(get_locale_id_in_url()) {
  case 'en':
    set_locale('en_US.UTF-8');
    define('HTML_LANG', 'en');
    break;
  case 'sc':
    set_locale('zh_CN.UTF-8');
    define('HTML_LANG', 'zh-Hans');
    break;
  case 'tc':
    set_locale('zh_TW.UTF-8');
    define('HTML_LANG', 'zh-Hant');
    break;
  default:
    set_locale('en_US.UTF-8');
    define('HTML_LANG', 'en');
    break;
}

// Specify the location of translation tables.
bindtextdomain('biomine', __DIR__ . '/../locale');
bind_textdomain_codeset('biomine', 'UTF-8');

// Specify the text domain.
textdomain('biomine');

function get_locale_id_in_url() {
  return explode(".", $_SERVER['HTTP_HOST'])[0];
}

function set_locale($locale) {
  putenv('LC_ALL=' . $locale);
  setlocale(LC_ALL, $locale);
}
