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
     <!-- Navbar -->
     <nav class="navbar navbar-expand-lg shadow-sm bg-white">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img style="height: 40px;" alt="LibraryTech Logo" src="../assets/img/logo1.png" />
                <span class="ms-2 fw-bold" style="color:rgb(1, 17, 255);">LibraTech</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>"
                            href="dashboard.php"><b>Dashboard</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pinjam.php' ? 'active' : ''; ?>"
                            href="pinjam.php"><b>Peminjaman</b></a>
                    </li>

                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../assets/profile_picture/<?php echo $_SESSION['username'] . '.png'; ?>"
                                onerror="this.src='../assets/img/default_profile_picture.png';"
                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"
                                decoding="async" loading="lazy" />
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <img src="../assets/profile_picture/<?php echo $_SESSION['username'] . '.png'; ?>"
                                    onerror="this.src='../assets/img/default_profile_picture.png';"
                                    style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin: 0 auto; display: block;"
                                    decoding="async" loading="lazy" />
                            </li>
                            <li><a class="dropdown-item text-muted mt-3"
                                    href="#"><b><?php echo $_SESSION['username'] ?></b></a></li>
                            <li><a class="dropdown-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'bg-secondary bg-opacity-25 text-dark' : ''; ?>" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item text-danger" href="../Auth/logout.php"><b>Logout</b></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container d-flex flex-column align-items-center">
        <h1
            style="font-family: 'Lato', sans-serif; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #4a4a4a;">
            Profile</h1>
        <hr>
        <!-- Profile Picture -->
        <?php
        // Handle file upload
        if (isset($_POST['cropped_image'])) {
            $image_parts = explode(";base64,", $_POST['cropped_image']);
            $image_base64 = base64_decode($image_parts[1]);
            $new_filename = $_SESSION['username'] . '.png';

            // Check if profile_picture folder exists
            if (!is_dir('../assets/profile_picture')) {
            mkdir('../assets/profile_picture', 0777, true);
            }

            // Set target file path
            $target_file = "../assets/profile_picture/" . $new_filename;

            // Save file
            file_put_contents($target_file, $image_base64);
            echo "<script>window.location.href='profile.php';</script>";
        }

        // Handle delete profile picture
        if (isset($_GET['delete'])) {
            $file_path = "../assets/profile_picture/" . $_SESSION['username'] . '.png';
            if (file_exists($file_path)) {
            unlink($file_path);
            }
            echo "<script>window.location.href='profile.php';</script>";
        }
        ?>
        <!-- Add Cropper.js CSS and JS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

        <!-- Profile Picture -->
        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column; gap: 10px;">
            <?php
            $profile_picture = "../assets/profile_picture/" . $_SESSION['username'] . '.png';
            ?>
            <div class="profile-container" style="position: relative; width: 200px; height: 200px; display: flex; justify-content: center; align-items: center; background-color: #f4f4f4; border-radius: 50%; overflow: hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <?php if (file_exists($profile_picture)): ?>
                <img src="<?php echo $profile_picture . '?v=' . time(); ?>" style="width: 100%; height: 100%; object-fit: cover; transition: filter 0.3s;" decoding="async" loading="lazy">
                <?php else: ?>
                <i class="fas fa-user-circle" style="font-size: 8rem; color: #b0b0b0;"></i>
                <?php endif; ?>

                <form id="profileForm" method="POST" enctype="multipart/form-data" style="position: absolute; inset: 0; display: flex; justify-content: center; align-items: center; background-color: rgba(0, 0, 0, 0.5); opacity: 0; transition: opacity 0.3s;">
                    <label for="profile_input" class="btn btn-light btn-sm" style="background-color: rgba(255, 255, 255, 0.8); border-radius: 20px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-camera"></i> <?php echo file_exists($profile_picture) ? 'Change' : 'Upload'; ?>
                    </label>
                    <input type="file" accept="image/*" style="display: none;" id="profile_input" name="profile_image" onchange="showCropper(this)">
                    <input type="hidden" name="cropped_image" id="cropped_image">
                </form>
            </div>
            <script>
                const profileContainer = document.querySelector('.profile-container');
                profileContainer.addEventListener('mouseenter', function() {
                    this.querySelector('form').style.opacity = 1;
                    const img = this.querySelector('img');
                    if (img) img.style.filter = 'brightness(50%)';
                });
                profileContainer.addEventListener('mouseleave', function() {
                    this.querySelector('form').style.opacity = 0;
                    const img = this.querySelector('img');
                    if (img) img.style.filter = 'brightness(100%)';
                });
            </script>
            <?php if(file_exists($profile_picture)): ?>
            <button type="button" class="btn btn-light btn-sm mt-2 d-block d-md-none" onclick="document.getElementById('profile_input').click();" style="border-radius: 20px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <i class="fas fa-edit"></i> Change Picture
            </button>

            <button type="button" class="btn btn-danger btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#deletePhotoModal" style="border-radius: 20px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                <i class="fas fa-trash-alt"></i> Delete Picture
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
            <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                <div class="cropper-container" style="width: 100%; max-height: calc(100vh - 200px); overflow: hidden;">
                    <img id="cropperImage" src="" class="img-fluid w-100" style="max-height: none;">
                </div>
                </div>
                <div class="modal-footer flex-wrap gap-2 justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary px-4" onclick="cropAndUpload()">Save</button>
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
        <div style="width: 100%;" class="d-flex justify-content-center gap-2 mt-4">
            <a href="dashboard.php" class="btn btn-outline-secondary ms-auto" style="width: 150px;">Kembali</a>
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
                        responsive: true, // make cropper responsive
                        restore: true,
                        guides: true,
                        center: true,
                        highlight: true,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false
                    });
                });
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function cropAndUpload() {
        const canvas = cropper.getCroppedCanvas({
            width: window.innerWidth > 400 ? 400 : window.innerWidth, // adapt canvas width to screen size
            height: window.innerWidth > 400 ? 400 : window.innerWidth // adapt canvas height to screen size
        });
        
        canvas.toBlob(function(blob) {
            const formData = new FormData();
            formData.append('cropped_image', canvas.toDataURL('image/png'));

            fetch('profile.php', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(() => {
                window.location.reload();
            })
            .catch(error => console.error('Error:', error));
        }, 'image/png');
    }
</script>




</html>