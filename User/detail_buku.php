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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm bg-white">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
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
                            <?php if (file_exists('../assets/profile_picture/' . $_SESSION['username'] . '.png')): ?>
                                <img src="../assets/profile_picture/<?php echo $_SESSION['username'] . '.png?v=' . time(); ?>"
                                    onerror="this.src='../assets/img/default_profile_picture.png';"
                                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"
                                    decoding="async" loading="lazy" />
                            <?php else: ?>
                                <i class="fas fa-user" style="font-size: 1.5rem;"></i>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <?php if (file_exists('../assets/profile_picture/' . $_SESSION['username'] . '.png')): ?>
                                    <img src="../assets/profile_picture/<?php echo $_SESSION['username'] . '.png?v=' . time(); ?>"
                                        onerror="this.src='../assets/img/default_profile_picture.png';"
                                        style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin: 0 auto; display: block;"
                                        decoding="async" loading="lazy" />
                                <?php else: ?>
                                    <i class="fas fa-user-circle"
                                        style="font-size: 8rem; color: #b0b0b0; margin: 0 auto; display: block; text-align: center;"></i>
                                <?php endif; ?>
                            </li>
                            <li><a class="dropdown-item text-muted mt-3"
                                    href="#"><b><?php echo $_SESSION['username'] ?></b></a></li>
                            <li>
                                <a class="dropdown-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'bg-secondary bg-opacity-25 text-dark' : ''; ?>"
                                    href="profile.php">Profile</a>
                            </li>
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
            <tr>
                <th style="font-weight: 400;">Rating</th>
                <td>
                    <?php
                    $query = "SELECT AVG(rating) AS avg_rating FROM Review WHERE id_buku = '$id_buku'";
                    $result = mysqli_query($conn, $query);
                    $row = mysqli_fetch_assoc($result);
                    $avg_rating = number_format((float) $row['avg_rating'], 1, '.', '');
                    $bintang = '';
                    for ($i = 1; $i <= 5; $i++) {
                        if ($avg_rating >= $i) {
                            $bintang .= '<i class="fas fa-star text-warning"></i>';
                        } else {
                            $bintang .= '<i class="far fa-star text-warning"></i>';
                        }
                    }
                    echo $bintang;
                    ?>
                </td>
            </tr>

        </table>
        <!-- Rating -->
        <?php
        if (isset($_POST['rating'])) {
            $rating = $_POST['rating'];
            $id_buku = $data['id_buku'];
            $judul = $data['judul'];
            $username = $_SESSION['username'];

            $query = "SELECT * FROM Review WHERE id_buku = '$id_buku' AND username = '$username'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 0) {
                $query = "INSERT INTO Review (id_buku, judul, username, rating) VALUES ('$id_buku', '$judul', '$username', '$rating')";
                mysqli_query($conn, $query);
                echo "<meta http-equiv='refresh' content='0'>";
            } else {
                $query = "UPDATE Review SET rating = '$rating' WHERE id_buku = '$id_buku' AND username = '$username'";
                mysqli_query($conn, $query);
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
        ?>

        <!-- Ulasan -->
        <?php if (isset($_POST['ulasan'])): ?>
            <?php
            $id_buku = $data['id_buku'];
            $judul = $data['judul'];
            $username = $_SESSION['username'];
            $komentar = $_POST['ulasan'];

            $query = "SELECT * FROM review WHERE id_buku = '$id_buku' AND username = '$username'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 0) {
                $query = "INSERT INTO review (id_buku, judul, username, ulasan) VALUES ('$id_buku', '$judul', '$username', '$komentar')";
                if (mysqli_query($conn, $query)) {
                    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
                    echo '<script>
                            swal({
                                title: "Terima Kasih!",
                                text: "Ulasan Anda telah diterima!",
                                icon: "success",
                                button: "Oke",
                            });
                          </script>';
                } else {
                    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
                    echo '<script>
                            swal({
                                title: "Gagal!",
                                text: "Terjadi kesalahan saat menyimpan ulasan Anda!",
                                icon: "error",
                                button: "Oke",
                            });
                          </script>';
                }
            } else {
                $query = "UPDATE review SET ulasan = '$komentar' WHERE id_buku = '$id_buku' AND username = '$username'";
                if (mysqli_query($conn, $query)) {
                    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
                    echo '<script>
                            swal({
                                title: "Terima Kasih!",
                                text: "Ulasan Anda telah diperbarui!",
                                icon: "success",
                                button: "Oke",
                            });
                          </script>';
                } else {
                    echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
                    echo '<script>
                            swal({
                                title: "Gagal!",
                                text: "Terjadi kesalahan saat memperbarui ulasan Anda!",
                                icon: "error",
                                button: "Oke",
                            });
                          </script>';
                }
            }
            ?>
        <?php endif; ?>

        <!-- Rating input -->
        <form method="post" id="rating-form">
            <div class="mb-3 text-center">
                <label for="rating" class="form-label">Beri Rating</label>
                <div id="star-rating" style="font-size: 24px; color: #ffc107; display: flex; justify-content: center;">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="far fa-star" data-value="<?= $i ?>"></i>
                    <?php endfor; ?>
                </div>
                <input type="hidden" id="rating" name="rating" value="0">
                <input type="hidden" name="id_buku" value="<?= $data['id_buku'] ?>">
                <input type="hidden" name="judul" value="<?= $data['judul'] ?>">
                <input type="hidden" name="username" value="<?= $_SESSION['username'] ?>">
                <button type="submit" class="btn btn-outline-info mt-3">
                    <i class="fas fa-paper-plane"></i> Submit
                </button>
            </div>
        </form>

        <!-- Script Rating  -->
        <script>
            document.querySelectorAll('#star-rating i').forEach(star => {
                star.addEventListener('click', function () {
                    const ratingValue = this.getAttribute('data-value');
                    document.getElementById('rating').value = ratingValue;
                    document.querySelectorAll('#star-rating i').forEach((s, index) => {
                        s.className = index < ratingValue ? 'fas fa-star' : 'far fa-star';
                    });
                });
            });
        </script>



        <div class="d-flex justify-content-center gap-2 mt-4">
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                data-bs-target="#pinjamModal">Pinjam
                Buku</button>
            <a href="dashboard.php" class="btn btn-outline-secondary ms-auto">Kembali</a>
        </div>
    </div>

    <br>
    <!-- Komentar/Ulasan input -->
    <form method="post">
        <div class="mb-3 ms-3 me-3">
            <label for="ulasan" class="form-label">Komentar/Ulasan</label>
            <div style="position: relative; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <textarea class="form-control" id="ulasan" name="ulasan" rows="7"
                    placeholder="Tulis ulasan Anda di sini..." style="border-radius: 20px;" maxlength="250"
                    required></textarea>
                <small class="text-muted" style="position: absolute; bottom: 5px; left: 10px;">Karakter tersisa: <span
                        id="charCount">250</span></small>
            </div>
            <input type="hidden" name="id_buku" value="<?= $data['id_buku'] ?>">
            <input type="hidden" name="username" value="<?= $_SESSION['username'] ?>">
            <button type="submit" name="komentar" class="btn btn-outline-info mt-3">
                <i class="fas fa-paper-plane"></i> Kirim Ulasan
            </button>

            <!-- Script untuk menghitung karakter tersisa -->
            <script>
                const ulasanInput = document.getElementById('ulasan');
                const charCountSpan = document.getElementById('charCount');
                ulasanInput.addEventListener('input', function () {
                    const remainingChars = 250 - ulasanInput.value.length;
                    charCountSpan.textContent = remainingChars;
                });
            </script>
        </div>
    </form>
    <br>

    <hr style="border: 2px solid black; margin-left: 20px; margin-right: 20px;">

    <!-- Display Reviews -->
    <div class="container-fluid" style="max-width: 2000px; border-radius: 10px;">
        <h3 class="text-center mt-5"
            style="font-family: 'Lato', sans-serif; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">
            Ulasan Buku</h3>
        <?php
        $id_buku = $data['id_buku'];
        $username = $_SESSION['username'];

        $query = "SELECT username, ulasan, rating FROM Review WHERE id_buku = '$id_buku' AND username = '$username' AND ulasan IS NOT NULL";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0):
            $review = mysqli_fetch_assoc($result);
            ?>
            <div class="card mt-3 shadow-sm border-0" style="border-radius: 10px; background-color: #343a40; color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="me-3">
                            <?php
                            $username = $_SESSION['username'];
                            if (file_exists("../assets/profile_picture/$username.png")): ?>
                                <img src="../assets/profile_picture/<?php echo $username; ?>.png"
                                    style="width: 60px; height: 50px; border-radius: 50%; object-fit: cover;">
                            <?php else: ?>
                                <i class="fas fa-user-circle" style="font-size: 4rem;"></i>
                            <?php endif; ?>
                        </div>
                        <div>
                            <h5 class="card-title mb-0" style="font-weight: bold;">
                                <?= htmlspecialchars($review['username']); ?>
                            </h5>
                            <div class="card-text">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="<?= $i <= $review['rating'] ? 'fas' : 'far'; ?> fa-star text-warning"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="ms-auto">
                            <p class="text-white" style="font-size: 0.8rem;">Komentarmu</p>
                        </div>
                    </div>
                    <p class="card-text" style="font-style: italic;"><?= htmlspecialchars($review['ulasan']); ?></p>
                </div>
            </div>
        <?php endif;

        $query = "SELECT username, ulasan, rating FROM Review WHERE id_buku = '$id_buku' AND username != '$username' AND ulasan IS NOT NULL";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0):
            while ($review = mysqli_fetch_assoc($result)): ?>
                <div class="card mt-3 shadow-sm border-0" style="border-radius: 10px;">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="me-3">
                                <?php
                                if (file_exists("../assets/profile_picture/$review[username].png")): ?>
                                    <img src="../assets/profile_picture/<?php echo $review['username']; ?>.png"
                                        style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
                                <?php else: ?>
                                    <i class="fas fa-user-circle" style="font-size: 4rem;"></i>
                                <?php endif; ?>
                            </div>
                            <div>
                                <h5 class="card-title mb-0" style="font-weight: bold;">
                                    <?= htmlspecialchars($review['username']); ?>
                                </h5>
                                <div class="card-text">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="<?= $i <= $review['rating'] ? 'fas' : 'far'; ?> fa-star text-warning"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <p class="card-text" style="font-style: italic;"><?= htmlspecialchars($review['ulasan']); ?></p>
                    </div>
                </div>
            <?php endwhile;
        else:
            if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM Review WHERE id_buku = '$id_buku' AND username = '$username' AND ulasan IS NOT NULL")) > 0):
                // tidak ada yang ditampilkan
            else: ?>
                <p class="text-center" style="color: #777; font-size: 1.1rem;">Belum ada ulasan untuk buku ini.</p>
            <?php endif;
        endif; ?>
    </div>
    <br><br><br>


    <!-- Pinjam Confirmation Modal -->
    <div class="modal fade" id="pinjamModal" tabindex="-1" aria-labelledby="pinjamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-body text-center p-4">
                    <i class="fas fa-book-reader text-primary" style="font-size: 3rem; margin-bottom: 1rem; "></i>
                    <h3
                        style="font-family: 'Lato', sans-serif; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #4a4a4a;">
                        Pinjam Buku</h3>
                    <form method="POST">
                        <input type="hidden" name="cover" value="<?= $data['cover'] ?>">
                        <input type="hidden" name="username" value="<?= $_SESSION['username'] ?>">
                        <?php $email = query("SELECT email FROM user WHERE username = '$_SESSION[username]'")[0]['email']; ?>
                        <input type="hidden" name="email" value="<?= $email ?>">
                        <input type="hidden" name="id_buku" value="<?= $data['id_buku'] ?>">
                        <input type="hidden" name="judul" value="<?= $data['judul'] ?>">
                        <input type="hidden" name="pengarang" value="<?= $data['pengarang'] ?>">
                        <input type="hidden" name="penerbit" value="<?= $data['penerbit'] ?>">
                        <div class="mb-3 mt-4 text-start">
                            <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                            <input type="date" class="form-control" style="text-align: start;" id="tanggal_pinjam"
                                name="tanggal_pinjam" required min="<?= date('Y-m-d') ?>" onchange="
                                    var date = new Date(this.value);
                                    date.setDate(date.getDate() + 7);
                                    document.getElementById('tanggal_kembali').min = this.value;
                                    document.getElementById('tanggal_kembali').max = date.toISOString().split('T')[0];
                                ">
                            <small class="text-muted">Maksimal Pinjam Buku adalah 7 Hari</small>
                        </div>
                        <div class="mb-3 mt-4 text-start">
                            <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                            <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali"
                                required>
                        </div>
                        <div class="d-flex justify-content-center gap-3 mt-5">
                            <button type="button" class="btn btn-outline-secondary px-4"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-outline-primary px-4" name="pinjam">Pinjam</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>

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