<?php
// Use this file once to generate a password hash, then delete it.
$plain_password = 'admin_password'; // Choose a strong password
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

echo "Username: admin<br>";
echo "Hashed Password: " . $hashed_password;

// Now, manually INSERT this into your 'users' table. For example:
// INSERT INTO users (username, password) VALUES ('admin', 'paste_the_hashed_password_here');
?>