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

        <!-- Profile Picture -->
        <?php
        // Handle file upload
        if(isset($_POST['cropped_image'])) {
            $target_dir = "../assets/profile_picture/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $image_parts = explode(";base64,", $_POST['cropped_image']);
            $image_base64 = base64_decode($image_parts[1]);
            $new_filename = $_SESSION['username'] . '.png';
            $target_file = $target_dir . $new_filename;
            
            if (file_put_contents($target_file, $image_base64)) {
                $_SESSION['profile_picture'] = $new_filename;
                echo "<script>window.location.href='profile.php';</script>";
            }
        }

        // Handle delete profile picture
        if (isset($_GET['delete'])) {
            $target_file = "../assets/profile_picture/" . $_SESSION['profile_picture'];
            if (file_exists($target_file)) {
                unlink($target_file);
                unset($_SESSION['profile_picture']);
                echo "<script>window.location.href='profile.php';</script>";
            }
        }
        ?>
        <!-- Add Cropper.js CSS and JS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

        <!-- Profile Picture -->
        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column; gap: 10px;">
            <?php if(isset($_SESSION['profile_picture']) && file_exists("../assets/profile_picture/" . $_SESSION['profile_picture'])): ?>
            <img src="../assets/profile_picture/<?php echo $_SESSION['profile_picture']; ?>" style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover;">
            <?php else: ?>
            <i class="fas fa-user-circle fa-10x" style="color: #4a4a4a;"></i>
            <?php endif; ?>
            
            <label for="profile_input" class="btn btn-outline-primary btn-sm rounded">
                <i class="fas fa-camera"></i>
                <?php echo isset($_SESSION['profile_picture']) ? 'Change Picture' : 'Upload Picture'; ?>
            </label>

            <input type="file" accept="image/*" style="display: none;" id="profile_input" onchange="showCropper(this)">
            <?php if(isset($_SESSION['profile_picture']) && file_exists("../assets/profile_picture/" . $_SESSION['profile_picture'])): ?>
            <button type="button" class="btn btn-outline-danger btn-sm rounded mt-2" data-bs-toggle="modal" data-bs-target="#deletePhotoModal">
                <i class="fas fa-trash-alt"></i> Delete
            </button>
        

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deletePhotoModal" tabindex="-1" aria-labelledby="deletePhotoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-body text-center p-4">
                            <i class="fas fa-exclamation-circle text-warning" style="font-size: 3rem; margin-bottom: 1rem;"></i>
                            <h5 class="modal-title mb-3" id="deletePhotoModalLabel">Delete Profile Picture?</h5>
                            <p class="text-muted">Are you sure you want to delete your profile picture? This action cannot be undone.</p>
                            <div class="d-flex justify-content-center gap-2 mt-4">
                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                                <a href="?delete" class="btn btn-danger px-4">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Cropper Modal -->
        <div class="modal fade" id="cropperModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Crop Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <img id="cropperImage" src="" style="max-width: 100%; max-height: 70vh;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="cropAndUpload()">Save</button>
                    </div>
                </div>
            </div>
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

            <?php
            $query = "SELECT nomorhp FROM user WHERE username = '$_SESSION[username]'";
            $result = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($result);
            ?>
            <tr>
                <th style="font-weight: 400;">Nomor HP</th>
                <td>
                    <?php if ($data['nomorhp'] == 0): ?>
                        <!-- Jika nomor HP belum ada -->
                        <span style="font-style: italic; color: darkred;">Nomor handphonemu belum ada nih</span>
                        <button style="border: none; background-color: white;" class="text-primary ms-2"
                            data-bs-toggle="modal" data-bs-target="#nomorhpModal"><i class="fas fa-plus-circle"> Tambah No.
                                HP</i></button>

                        <div class="modal fade" id="nomorhpModal" tabindex="-1" aria-labelledby="nomorhpModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="nomorhpModalLabel">Tambah Nomor HP</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nomorhp" class="form-label">Nomor HP</label>
                                                <input type="text" class="form-control" id="nomorhp" name="nomorhp"
                                                    placeholder="Ex: 0812-3456-7890" aria-describedby="nomorhpHelp"
                                                    minlength="14" maxlength="14" required
                                                    oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\d{4})/g, '$1-').replace(/--/g, '-').replace(/-$/, '');">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Functions Add-->
                        <?php
                        if (isset($_POST['nomorhp'])) {
                            $nomorhp = $_POST['nomorhp'];
                            $username = $_SESSION['username'];
                            $query = "UPDATE user SET nomorhp = '$nomorhp' WHERE username = '$username'";
                            mysqli_query($conn, $query);
                            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                            echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
                            echo "<script>
                                $(document).ready(function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil Menambahkan Nomor HP!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function() {
                                        window.location = 'profile.php';
                                    });
                                });
                            </script>";
                        }
                        ?>
                    <?php else: ?>
                        <?= $data['nomorhp'] ?>
                        <!-- Jika nomor HP sudah ada -->
                        <button style="border: none; background-color: white;" class="text-primary ms-2"
                            data-bs-toggle="modal" data-bs-target="#editNomorhpModal"><i class="fas fa-edit"> Edit</i></button>

                        <div class="modal fade" id="editNomorhpModal" tabindex="-1" aria-labelledby="editNomorhpModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editNomorhpModalLabel">Edit Nomor HP</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="editNomorhp" class="form-label">Nomor HP</label>
                                                <input type="text" class="form-control" id="editNomorhp"
                                                    name="editNomorhp" placeholder="Ex: 0812-3456-7890"
                                                    aria-describedby="nomorhpHelp" value="<?= $data['nomorhp'] ?>"
                                                    minlength="14" maxlength="14" required
                                                    oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\d{4})/g, '$1-').replace(/--/g, '-').replace(/-$/, '');">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Functions Edit-->
                        <?php
                        if (isset($_POST['editNomorhp'])) {
                            $editNomorhp = $_POST['editNomorhp'];
                            $username = $_SESSION['username'];
                            $query = "UPDATE user SET nomorhp = '$editNomorhp' WHERE username = '$username'";
                            mysqli_query($conn, $query);
                            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                            echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
                            echo "<script>
                                $(document).ready(function() {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil Mengedit Nomor HP!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function() {
                                        window.location = 'profile.php';
                                    });
                                });
                            </script>";
                        }
                        ?>
                    <?php endif; ?>
                </td>
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



        </table>
        <div class="d-flex justify-content-center gap-2 mt-4">
            <a href="dashboard.php" class="btn btn-outline-secondary ms-auto">Kembali</a>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script>
    let cropper;

    function showCropper(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const image = document.getElementById('cropperImage');
                image.src = e.target.result;

                const modal = new bootstrap.Modal(document.getElementById('cropperModal'));
                modal.show();

                modal._element.addEventListener('shown.bs.modal', () => {
                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(image, {
                        aspectRatio: 1,
                        viewMode: 2,
                        dragMode: 'move',
                        autoCropArea: 1,
                    });
                });
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function cropAndUpload() {
        const canvas = cropper.getCroppedCanvas({ width: 400, height: 400 });

        const formData = new FormData();
        formData.append('cropped_image', canvas.toDataURL());

        fetch('profile.php', { method: 'POST', body: formData })
            .then(() => window.location.reload());
    }
</script>




</html>