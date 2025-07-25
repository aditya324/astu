<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Nonprofit Charity</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="56x56" href="assets/images/fav-icon/icon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" media="all">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" media="all">
</head>
<body style="background-color: #f9fafb;">

    <section class="py-5 mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow-lg border-0 rounded-4 p-4">
                        <h2 class="text-center mb-4 fw-bold text-primary">Create Account</h2>

                        <?php
                        if (isset($_GET['error'])) {
                            $error = $_GET['error'];
                            if ($error == "passwordmismatch") {
                                echo '<div class="alert alert-danger">Passwords do not match.</div>';
                            } elseif ($error == "userexists") {
                                echo '<div class="alert alert-danger">Username already taken.</div>';
                            } else {
                                echo '<div class="alert alert-danger">An unknown error occurred.</div>';
                            }
                        }
                        ?>

                        <form action="signup_process.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" id="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="password" required>
                            </div>
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-lg btn-primary px-5">Sign Up</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="login.php">Already have an account? Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>
</html>