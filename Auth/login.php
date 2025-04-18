<?php
require '../func.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements for security and better performance
    $query = "SELECT * FROM user WHERE username=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if ($row['verify'] == 1 && password_verify($password, $row['password'])) {
            $_SESSION['log'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role'];
            header("location:../" . ($row['role'] == 'Admin' ? 'Admin' : 'User') . "/dashboard.php");
            exit();
        }
        echo '<div style="position: fixed; top: 0; right: 0; z-index: 9999;" class="alert alert-danger alert-dismissible fade show" role="alert">
                Akun belum diverifikasi atau Username & Password Salah!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    } else {
        echo '<div style="position: fixed; top: 0; right: 0; z-index: 9999;" class="alert alert-danger alert-dismissible fade show" role="alert">
                Username atau Password Salah!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}

if (isset($_SESSION['log'])) {
    header('location:../' . ($_SESSION['role'] == 'Admin' ? 'Admin' : 'User') . '/dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - LibraTech</title>
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

<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-7"> <!-- Expanded the width of the card -->
                    <div class="card"
                        style="border-radius: 1rem; background-color: rgba(90, 90, 90, 0.3); backdrop-filter: blur(25px);">
                        <div class="card-body p-4 p-lg-5 text-black">
                            <form method="post">
                                <div class="d-flex justify-content-center align-items-center mb-3 pb-1">
                                    <img src="../assets/img/logo1.png" alt="Logo" width="150px" height="120px"
                                        class="me-2">
                                </div>
                                <div class="d-flex justify-content-center mb-3 pb-1">
                                    <span class="h1 fw-bold mb-0" style="color: white;">LibraTech</span>
                                </div>
                                <h4 class="fw-normal mb-3 pb-3 text-center" style="letter-spacing: 1px; color: white;">
                                    Login
                                    to your account</h4>

                                <label class="form-label fs-5" for="inputUsername"
                                    style="color: white;">Username</label>
                                <div class="form-outline mb-4">
                                    <label class="visually-hidden" for="inputUsername">Username</label>
                                    <input type="text" id="inputUsername" name="username"
                                        class="form-control form-control-lg fs-5" placeholder="Enter your Username"
                                        required maxlength="50" />
                                </div>

                                <label class="form-label fs-5" for="inputPassword"
                                    style="color: white;">Password</label>
                                <div class="form-outline mb-4">
                                    <input type="password" id="inputPassword" name="password"
                                        class="form-control form-control-lg fs-5" placeholder="Enter your password"
                                        required minlength="8" maxlength="8" />
                                </div>

                                <div class="form-check form-switch mt-1" style="margin-left: 10px;">
                                    <input class="form-check-input fs-5" type="checkbox" id="viewPassword"
                                        onclick="togglePassword()" />
                                    <label class="form-check-label fs-5" for="viewPassword" style="color: white;">Show
                                        Password </label>
                                </div>

                                <br><br>
                                <div class="pt-1 mb-4">
                                    <button class="btn btn-dark btn-lg w-100 fs-5" type="submit" name="login"
                                        style="color: white; border-radius: 20px;">Login</button>
                                </div>
                                <p class="text-center mb-5 pb-lg-2 fs-5" style="color: white;">Don't have an account? <a
                                        href="register.php" style="color: white;">Register here</a></p>

                            </form>
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