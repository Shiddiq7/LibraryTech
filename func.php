<?php
session_start();

require 'vendor/autoload.php'; // Include PHPMailer

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'perpustakaan';

$conn = mysqli_connect($host, $user, $pass, $db);

// Generate OTP
function generateOTP($length = 6)
{
    $characters = '0123456789';
    $otp = '';
    for ($i = 0; $i < $length; $i++) {
        $otp .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $otp;
}

// Send OTP using PHPMailer
function sendOTP($email, $otp, $username)
{
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'shiddiqduasatu@gmail.com'; // SMTP username
        $mail->Password = 'abzqaggnahfewfnr'; // SMTP password
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('no-reply@librarytech.com', 'LibraTech');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Kode OTP Anda';
        $mail->Body = "<p>Hai $username, <br><br> Kode OTP Anda adalah:</p> 
        <h2> <b>$otp</b> </h2>
        <p><br> Silakan gunakan kode OTP ini untuk verifikasi akun Anda.<br><br>Terima kasih,<br>Tim LibraTech</p>";

        $mail->send();
        echo "Message has been sent";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        error_log("Mailer Error: {$mail->ErrorInfo}"); // Log the error
    }
}

// Register User
if (isset($_POST['register'])) {
    // Ensure $id_user is properly set
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

    // Generate OTP and store it in the session
    $otp = generateOTP();
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;

    $query = "INSERT INTO user (id_user, Email, username, password, verify) VALUES ('$id_user', '$email', '$username', '$hashed_password', 0)";
    $result = mysqli_query($conn, $query);

    if ($result) {
        sendOTP($email, $otp, $username);
        echo "<script>alert('Registrasi berhasil! Silakan cek email Anda untuk kode OTP.')</script>";
        header("location: verify_otp.php");
    } else {
        echo "<script>alert('Registrasi gagal!')</script>";
    }
}

// Verify OTP
if (isset($_POST['verifyOTP'])) {
    $otp = implode('', $_POST['otp']);
    if ($otp == $_SESSION['otp']) {
        $email = $_SESSION['email'];
        $query = "UPDATE user SET verify=1 WHERE Email='$email'";
        mysqli_query($conn, $query);
        echo "<script>alert('Verifikasi berhasil!')</script>";
        header("location: Auth/login.php");
    } else {
        echo "<script>alert('Kode OTP salah!')</script>";
        header("location: Auth/verify_otp.php");
    }
}

// Resend OTP
if (isset($_POST['resendOTP'])) {
    $email = $_SESSION['email'];
    $otp = generateOTP();
    $_SESSION['otp'] = $otp;
    sendOTP($email, $otp, $username);
    echo "<script>alert('Kode OTP telah dikirim ulang ke email Anda.')</script>";
    header("location: Auth/verify_otp.php");
}



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


// Delete Profile
if (isset($_POST['deleteProfile'])) {
    $id_user = $_POST['id_user'];
    $confirm_password = $_POST['confirm_password'];

    // Get stored password
    $query = "SELECT password FROM user WHERE id_user = '$id_user'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if (password_verify($confirm_password, $user['password'])) {
        $delete = "UPDATE user SET if_visible = FALSE, verify = FALSE WHERE id_user = '$id_user'";
        $result = mysqli_query($conn, $delete);

        if ($result) {
            session_destroy();
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Profile Deleted Successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location = '../Auth/login.php';
                    });
                });
            </script>";
        }
    } else {
        echo '<div style="position: fixed; top: 0; right: 0; z-index: 9999;" class="alert alert-danger alert-dismissible fade show" role="alert">Password Salah!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
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
    $deskripsi = $_POST['deskripsi'];
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


// Tambah Peminjaman
if (isset($_POST['pinjam'])) {

    $username = $_SESSION['username'];
    $query = "SELECT id_user FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = mysqli_fetch_assoc($result);
        $id_user = $data['id_user'];
    } else {
        echo "Failed to retrieve id_user.";
    }
    $id_buku = $_POST['id_buku'];


    $cover = $_POST['cover'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    $query = "INSERT INTO pinjam (id_user,id_buku,username, cover, judul, pengarang, penerbit, tanggal_pinjam, tanggal_kembali) VALUES ('$id_user',' $id_buku ','$username', '$cover', '$judul', '$pengarang', '$penerbit', '$tanggal_pinjam', '$tanggal_kembali')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Pinjam Buku!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.history.back();
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
                    title: 'Gagal Pinjam Buku!',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>";
    }
}

// Konfirmasi Peminjaman
if (isset($_POST['confirmPinjam'])) {
    $id_pinjam = $_POST['id_pinjam'];
    $status = "Dipinjam";
    $query = "UPDATE pinjam SET status = '$status' WHERE id_pinjam = '$id_pinjam'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Konfirmasi Peminjaman!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.history.back();
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
                    title: 'Gagal Konfirmasi Peminjaman!',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>";
    }
}

// Kembalikan Buku
if (isset($_POST['kembali'])) {
    $id_pinjam = $_POST['id_pinjam'];
    $tanggal_kembali = date('Y-m-d');

    $status = "Dikembalikan";
    $query = "UPDATE pinjam SET status = '$status', tanggal_kembali = '$tanggal_kembali' WHERE id_pinjam = '$id_pinjam'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>";
        echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Kembalikan Buku!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.history.back();
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
                    title: 'Gagal Kembalikan Buku!',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>";
    }
}

?>