<?php
require "../func.php";
require "../Auth/cek_log.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="LibraTech - Sistem Manajemen Perpustakaan Digital" />
    <meta name="author" content="LibraTech" />
    <title>Daftar Anggota - LibraTech</title>

    <!-- Preload critical resources -->
    <link rel="preload" href="../assets/img/logo1.png" as="image">
    <link rel="preload" href="../css/styles.css" as="style">
    <link rel="preload" href="../css/selfstyle.css" as="style">

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://use.fontawesome.com">
    <link rel="preconnect" href="https://code.jquery.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">

    <!-- Critical CSS -->
    <link rel="icon" href="../assets/img/logo1.png" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/selfstyle.css" rel="stylesheet" />

    <!-- Defer non-critical scripts -->
    <script defer src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <style>
        /* Critical inline styles */
        .table-container {
            overflow-x: auto;
            margin: 1rem 0;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
        }

        .btn-export {
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .badge {
            margin-left: 10px;
        }

        .modal-footer {
            justify-content: center;
            padding: 1rem;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <!-- Loading overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="spinner"></div>
    </div>

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3 d-flex align-items-center" href="#">
            <span class="ms-2">LibraTech</span>
        </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href=""><i
                class="fas fa-bars"></i></button>

        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="">Hallo , <?php echo $_SESSION['username'] ?></a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item text-danger" href="../Auth/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion"
                style="background: linear-gradient(135deg, #161b22, #0f1217);">
                <div class="sb-sidenav-menu" style="color: #ffffff;">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading"></div>
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>"
                            href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Daftar</div>
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'daftar_buku.php' ? 'active' : ''; ?>"
                            href="daftar_buku.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Daftar Buku
                        </a>
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pinjam.php' ? 'active' : ''; ?>"
                            href="pinjam.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                            Peminjaman
                            <?php
                            $newDataCount = query("SELECT COUNT(*) AS total FROM pinjam WHERE status = 'Menunggu Konfirmasi'")[0]['total'];
                            if ($newDataCount > 0): ?>
                                <span class="badge bg-warning text-dark ms-2"><?= $newDataCount ?></span>
                                <i class="fas fa-exclamation-circle ms-2 text-warning"></i>
                            <?php endif; ?>
                        </a>

                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'kategori_buku.php' ? 'active' : ''; ?>"
                            href="kategori_buku.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                            Kategori
                        </a>

                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'daftar_anggota.php' ? 'active' : ''; ?>"
                            style="padding-left: 15px;" href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Anggota
                        </a>


                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Member Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Anggota</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-table me-1"></i>
                                Member
                            </div>
                            <div class="d-flex gap-3">
                                <a href="export_table/export_anggota.php"
                                    class="btn btn-outline-primary btn-sm btn-export">
                                    <i class="fas fa-file-export me-2"></i>Export Table
                                </a>
                                <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#tambahAnggota">
                                    Tambah Anggota
                                </button>
                            </div>
                        </div>
                        <div class="card-body table-container">
                            <table id="datatablesSimple" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>ID User</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Nomor HP</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT * FROM user WHERE if_visible = TRUE ORDER BY id_user";
                                    $result = mysqli_query($conn, $query);
                                    $no = 1;

                                    while ($data = mysqli_fetch_assoc($result)):
                                        $id_user = htmlspecialchars($data['id_user']);
                                        $email = htmlspecialchars($data['Email']);
                                        $username = htmlspecialchars($data['username']);
                                        $nomorhp = htmlspecialchars($data['nomorhp']);
                                        $role = htmlspecialchars($data['role']);
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $id_user ?></td>
                                            <td>
                                                <?= $email ?>
                                                <?php if ($data['verify'] == 1): ?>
                                                    <span class="badge bg-success">Verified</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">Not Verified</span>
                                                    <div class="action-buttons">
                                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                            data-bs-toggle="modal" data-bs-target="#verifyModal<?= $id_user ?>">
                                                            Verify
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                            data-bs-toggle="modal" data-bs-target="#deleteModal<?= $id_user ?>">
                                                            Delete
                                                        </button>

                                                        <!-- Modal Verify -->
                                                        <div class="modal fade" id="verifyModal<?= $id_user ?>" tabindex="-1"
                                                            aria-labelledby="verifyModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="verifyModalLabel">Verify
                                                                            User</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Kamu yakin ingin memverifikasi user <?= $username ?>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form method="post">
                                                                            <input type="hidden" name="id_user"
                                                                                value="<?= $id_user ?>">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-primary"
                                                                                name="verify">Verify</button>
                                                                        </form>
                                                                        <?php
                                                                        if (isset($_POST['verify'])) {
                                                                            $id_user = $_POST['id_user'];
                                                                            $query = "UPDATE user SET verify = 1 WHERE id_user = '$id_user'";
                                                                            $result = mysqli_query($conn, $query);
                                                                            if ($result) {
                                                                                echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
                                                                                echo '<script>
                                                                                        swal({
                                                                                            title: "Berhasil!",
                                                                                            text: "User berhasil diverifikasi!",
                                                                                            icon: "success",
                                                                                            button: "Oke",
                                                                                        }).then(function() {
                                                                                            window.location = "daftar_anggota.php";
                                                                                        });
                                                                                      </script>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Modal Delete -->
                                                        <div class="modal fade" id="deleteModal<?= $id_user ?>" tabindex="-1"
                                                            aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="deleteModalLabel">Delete
                                                                            User</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Kamu yakin ingin menghapus user <?= $username ?>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form method="post">
                                                                            <input type="hidden" name="id_user"
                                                                                value="<?= $id_user ?>">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-danger"
                                                                                name="delete">Delete</button>
                                                                        </form>
                                                                        <?php
                                                                        if (isset($_POST['delete'])) {
                                                                            $id_user = $_POST['id_user'];
                                                                            $query = "DELETE FROM user WHERE id_user = '$id_user'";
                                                                            $result = mysqli_query($conn, $query);
                                                                            if ($result) {
                                                                                echo '<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>';
                                                                                echo '<script>
                                                                                        swal({
                                                                                            title: "Berhasil!",
                                                                                            text: "User berhasil dihapus!",
                                                                                            icon: "success",
                                                                                            button: "Oke",
                                                                                        }).then(function() {
                                                                                            window.location = "daftar_anggota.php";
                                                                                        });
                                                                                      </script>';
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $username ?></td>
                                            <td><?= ($nomorhp == 0) ? "<i>No Data</i>" : $nomorhp ?></td>
                                            <td><?= $role ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah Anggota -->
    <div class="modal fade" id="tambahAnggota" tabindex="-1" aria-labelledby="tambahAnggotaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahAnggotaLabel">Tambah Anggota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <input type="hidden" id="id_user" name="id_user" value="">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required maxlength="100">
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="verify" name="verify">
                            <label class="form-check-label" for="verify">
                                Email Verified
                            </label>
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required
                                maxlength="50">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-black" for="inputPassword">Password</label>
                            <input type="password" id="inputPassword" name="password" class="form-control" required
                                minlength="8" maxlength="8" oninput="this.setCustomValidity('')"
                                oninvalid="this.setCustomValidity('Password must be at least 8 characters')" />
                            <?php
                            if (isset($_POST['tambahAnggota'])) {
                                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                            }
                            ?>

                            <div class="form-check form-switch mt-2">
                                <input class="form-check-input" type="checkbox" id="viewPassword"
                                    onclick="togglePassword()" />
                                <label class="form-check-label text-black" for="viewPassword">Show Password</label>
                            </div>
                        </div>
                        <br>
                        <button type="submit" name="tambahAnggota"
                            class="btn btn-outline-primary w-100 rounded-pill">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Load non-critical scripts at the end -->
    <script async defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script async defer src="../js/scripts.js"></script>
    <script async defer
        src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script async defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script async defer src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize DataTable
            if (document.getElementById('datatablesSimple')) {
                new simpleDatatables.DataTable('#datatablesSimple', {
                    searchable: true,
                    sortable: true,
                    perPage: 10
                });
            }

            // Password toggle functionality
            const togglePassword = document.getElementById('viewPassword');
            const passwordInput = document.getElementById('inputPassword');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
                });
            }
        });

        // Show loading overlay
        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
        }

        // Hide loading overlay
        function hideLoading() {
            document.getElementById('loadingOverlay').style.display = 'none';
        }


    </script>
</body>

</html>