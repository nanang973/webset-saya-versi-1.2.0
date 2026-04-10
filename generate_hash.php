<?php
// Generate password hash
$password = 'admin123';
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "Password: admin123\n";
echo "Hash: " . $hash . "\n";
echo "\nUse this SQL to update:\n";
echo "UPDATE admin_users SET password = '" . $hash . "' WHERE username = 'admin';\n";
?>
