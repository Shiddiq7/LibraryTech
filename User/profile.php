<?php
require '../func.php';
require '../Auth/cek_log.php'; // Include middleware for role checks
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['username'] ?> - LibraTech</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="logo/logo.png" type="image/png">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: #f8f8f8;
            font-weight: bold;
        }

        .table img {
            border-radius: 8px;
            width: 200px;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            .table th,
            .table td {
                padding: 8px;
            }

            .table {
                font-size: 0.8rem;
            }
        }

        @media (max-width: 400px) {
            .container {
                padding: 5px;
            }

            .table th,
            .table td {
                padding: 5px;
            }

            .table {
                font-size: 0.7rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1
            style="font-family: 'Lato', sans-serif; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #4a4a4a;">
            Profile</h1>
        <hr>
        <div style="display: flex; justify-content: center; align-items: center;">
            <i class="fas fa-user-circle" style="font-size: 4rem;"></i>
        </div>
        <br><br>
        <table class="table" style="font-family: 'Lato', sans-serif; font-weight: 300;">
            <?php
            $query = "SELECT id_user FROM user WHERE username = '$_SESSION[username]'";
            $result = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($result);
            ?>
            <tr>
                <th style="font-weight: 400;">ID User</th>
                <td><?= $data['id_user'] ?></td>
            </tr>

            <?php
            $query = "SELECT Email, verify FROM user WHERE username = '$_SESSION[username]'";
            $result = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($result);
            ?>
            <tr>
                <th style="font-weight: 400;">Email</th>
                <td><?= isset($data['Email']) ? $data['Email'] : 'Not available' ?>
                    <?php if (isset($data['verify']) && $data['verify'] == 1): ?>
                        <span style="margin-left: 10px;" class="badge bg-success">Verified</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Not Verified</span>
                    <?php endif; ?>
                </td>
            </tr>



            <tr>
                <th style="font-weight: 400;">Username</th>
                <td><?= $_SESSION['username'] ?></td>
            </tr>

            <tr>
                <?php
                $query = "SELECT role FROM user WHERE username = '$_SESSION[username]'";
                $result = mysqli_query($conn, $query);
                $data = mysqli_fetch_assoc($result);
                ?>
            <tr>
                <th style="font-weight: 400;">Role</th>
                <td><?= $data['role'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: start;">
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                        data-bs-target="#deleteModal">
                        Delete Profile
                    </button>
                </td>

                <!-- Updated Delete Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Delete Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form method="POST">
                                <div class="modal-body">
                                    <p class="text-danger">Are you sure you want to delete your profile? This action
                                        cannot be undone.</p>
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label">Please enter your password to
                                            confirm:</label>
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="confirm_password" required minlength="8" maxlength="8">
                                    </div>
                                    <?php
                                    $query = "SELECT id_user FROM user WHERE username = '$_SESSION[username]'";
                                    $result = mysqli_query($conn, $query);
                                    $data = mysqli_fetch_assoc($result);
                                    ?>
                                    <input type="hidden" name="id_user" value="<?= $data['id_user'] ?>">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" name="deleteProfile" class="btn btn-danger">Delete
                                            Profile</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>

            </tr>

        </table>
        <div class="d-flex justify-content-center gap-2 mt-4">
            <a href="dashboard.php" class="btn btn-outline-secondary ms-auto">Kembali</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>




</html>