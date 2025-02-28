<?php
require '../func.php';

// Register User
if (isset($_POST['register'])) {
    // Ensure $id_user is properly set
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check for duplicate email or username
    $checkQuery = "SELECT * FROM user WHERE Email='$email' OR username='$username'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo '<div style="position: fixed; top: 0; right: 0; z-index: 9999;" class="alert alert-danger alert-dismissible fade show" role="alert">
                Email atau username sudah terdaftar!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    } else {
        // Generate id_user
        $initials = strtoupper(substr($username, 0, 2)); // Get first two characters of username
        $query = "SELECT COUNT(*) as count FROM user WHERE if_visible = TRUE";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'] + 1; // Get the next user number
        $id_user = $initials . str_pad($count, 4, '0', STR_PAD_LEFT); // Combine initials and padded number

        // Generate OTP and store it in the session
        $otp = generateOTP();
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        $query = "INSERT INTO user (id_user, Email, username, password, verify) VALUES ('$id_user', '$email', '$username', '$hashed_password', 0)";
        $result = mysqli_query($conn, $query);

        if ($result) {
            sendOTP($email, $otp, $username);
            echo '<div style="position: fixed; top: 0; right: 0; z-index: 9999;" class="alert alert-success alert-dismissible fade show" role="alert">
                    Registrasi berhasil! Silakan cek email Anda untuk kode OTP.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            header("location: verify_otp.php");
        } else {
            echo "<script>alert('Registrasi gagal!')</script>";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" href="../assets/img/logo1.png" type="image/png" />
    <title>Register - LibraTech </title>
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: url('../assets/img/Libr.jpeg') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body class="bg-success">
    <section class="vh-100"
        style="background: url('../assets/img/Libr.jpeg') no-repeat center center fixed; background-size: cover;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-7">
                    <div class="card"
                        style="border-radius: 1rem; background-color: rgba(90, 90, 90, 0.3); backdrop-filter: blur(25px);">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>

    <!-- Toggle Password -->
    <script>
        function togglePassword() {
            var x = document.getElementById("inputPassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>