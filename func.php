<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'perpustakaan';

$conn = mysqli_connect($host, $user, $pass, $db);




// tambah Anggota
if (isset($_POST['tambahAnggota'])) {
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


    $query = "INSERT INTO user (id_user, Email , username, password) VALUES ('$id_user',  '$email', '$username', '$hashed_password')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil menambahkan Anggota!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = 'daftar_anggota.php';
                });
            });
        </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Tambahkan Anggota!',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>";
    }
}


// Edit Anggota
if (isset($_POST['editAnggota'])) {
    $id_user = $_POST['id_user'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    $query = "UPDATE user SET Email = '$email', username = '$username' WHERE id_user = '$id_user'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Edit Anggota!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location = 'daftar_anggota.php';
                });
            });
        </script>";
    } else {
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Edit Anggota!',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>";
    }
}

// Hapus Anggota
if (isset($_POST['deleteAnggota'])) {

    $id_user = $_POST['id_user'];
    $visible = $_POST['if_visible'];
    $delete = "UPDATE user SET if_visible = FALSE WHERE id_user = '$id_user'";
    $result = mysqli_query($conn, $delete);

    if ($result) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Hapus!',
                    text: 'Anggota berhasil dihapus!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location = 'daftar_anggota.php';
                });
            });
        </script>";
    } else {
        echo "<script>alert('Gagal menghapus anggota!');</script>";
    }
}


// Daftar Buku
// Fungsi query digunakan untuk mengirimkan query ke database dan mengembalikan hasilnya dalam bentuk array associative
function query($query)
{
    global $conn;
    // jalankan query
    $result = mysqli_query($conn, $query);

    // buat array untuk menyimpan hasil
    $rows = [];
    // loop sampai hasil query habis
    while ($row = mysqli_fetch_assoc($result)) {
        // tambahkan hasil ke array
        $rows[] = $row;
    }
    // kembalikan hasil
    return $rows;
}


// tambah buku
if (isset($_POST['tambahBuku'])) {
    $id_buku = $_POST['id_buku'];

    // Mendapatkan nama file yang di upload
    $cover = $_FILES['cover']['name'];

    // Mendapatkan lokasi file sementara setelah di upload
    $cover_tmp = $_FILES['cover']['tmp_name'];

    // Membuat nama folder dan nama file yang akan di simpan di folder assets
    $cover_folder = "../assets/Buku/$cover";

    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $halaman = $_POST['halaman'];
    $kategori = $_POST['kategori'];

    // Generate id_buku
    $inisial_judul = strtoupper(substr($judul, 0, 2));
    $tahun_terbit = substr($tahun_terbit, 2);
    $id_buku = "$inisial_judul$tahun_terbit";

    // cek apakah folder assets/Buku sudah ada atau belum
    // jika belum, maka buat folder baru dengan nama Buku
    // dan set permissionnya menjadi 0777 agar dapat diakses oleh semua user
    if (!is_dir('../assets/Buku')) {
        mkdir('../assets/Buku', 0777, true);
    }

    // Move the uploaded file to the uploads directory
    if (move_uploaded_file($cover_tmp, $cover_folder)) {
        // Insert data ke database
        $query = "INSERT INTO buku (id_buku, cover, judul, deskripsi ,pengarang, penerbit, tahun_terbit, halaman, kategori) VALUES ('$id_buku', '$cover_folder', '$judul', '$deskripsi' ,'$pengarang', '$penerbit', '$tahun_terbit', '$halaman', '$kategori')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil menambahkan Buku!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = 'daftar_buku.php';
                    });
                });
            </script>";
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Tambahkan Buku!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            </script>";
        }
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Upload Cover!',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>";
    }
}

// Edit Buku
if (isset($_POST['editBuku'])) {
    $id_buku = $_POST['id_buku'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $halaman = $_POST['halaman'];
    $kategori = $_POST['kategori'];

    // Handle cover upload
    if ($_FILES['cover']['name']) {
        $cover = $_FILES['cover']['name'];
        $cover_tmp = $_FILES['cover']['tmp_name'];
        $cover_folder = "../assets/Buku/$cover";

        if (move_uploaded_file($cover_tmp, $cover_folder)) {
            $query = "UPDATE buku SET cover = '$cover_folder', judul = '$judul', deskripsi = '$deskripsi' ,pengarang = '$pengarang', penerbit = '$penerbit', tahun_terbit = '$tahun_terbit', halaman = '$halaman' , kategori = '$kategori' WHERE id_buku = '$id_buku'";
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Upload Cover!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            </script>";
            exit;
        }
    } else {
        $query = "UPDATE buku SET judul = '$judul', deskripsi = '$deskripsi' ,pengarang = '$pengarang', penerbit = '$penerbit', tahun_terbit = '$tahun_terbit', halaman = '$halaman' , kategori = '$kategori' WHERE id_buku = '$id_buku'";
    }

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Edit Buku!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location = 'detail_buku.php';
                });
            });
        </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Edit Buku!',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>";
    }
}

// Hapus Buku
if (isset($_POST['deleteBuku'])) {
    $id_buku = $_POST['id_buku'];
    $if_visible = $_POST['if_visible'];
    $delete = "UPDATE buku SET if_visible = FALSE WHERE id_buku = '$id_buku'";
    $result = mysqli_query($conn, $delete);

    if ($result) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Hapus Buku!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location = 'detail_buku.php';
                });
            });
        </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Hapus Buku!',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>";
    }
}

// Tambah Kategori
if (isset($_POST['tambahKategori'])) {
    $nama_kategori = $_POST['nama_kategori'];
    $deskripsi= $_POST['deskripsi'];
    $query = "INSERT INTO kategori (nama_kategori, deskripsi) VALUES ('$nama_kategori', '$deskripsi')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Tambah Kategori!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location = 'kategori_buku.php';
                });
            });
        </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Tambah Kategori!',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>";
    }
}

// Edit Kategori
if (isset($_POST['editKategori'])) {
    $id_kat = $_POST['id_kat'];
    $nama_kategori = $_POST['nama_kategori'];
    $deskripsi = $_POST['deskripsi'];
    $query = "UPDATE kategori SET nama_kategori = '$nama_kategori' , deskripsi = '$deskripsi' WHERE id_kat = '$id_kat'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Edit Kategori!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location = 'kategori_buku.php';
                });
            });
        </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Edit Kategori!',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>";
    }
}

// Hapus Kategori
if (isset($_POST['deleteKategori'])) {
    $id_kat = $_POST['id_kat'];
    $query = "DELETE FROM kategori WHERE id_kat = '$id_kat'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Hapus Kategori!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location = 'kategori_buku.php';
                });
            });
        </script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Hapus Kategori!',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>";
    }
}

?>