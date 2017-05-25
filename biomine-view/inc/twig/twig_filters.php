<?php
include_once __DIR__ . '/../config.php';
include_once __DIR__ . '/twig_config.php';

/**
 * Retrieves the response message from a response object.
 */
$twig->addFilter(new Twig_SimpleFilter('message', function($response) {
  return !empty($response) ? response_message($response) : '';
}));

/**
 * Outputs 'active' when the current url is equal to the input url.
 */
$twig->addFilter(new Twig_SimpleFilter('active_url', function($url) {
  return strcasecmp(get_request_uri(), $url) === 0 ? 'active' : '';
}));

/**
 * Outputs an array of translated strings.
 */
$twig->addFilter(new Twig_SimpleFilter('atrans', function($strings) {
  $trans = [];
  foreach ($strings as $string) {
    array_push($trans, _($string));
  }
  return $trans;
}));

/**
 * Outputs a string joining a limited number of elements.
 */
$twig->addFilter(new Twig_SimpleFilter('njoin', function($strings, $joiner, $max) {
  if (count($strings) <= $max) {
    return implode($joiner, $strings);
  } else {
    return implode($joiner, array_slice($strings, 0, $max)) . ', ...';
  }
}));

/**
 * Retrieves the displaying text for an enum value.
 */
$twig->addFilter(new Twig_SimpleFilter('e2t', function($enum) {
  $text = to_enum_text($enum);
  return !empty($text) ? $text : $enum;
}));

/**
 * Retrieves the entity of a specific id from an array.
 */
$twig->addFilter(new Twig_SimpleFilter('id', function($array, $id) {
  $key = array_search($id, array_column($array, 'id'));
  return $key !== false ? $array[$key] : null;
}));

/**
 * Retrieves the entity of a specific column value from an array.
 */
$twig->addFilter(new Twig_SimpleFilter('column', function($array, $column, $value) {
  $key = array_search($value, array_column($array, $column));
  return $key !== false ? $array[$key] : null;
}));

/**
 * Converts minutes to hours string.
 */
$twig->addFilter(new Twig_SimpleFilter('min2hour', function($minutes) {
  $hh = floor($minutes / 60);
  $mm = $minutes % 60;
  return sprintf("%02d", $hh) . ':' . sprintf("%02d", $mm);
}));

/**
 * Converts minutes to decimal hours string.
 */
$twig->addFilter(new Twig_SimpleFilter('min2hour2', function($minutes) {
  $decimal_hours = $minutes / 60;
  return number_format($decimal_hours, 2, '.', '');
}));

/**
 * Converts a number to its dollar notation. E.g. 1234.5 -> $1,234.50
 */
$twig->addFilter(new Twig_SimpleFilter('dollars', function($num) {
  return '$' . number_format($num, 2);
}));

/**
 * Converts a number to 0 decimals notation without thousands separators.
 */
$twig->addFilter(new Twig_SimpleFilter('decimals0', function($num) {
  if (is_numeric($num)) {
    return number_format($num, 0, '.', '');
  } else {
    return $num;
  }
}));

/**
 * Converts a number to two decimals notation without thousands separators.
 */
$twig->addFilter(new Twig_SimpleFilter('decimals2', function($num) {
  if (is_numeric($num)) {
    return number_format($num, 2, '.', '');
  } else {
    return $num;
  }
}));

/**
 * Truncates a string into the inputted size, and appends three dots to the end.
 */
$twig->addFilter(new Twig_SimpleFilter('truncate', function($string, $size) {
  if (strlen($string) <= $size) {
    return $string;
  } else {
    return array_shift(str_split($string, $size)) . '...';
  }
}));

/**
 * Decodes encoded html string. For example: &lt;p&gt; -> <p>.
 */
$twig->addFilter(new Twig_SimpleFilter('html_decode', function($encoded_html_string) {
  return html_entity_decode($encoded_html_string);
}));
