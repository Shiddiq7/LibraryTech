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
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5"
                                style="background-color:transparent ; backdrop-filter: blur(15px);">
                                <div class="card-header text-center">
                                    <div class="text-center mb-2">
                                        <img src="../assets/img/logo1.png" width="200" alt="logo libra tech">
                                    </div>
                                    <h3 class=" text-white">Register</h3>
                                </div>
                                <div class="card-body p-5">
                                    <form method="post">
                                        <div class="form-outline mb-4">
                                            <input type="hidden" id="inputId" name="id_user" value="" />

                                            <div class="form-outline mb-4">
                                                <label class="form-label text-white" for="inputEmail">Email</label>
                                                <input type="email" id="inputEmail" name="email" class="form-control"
                                                    required maxlength="100" minlength="10" />
                                            </div>


                                            <div class="form-outline mb-4">
                                                <label class="form-label text-white"
                                                    for="inputUsername">Username</label>
                                                <input type="text" id="inputUsername" name="username"
                                                    class="form-control" required maxlength="50" minlength="10" />
                                            </div>

                                            <div class="form-outline mb-4">
                                                <label class="form-label text-white"
                                                    for="inputPassword">Password</label>
                                                <input type="password" id="inputPassword" name="password"
                                                    class="form-control" required minlength="8" maxlength="8" />

                                                <div class="form-check form-switch mt-2">
                                                    <input class="form-check-input" type="checkbox" id="viewPassword"
                                                        onclick="togglePassword()" />
                                                    <label class="form-check-label text-white" for="viewPassword">Show
                                                        Password</label>
                                                </div>
                                            </div>

                                            <br>
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" name="register"
                                                    class="btn btn-sm btn-primary border-0 py-2 px-4 rounded-pill w-100">Register</button>
                                            </div>
                                    </form>
                                </div>
                                <hr class="my-1" />
                                <div class=" text-center py-3">
                                    <div class="d-flex justify-content-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <span class="text-white-50 me-2">Sudah punya akun?</span>
                                                <button type="button"
                                                    class="btn btn-outline-light rounded-pill px-5 py-2 ms-2"
                                                    onclick="window.location.href='login.php'">Login</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </main>
        </div>
    </div>
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