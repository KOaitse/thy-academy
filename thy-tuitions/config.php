<?php
session_start();

// Dynamic base URL calculation
$basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
define('BASE_URL', $basePath === DIRECTORY_SEPARATOR ? '/' : $basePath . '/');

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'thy_tuitions');
define('DB_USER', 'root');
define('DB_PASS', '');

// Other constants
define('SITE_NAME', 'Thy Academic Tuitions');