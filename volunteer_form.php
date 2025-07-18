<?php
require 'db.php';
require 'mailer.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['full_name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $city     = $_POST['city'];
    $interest = $_POST['interest'];
    $message  = $_POST['message'];

    // Insert into DB
    $stmt = $mysqli->prepare("INSERT INTO volunteers (full_name, email, phone, city, interest, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $phone, $city, $interest, $message);

    if ($stmt->execute()) {
        // Send email
        $body = "
            <h3>New Volunteer Registration</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>City:</strong> $city</p>
            <p><strong>Interest:</strong> $interest</p>
            <p><strong>Message:</strong><br>$message</p>
        ";
        sendMail("New Volunteer Registration", $body);
        echo "Thank you for registering as a volunteer!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
