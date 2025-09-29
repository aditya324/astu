<?php
// fetch $hash_from_db from the users table for username 'superadmin'
$hash_from_db = '$2b$10$D4kggLq4yyT1NZRqySSLl..AqNqoqkQGAb/CY01FJ8nKLGxuUsWse';
$entered = 'pass123';

if (password_verify($entered, $hash_from_db)) {
    echo "Password verified";
} else {
    echo "Invalid password";
}