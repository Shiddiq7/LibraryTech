<?php
require '../func.php';
require '../Auth/cek_log.php';

if (isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];
    $query = "SELECT * FROM buku WHERE id_buku = '$id_buku'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
} else {
    header('location:daftar_buku.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku - LibraTech</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="..\assets\img\logo1.png" type="image/png">
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
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg shadow-sm bg-white fixed-top">
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
                            data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-circle"
                                style="font-size: 1.5rem;"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item text-muted"
                                    href="#"><b><?php echo $_SESSION['username'] ?></b></a></li>
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
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
    <br><br>
    <div class="container">
        <h1
            style="font-family: 'Lato', sans-serif; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #4a4a4a;">
            Detail Buku</h1>
        <table class="table" style="font-family: 'Lato', sans-serif; font-weight: 300;">
            <tr>
                <th style="font-weight: 400;">Book Cover</th>
                <td style="text-align: center;"><img src="../cover/<?= $data['cover'] ?>" alt="<?= $data['judul'] ?>"
                        style="border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); display: block; margin: 0 auto;">
                </td>
            </tr>
            <tr>
                <th style="font-weight: 400;">ID Buku</th>
                <td><?= $data['id_buku'] ?></td>
            </tr>
            <tr>
                <th style="font-weight: 400;">Judul Buku</th>
                <td><?= $data['judul'] ?></td>
            </tr>
            <tr>
            <tr>
                <th style="font-weight: 400;">Deskripsi</th>
                <td><?= (empty($data['deskripsi']) ? '<span style="font-size: larger;"> - </span>' : $data['deskripsi']) ?>
                </td>
            </tr>
            </tr>
            <tr>
                <th style="font-weight: 400;">Penulis</th>
                <td><?= $data['pengarang'] ?></td>
            </tr>
            <tr>
                <th style="font-weight: 400;">Penerbit</th>
                <td><?= $data['penerbit'] ?></td>
            </tr>
            <tr>
                <th style="font-weight: 400;">Tahun Terbit</th>
                <td><?= $data['tahun_terbit'] ?></td>
            </tr>
            <tr>
                <th style="font-weight: 400;">Jumlah Halaman</th>
                <td><?= $data['halaman'] ?></td>
            </tr>
            <tr>
                <th style="font-weight: 400;">Kategori</th>
                <td><?= $data['kategori'] ?></td>
            </tr>
        </table>
        <div class="d-flex justify-content-center gap-2 mt-4">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#pinjamModal">Pinjam
                Buku</button>
            <a href="dashboard.php" class="btn btn-outline-secondary ms-auto">Kembali</a>
        </div>
    </div>

    <br>


    <!-- Modal Pinjam -->
    <div class="modal fade" id="pinjamModal" tabindex="-1" aria-labelledby="pinjamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pinjamModalLabel">Pinjam Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" name="cover" value="<?= $data['cover'] ?>">
                        <input type="hidden" name="username" value="<?= $_SESSION['username'] ?>">
                        <?php $email = query("SELECT email FROM user WHERE username = '$_SESSION[username]'")[0]['email']; ?>
                        <input type="hidden" name="email" value="<?= $email ?>">
                        <input type="hidden" name="id_buku" value="<?= $data['id_buku'] ?>">
                        <input type="hidden" name="judul" value="<?= $data['judul'] ?>">
                        <input type="hidden" name="pengarang" value="<?= $data['pengarang'] ?>">
                        <input type="hidden" name="penerbit" value="<?= $data['penerbit'] ?>">

                        <div class="mb-3">
                            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required
                                min="<?= date('Y-m-d') ?>"
                                onchange="
                                    var date = new Date(this.value);
                                    date.setDate(date.getDate() + 7);
                                    document.getElementById('tanggal_kembali').min = this.value;
                                    document.getElementById('tanggal_kembali').max = date.toISOString().split('T')[0];
                                ">
                            <small class="text-muted">Maksimal Pinjam Buku adalah 7 Hari</small>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                            <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali"
                                required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-outline-primary" name="pinjam">Pinjam</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

    <!-- preview -->
    <script>
        function previewImage() {
            const image = document.querySelector('#cover');
            const preview = document.querySelector('#preview');

            const file = image.files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>
</body>

</html>