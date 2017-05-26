<?php
include_once __DIR__ . '/constants_pages.php';
/**
 * Commonly used constant values and arrays. For convenience, all constants
 * are defined in the global namespace.
 */

// General constants
define('COMPANY_NAME', 'Biomine Lab Corp.');
define('COMPANY_NAME_SHORT', 'Biomine');
define('ADDRESS_LINE1', '41-60 Main Street, Suite 309B');
define('ADDRESS_LINE2', 'Flushing, NY 11355');
define('PHONE_NUMBER', '(718) 353-8801');
define('FAX_NUMBER', '(718) 353-8813');
define('EMAIL', 'info@biomine.us');

// Session data names.
define('USER_ID', 'USER_ID');
define('USER_NAME', 'USER_NAME');
define('USER_TYPE', 'USER_TYPE');
define('USER_MODEL', 'USER_MODEL');
define('API_TOKEN', 'API_TOKEN');
define('POST_RESPONSE', 'POST_RESPONSE');

// User types.
define('UNKNOWN', 'UNKNOWN');
define('USER', 'USER');
define('MANAGER', 'MANAGER');
define('ADMIN', 'ADMIN');

// Service urls.
define('URL_WEB_SERVICE', 'http://localhost:8080/biomine');
