<?php

/**
 * Commonly used helper functions for enum values.
 */
include_once __DIR__ . '/../config.php';

const ENUM_TEXT_MAP = [
    // Order status
//    'UNPAID' => 'Unpaid',
];

function to_enum_text($enum) {
  return array_key_exists($enum, ENUM_TEXT_MAP) ? ENUM_TEXT_MAP[$enum] : $enum;
}
