<?php
session_start();
// If user is already logged in, redirect to events page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: AddEvents.php");
    exit;
}



if (isset($_GET['success']) && $_GET['success'] == 'registered') {
    echo '<div class="alert alert-success">Registration successful! Please log in.</div>';
}
?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta charset="UTF-8">
    <title>Login - Nonprofit Charity</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="56x56" href="assets/images/fav-icon/icon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all">
</head>

<body style="background-color: #f9fafb;">
    <?php require "header.php" ?>

    <section class="py-5 mt-5"  >
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-lg border-0 rounded-4 p-4">
                        <h2 class="text-center mb-4 fw-bold text-primary">Admin Login</h2>

                        <?php
                        if (!empty($_GET["error"])) {
                            echo '<div class="alert alert-danger">Invalid username or password.</div>';
                        }
                        ?>

                        <form action="login_process.php" method="POST" style="margin-bottom: 10px;">
                            <div class="mb-3">
                                <label for="username" class="form-label"><i class="bi bi-person-fill"></i> Username</label>
                                <input type="text" name="username" class="form-control" id="username" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label"><i class="bi bi-lock-fill"></i> Password</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg btn-primary px-5">Login</button>
                            </div>
                        </form>
                        <!-- <div class="text-center mt-3">
                            <a href="signup.php">Don't have an account? Sign Up</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <?php require "footer.php" ?>
    </section>

    <script src="assets/js/vendor/jquery-3.6.2.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>