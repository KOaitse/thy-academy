<?php
define('MAIL_HOST', 'smtp.yourdomain.com');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', 'noreply@yourdomain.com');
define('MAIL_PASSWORD', 'yourpassword');
define('MAIL_ENCRYPTION', 'tls');
define('MAIL_FROM_ADDRESS', 'noreply@yourdomain.com');
define('MAIL_FROM_NAME', 'Thy Academic Tuitions');

// For password reset emails
define('PASSWORD_RESET_SUBJECT', 'Password Reset Request');
define('PASSWORD_RESET_EXPIRY', 3600); // 1 hour in seconds

// For account verification
define('VERIFICATION_SUBJECT', 'Verify Your Account');
define('VERIFICATION_EXPIRY', 86400); // 24 hours in seconds
?>