<?php
require_once 'db.php'; // your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: signup.php?error=passwordmismatch");
        exit();
    }

    // 2. Check if username already exists
    $sql_check = "SELECT id FROM users WHERE username = ?";
    if ($stmt_check = $conn->prepare($sql_check)) {
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            header("Location: signup.php?error=userexists");
            exit();
        }
        $stmt_check->close();
    }

    // 3. Hash the password and insert the new user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql_insert = "INSERT INTO users (username, password) VALUES (?, ?)";
    if ($stmt_insert = $conn->prepare($sql_insert)) {
        $stmt_insert->bind_param("ss", $username, $hashed_password);
        
        if ($stmt_insert->execute()) {
            // Redirect to login page with a success message
            header("Location: login.php?success=registered");
            exit();
        } else {
            // Handle DB insertion error
            header("Location: signup.php?error=dberror");
            exit();
        }
        $stmt_insert->close();
    }
    $conn->close();
}
?>