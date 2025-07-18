<?php
require_once 'db.php';

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $venue = $_POST['venue'];

    
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $upload_dir = 'uploads/';

    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $image_path = $upload_dir . basename($image_name);
    move_uploaded_file($image_tmp, $image_path);

    $stmt = $conn->prepare("INSERT INTO events (title, description, event_date, event_time, venue, image_path) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $title, $description, $event_date, $event_time, $venue, $image_path);

    if ($stmt->execute()) {
        echo "✅ Event added successfully!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
