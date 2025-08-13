<?php
require_once 'db.php';
require 'config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $testimonial = trim($_POST['testimonial']);

    // Check if email is unique
    $check = $conn->prepare("SELECT id FROM testimonials WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $message = "<div class='alert alert-danger'>❌ You have already submitted a testimonial.</div>";
    } else {
        // Handle image upload
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $uploadDir = "uploads/testimonials/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $targetPath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            // Insert testimonial with status pending
            $stmt = $conn->prepare("INSERT INTO testimonials (name, email, testimonial, image, status) VALUES (?, ?, ?, ?, 'pending')");
            $stmt->bind_param("ssss", $name, $email, $testimonial, $imageName);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>✅ Thank you! Your testimonial has been submitted and is awaiting approval.</div>";
            } else {
                $message = "<div class='alert alert-danger'>❌ Database error. Please try again.</div>";
            }
            $stmt->close();
        } else {
            $message = "<div class='alert alert-danger'>❌ Failed to upload image. Please try again.</div>";
        }
    }
    $check->close();
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Add Testimonial</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <!-- Loader -->
    <!-- <div class="loader_bg">
        <div class="loader"></div>
    </div> -->

    <!-- Header -->
    <?php require "header.php" ?>

    <!-- Testimonial Form Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="text-center mb-4">Add Testimonial</h2>
                            
                            <!-- Show Message -->
                            <?php if ($message) echo $message; ?>

                            <form method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" placeholder="Your name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Your email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="testimonial" class="form-label fw-bold">Your Testimonial</label>
                                    <textarea id="testimonial" name="testimonial" class="form-control" placeholder="Write your testimonial..." rows="4" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label fw-bold">Upload Image</label>
                                    <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                                    <small id="imageError" class="text-danger" style="display:none;"></small>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Submit Testimonial</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- JS Files -->
    <script src="assets/js/vendor/jquery-3.6.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Image size validation -->
    <script>
        const imageInput = document.getElementById('image');
        const imageError = document.getElementById('imageError');

        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;

            const img = new Image();
            img.src = URL.createObjectURL(file);

            img.onload = function() {
                const width = img.naturalWidth;
                const height = img.naturalHeight;

                const requiredWidth = 310;
                const requiredHeight = 300;

                if (width !== requiredWidth || height !== requiredHeight) {
                    imageError.style.display = "block";
                    imageError.innerText = `Image must be exactly ${requiredWidth}×${requiredHeight}px. Current: ${width}×${height}px.`;
                    imageInput.value = '';
                } else {
                    imageError.style.display = "none";
                }
            };
        });
    </script>
</body>
</html>
