<?php
session_start();
require_once 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];


    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $param_username);
        $param_username = $username;
        
        if ($stmt->execute()) {
            $stmt->store_result();
            
            // Check if username exists
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id, $username, $hashed_password);
                if ($stmt->fetch()) {

                    if (password_verify($password, $hashed_password)) {
       
                        session_start();
                        
                       
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;                            
                        
                
                        header("location: /admin/index.php");
                    } else {
                        // Password is not valid
                        header("location: login.php?error=invalid");
                    }
                }
            } else {
                // Username doesn't exist
                header("location: login.php?error=invalid");
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>