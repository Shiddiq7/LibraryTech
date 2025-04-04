<?php
require '../func.php';

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statement for better security and performance
    $checkQuery = "SELECT * FROM user WHERE Email=? OR username=?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmt, "ss", $email, $username);
    mysqli_stmt_execute($stmt);
    $checkResult = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($checkResult) > 0) {
        echo '<div style="position: fixed; top: 0; right: 0; z-index: 9999;" class="alert alert-danger alert-dismissible fade show" role="alert">
                Email atau username sudah terdaftar!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    } else {
        // Generate id_user more efficiently
        $initials = strtoupper(substr($username, 0, 2));
        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM user WHERE if_visible = TRUE");
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $count);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        $count++;
        $id_user = $initials . str_pad($count, 4, '0', STR_PAD_LEFT);

        // Generate OTP
        $otp = generateOTP();
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Use prepared statement for insert
        $query = "INSERT INTO user (id_user, Email, username, password, verify) VALUES (?, ?, ?, ?, 0)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $id_user, $email, $username, $hashed_password);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            sendOTP($email, $otp, $username);
            header("location: verify_otp.php");
            exit();
        } else {
            echo "<script>alert('Registrasi gagal!')</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - LibraTech</title>
    <link rel="icon" href="../assets/img/logo1.png" type="image/png">
    <!-- Load only necessary CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('../assets/img/Libr.jpeg') no-repeat center center fixed;
            background-size: cover;
        }

        .card {
            border-radius: 1rem;
            background-color: rgba(90, 90, 90, 0.3);
            backdrop-filter: blur(25px);
        }
    </style>
</head>

<body class="bg-success">
    <section class="vh-100"
        style="background: url('../assets/img/Libr.jpeg') no-repeat center center fixed; background-size: cover;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-7">
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-12 col-lg-12 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form method="post">
                                        <div class="d-flex justify-content-center mb-3 pb-1">
                                            <img src="../assets/img/logo1.png" width="150px" height="120px" class="me-2"
                                                alt="Logo" />
                                        </div>

                                        <div class="d-flex justify-content-center mb-3 pb-1">
                                            <span class="h1 fw-bold mb-0" style="color: white;">LibraTech</span>
                                        </div>
                                        <h4 class="fw-normal mb-3 pb-3 text-center"
                                            style="letter-spacing: 1px; color: white;">
                                            Register to your account</h4>

                                        <label class="form-label fs-5" for="inputEmail"
                                            style="color: white;">Email</label>
                                        <div class="form-outline mb-4">
                                            <input type="text" id="inputEmail" name="email"
                                                class="form-control form-control-lg fs-5" required maxlength="50"
                                                minlength="1" placeholder="Example@gmail.com"
                                                onblur="if(!this.value.includes('@')) this.value += '@gmail.com';" />
                                        </div>

                                        <label class="form-label fs-5" for="inputUsername"
                                            style="color: white;">Username</label>
                                        <div class="form-outline mb-4">
                                            <input type="text" id="inputUsername" name="username"
                                                class="form-control form-control-lg fs-5" required maxlength="10"
                                                minlength="10" placeholder="Minimal 10 karakter" pattern="[A-Za-z0-9]+"
                                                title="Only letters and numbers are allowed" />
                                        </div>

                                        <label class="form-label fs-5" for="inputPassword"
                                            style="color: white;">Password</label>
                                        <div class="form-outline mb-4">
                                            <input type="password" id="inputPassword" name="password"
                                                class="form-control form-control-lg fs-5" required minlength="8"
                                                maxlength="8" placeholder="Minimal 8 karakter" pattern="[A-Za-z0-9]+"
                                                title="Only letters and numbers are allowed" />
                                        </div>

                                        <div class="form-check form-switch mt-1" style="margin-left: 10px;">
                                            <input class="form-check-input fs-5" type="checkbox" id="viewPassword"
                                                onclick="togglePassword()" />
                                            <label class="form-check-label fs-5" for="viewPassword"
                                                style="color: white;">Show Password</label>
                                        </div>
                                        <br><br>
                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg w-100 fs-5" type="submit" name="register"
                                                style="color: white; border-radius: 20px;">Register</button>
                                        </div>
                                        <p class="text-center mb-5 pb-lg-2 fs-5" style="color: white;">Already have an
                                            account? <a href="login.php" style="color: white;">Login here</a></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Load only necessary scripts at the end of body -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            var x = document.getElementById("inputPassword");
            x.type = x.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>