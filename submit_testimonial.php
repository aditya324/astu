<?php
require 'db.php'; // Your DB connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $testimonial = trim($_POST['testimonial']);

    // Handle image upload
    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $uploadDir = "uploads/testimonials/";

    // Create folder if not exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $targetPath = $uploadDir . basename($imageName);

    // Move uploaded file
    if (move_uploaded_file($imageTmp, $targetPath)) {
        // Save to DB as pending
        $stmt = $conn->prepare("INSERT INTO testimonials (name, email, testimonial, image, status) VALUES (?, ?, ?, ?, 'pending')");
        $stmt->bind_param("ssss", $name, $email, $testimonial, $imageName);

        if ($stmt->execute()) {
            echo "<p>✅ Thank you! for submitting your testimonial</p>";
        } else {
            echo "<p>❌ Error saving testimonial. Please try again.</p>";
        }
        $stmt->close();
    } else {
        echo "<p>❌ Failed to upload image.</p>";
    }
}
?>
