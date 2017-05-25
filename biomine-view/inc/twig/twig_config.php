<?php
include_once __DIR__ . '/../config.php';
include_once __DIR__ . '/../utils/utils.php';
require_once __DIR__ . '/../../composer/vendor/autoload.php';

$loader = new Twig_Loader_Filesystem(__DIR__ . '/../../template');
$twig = new Twig_Environment($loader, ['cache' => __DIR__ . '/../../compilation_cache', 'auto_reload' => true]);
//$twig = new Twig_Environment($loader, ['debug' => true, 'cache' => __DIR__ . '/../../compilation_cache', 'auto_reload' => true]);

// Define global variables accessible in all templates.
$twig->addGlobal('IS_DEVEL_SERVER', isRunningInDEVEL());

// For debugging.
$twig->addExtension(new Twig_Extension_Debug());

// For i18n support.
$twig->addExtension(new Twig_Extensions_Extension_I18n());
