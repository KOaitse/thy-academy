<?php
require_once __DIR__ . '/../../lib/Auth.php';

$auth = new Auth($pdo);
$auth->logout();

// Redirect to login page
header('Location: /pages/auth/login.php');
exit;
?>