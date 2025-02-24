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

</html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku - LibraTech</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="icon" href="../assets/img/logo1.png" type="image/png" />
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #e5e5ea;
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

        .dot {
            height: 10px;
            width: 10px;
            background-color: orange;
            border-radius: 50%;
            display: inline-block;
            margin-left: 5px;
        }
    </style>
</head>

<body>
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
                <th style="font-weight: 400;">Deskripsi</th>
                <td><?= (empty($data['deskripsi']) ? '<span style="font-size: larger;"> - </span>' : $data['deskripsi']) ?>
                </td>
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
        <div class="d-flex justify-content-center gap-2 mt-4">

            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
            <br>
            <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</button>
            <a href="daftar_buku.php" class="btn btn-outline-secondary ms-auto">Kembali</a>
        </div>
    </div>

    <br>

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
                            <i class="fas fa-user-circle" style="font-size: 2rem;"></i>
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
                                <i class="fas fa-user-circle" style="font-size: 2rem;"></i>
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
    <br><br>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_buku" value="<?= $data['id_buku'] ?>">

                        <div class="mb-3">
                            <label for="cover" class="form-label">Cover Buku</label>
                            <input type="file" class="form-control" id="cover" name="cover" accept=".jpg, .jpeg, .png"
                                onchange="previewImage()">
                        </div>

                        <img src="" id="preview"
                            style="max-width:200px;max-height:200px; display:block; margin: 0 auto; margin-bottom: 1rem;">

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul Buku</label>
                            <input type="text" class="form-control" id="judul" name="judul"
                                value="<?= $data['judul'] ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control form-control-lg" id="deskripsi" name="deskripsi"
                                rows="4"><?= $data['deskripsi'] ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="pengarang" class="form-label">Penulis</label>
                            <input type="text" class="form-control" id="pengarang" name="pengarang"
                                value="<?= $data['pengarang'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="penerbit" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" id="penerbit" name="penerbit"
                                value="<?= $data['penerbit'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit"
                                value="<?= $data['tahun_terbit'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="halaman" class="form-label">Jumlah Halaman</label>
                            <input type="number" class="form-control" id="halaman" name="halaman"
                                value="<?= $data['halaman'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <?php
                                $kategoriQuery = "SELECT DISTINCT nama_kategori FROM kategori";
                                $kategoriResult = mysqli_query($conn, $kategoriQuery);
                                while ($row = mysqli_fetch_assoc($kategoriResult)) {
                                    $selected = $data['nama_kategori'] == $row['nama_kategori'] ? 'selected' : '';
                                    echo "<option value='{$row['nama_kategori']}' $selected>{$row['nama_kategori']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" name="editBuku">Edit Buku</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Kamu yakin ingin menghapus Buku <?= $data['judul'] ?>?
                </div>
                <div class="modal-footer">
                    <form method="POST">
                        <input type="hidden" name="id_buku" value="<?= $data['id_buku'] ?>">
                        <input type="hidden" name="if_visible">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger" name="deleteBuku">Delete</button>
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