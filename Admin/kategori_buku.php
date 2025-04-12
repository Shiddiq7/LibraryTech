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
    <title>Daftar Kategori - LibraTech</title>

    <!-- Preload critical resources -->
    <link rel="preload" href="../assets/img/logo1.png" as="image">
    <link rel="preload" href="../css/styles.css" as="style">
    <link rel="preload" href="../css/selfstyle.css" as="style">

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://use.fontawesome.com">

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

        .btn-export {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
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

        .modal-footer {
            justify-content: flex-end;
            padding: 1rem;
            gap: 0.5rem;
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
                            href="#">
                            <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                            Kategori
                        </a>

                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'daftar_anggota.php' ? 'active' : ''; ?>"
                            style="padding-left: 15px;" href="daftar_anggota.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Anggota
                        </a>

                        <div class="sb-sidenav-menu-heading">Tools</div>
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'recovery.php' ? 'active' : ''; ?>"
                            href="recovery.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-recycle"></i></div>
                            Recovery
                        </a>


                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Kategori Buku</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Kategori</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-table me-1"></i>
                                Kategori Buku
                            </div>
                            <div class="d-flex gap-3">
                                <a href="export_table/export_kategori.php"
                                    class="btn btn-outline-primary btn-sm btn-export">
                                    <i class="fas fa-file-export me-2"></i>Export Table
                                </a>
                                <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#tambahKategori">
                                    Tambah Kategori
                                </button>

                                <!-- Modal Tambah Kategori -->
                                <div class="modal fade" id="tambahKategori" tabindex="-1"
                                    aria-labelledby="tambahKategoriLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="tambahKategoriLabel">Tambah Kategori</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="POST">
                                                    <div class="mb-3">
                                                        <label for="nama_kategori" class="form-label">Nama
                                                            Kategori</label>
                                                        <input type="text" class="form-control" id="nama_kategori"
                                                            name="nama_kategori" required maxlength="50">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                                        <textarea class="form-control" id="deskripsi" name="deskripsi"
                                                            rows="3" required></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary"
                                                            name="tambahKategori">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body table-container">
                            <table id="datatablesSimple" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kategori Buku</th>
                                        <th>Deskripsi</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = "SELECT id_kat, nama_kategori, Deskripsi FROM kategori ORDER BY nama_kategori";
                                    $result = mysqli_query($conn, $query);
                                    $no = 1;

                                    while ($data = mysqli_fetch_assoc($result)):
                                        $id_kat = htmlspecialchars($data['id_kat']);
                                        $nama_kategori = htmlspecialchars($data['nama_kategori']);
                                        $deskripsi = htmlspecialchars($data['Deskripsi']);
                                        ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $nama_kategori ?></td>
                                            <td><?= $deskripsi ?></td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button type="button" class="btn btn-outline-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editKategoriModal<?= $id_kat ?>">
                                                        Edit
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteKategoriModal<?= $id_kat ?>">
                                                        Delete
                                                    </button>

                                                    <!-- Modal Edit -->
                                                    <div class="modal fade" id="editKategoriModal<?= $id_kat ?>"
                                                        tabindex="-1" aria-labelledby="editKategoriModal<?= $id_kat ?>Label"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editKategoriModal<?= $id_kat ?>Label">Edit
                                                                        Kategori</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post">
                                                                        <input type="hidden" name="id_kat"
                                                                            value="<?= $id_kat ?>">
                                                                        <div class="mb-3">
                                                                            <label for="nama_kategori"
                                                                                class="form-label">Nama Kategori</label>
                                                                            <input type="text" class="form-control"
                                                                                id="nama_kategori" name="nama_kategori"
                                                                                value="<?= $nama_kategori ?>" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="deskripsi"
                                                                                class="form-label">Deskripsi</label>
                                                                            <textarea class="form-control" id="deskripsi"
                                                                                name="deskripsi" rows="4"
                                                                                required><?= $deskripsi ?></textarea>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary "
                                                                            name="editKategori">Update</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Delete -->
                                                    <div class="modal fade" id="deleteKategoriModal<?= $id_kat ?>"
                                                        tabindex="-1"
                                                        aria-labelledby="deleteKategoriModal<?= $id_kat ?>Label"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="deleteKategoriModal<?= $id_kat ?>Label">Delete
                                                                        Kategori</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>Anda yakin ingin menghapus kategori
                                                                        <b><?= $nama_kategori ?></b>?
                                                                    </p>
                                                                    <form method="post">
                                                                        <input type="hidden" name="id_kat"
                                                                            value="<?= $id_kat ?>">
                                                                        <button type="submit" class="btn btn-danger"
                                                                            name="deleteKategori">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </td>
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



    <!-- Load non-critical scripts at the end -->
    <script async defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script async defer src="../js/scripts.js"></script>
    <script async defer
        src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>

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
        });

        // Show/Hide loading overlay
        function toggleLoading(show) {
            document.getElementById('loadingOverlay').style.display = show ? 'flex' : 'none';
        }

        // Handle form submission
        async function handleSubmit(event) {
            event.preventDefault();
            toggleLoading(true);

            try {
                const formData = new FormData(event.target);
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    location.reload();
                } else {
                    throw new Error('Network response was not ok');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            } finally {
                toggleLoading(false);
            }
        }

        // Edit kategori
        function editKategori(id, nama, deskripsi) {
            document.getElementById('modalTitle').textContent = 'Edit Kategori';
            document.getElementById('id_kat').value = id;
            document.getElementById('nama_kategori').value = nama;
            document.getElementById('deskripsi').value = deskripsi;
            document.getElementById('action').value = 'edit';
            document.getElementById('submitBtn').textContent = 'Update';

            new bootstrap.Modal(document.getElementById('kategoriModal')).show();
        }


    </script>
</body>

</html>