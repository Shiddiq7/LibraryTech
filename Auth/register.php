<?php
require '../func.php';

// Register
if (isset($_POST['register'])) {
    $id_user = $_POST['id_user'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate id_user
    $initials = strtoupper(substr($username, 0, 2)); // Get first two characters of username
    $query = "SELECT COUNT(*) as count FROM user WHERE if_visible = TRUE";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'] + 1; // Get the next user number
    $id_user = $initials . str_pad($count, 4, '0', STR_PAD_LEFT); // Combine initials and padded number


    $query = "INSERT INTO user ( id_user, Email ,username, password) VALUES ( '$id_user' ,' $email ','$username', '$hashed_password')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Registrasi berhasil!')</script>";
        header("location: login.php");
    } else {
        echo '<div style="position: fixed; top: 0; right: 0; z-index: 9999;" class="alert alert-danger alert-dismissible fade show" role="alert">
                Username atau Password Salah!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
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
    <section class="vh-100" style="background: url('../assets/img/Libr.jpeg') no-repeat center center fixed; background-size: cover;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-14">
                    <div class="card" style="border-radius: 1rem; background-color: rgba(255, 255, 255, 0.3); backdrop-filter: blur(10px); width: 100%;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="../assets/img/register.jpg" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; width: 100%; height: 100%;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form method="post">
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <img src="../assets/img/logo1.png" width="100" height="100" class="me-3" alt="Logo" />
                                            <span class="h1 fw-bold mb-0">LibraTech</span>
                                        </div>
                                        <h4 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; color: white;">Register to your account</h4>
                                        <label class="form-label fs-5" for="inputEmail" style="color: white;">Email</label>
                                        <div class="form-outline mb-4">
                                            <input type="email" id="inputEmail" name="email" class="form-control form-control-lg fs-5" required maxlength="100" minlength="10" />
                                        </div>
                                        <label class="form-label fs-5" for="inputUsername" style="color: white;">Username</label>
                                        <div class="form-outline mb-4">
                                            <input type="text" id="inputUsername" name="username" class="form-control form-control-lg fs-5" required maxlength="50" minlength="10" />
                                        </div>
                                        <label class="form-label fs-5" for="inputPassword" style="color: white;">Password</label>
                                        <div class="form-outline mb-4">
                                            <input type="password" id="inputPassword" name="password" class="form-control form-control-lg fs-5" required minlength="8" maxlength="8" />
                                        </div>
                                        <div class="form-check form-switch mt-1" style="margin-left: 10px;">
                                            <input class="form-check-input fs-5" type="checkbox" id="viewPassword" onclick="togglePassword()" />
                                            <label class="form-check-label fs-5" for="viewPassword" style="color: white;">Show Password</label>
                                        </div>
                                        <br><br>
                                        <div class="pt-1 mb-4">
                                            <button class="btn btn-dark btn-lg w-100 fs-5" type="submit" name="register" style="color: white;">Register</button>
                                        </div>
                                        <p class="mb-5 pb-lg-2 fs-5" style="color: white;">Already have an account? <a href="login.php" style="color: white;">Login here</a></p>
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