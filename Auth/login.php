<?php
require '../func.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    $hitung = mysqli_num_rows($result);
    if ($hitung > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['log'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role']; 

            if ($row['role'] == 'Admin') {
                header("location:../Admin/dashboard.php");
            } else {
                header("location:../User/dashboard.php");
            }
        } else {
            echo "<script>alert('Username atau Password Salah!')</script>";
        }
    } else {
        echo "<script>alert('Username atau Password Salah!')</script>";
    }
}

if (!isset($_SESSION['log'])) {

} else {
    if ($_SESSION['role'] == 'Admin') {
        header('location: ../Admin/dashboard.php');
    } else {
        header('location: ../User/dashboard.php');
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
    <title>Login LibraTech </title>
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="bg-success">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5 bg-dark">
                                <div class="card-header text-center">
                                    <div class="text-center mb-2">
                                        <img src="../assets/img/logo1.png" width="200" alt="logo libra tech">
                                    </div>
                                    <?php if (isset($_SESSION['id_user'])): ?>
                                        <p class="text-white">ID User Anda: <?php echo $_SESSION['id_user']; ?></p>
                                    <?php endif; ?>

                                    <h3 class="text-white">Login</h3>
                                </div>
                                <div class="card-body p-5">
                                    <form method="post">
                                        <div class="form-outline mb-4">
                                            <label class="form-label text-white" for="inputUsername">Username</label>
                                            <input type="text" id="inputUsername" name="username" class="form-control"
                                                required maxlength="50" />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label text-white" for="inputPassword">Password</label>
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
                                            <button type="submit" name="login"
                                                class="btn btn-primary border-0 py- px-5 rounded-pill w-100">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div style="position: relative; top: -25px;" class="card-footer text-center py-3">
                                    <div class="small"><a href="register.php">Belum punya akun? Register kuy!</a></div>
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