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
    <title>Recovery - LibraTech</title>

    <!-- Critical resources -->
    <link rel="icon" href="../assets/img/logo1.png" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />

    <style>
        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            padding: 1.5rem;
        }

        .book-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            position: relative;
            background: white;
            cursor: pointer;
        }



        .book-cover {
            height: 320px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(45deg, #f3f4f6, #fff);
        }

        .book-cover::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom,
                    transparent 0%,
                    rgba(0, 0, 0, 0.4) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .book-card:hover .book-cover::before {
            opacity: 1;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            transition: transform 0.5s ease;
        }

        .book-card:hover .book-cover img {
            transform: scale(1.05);
        }

        .book-info {
            padding: 1.5rem;
            position: relative;
            background: white;
        }

        .book-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #1a202c;
            line-height: 1.4;
        }

        .book-author {
            color: #4a5568;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .book-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.875rem;
            color: #718096;
            margin-bottom: 1rem;
        }

        .book-info-extra {
            padding: 1rem 0;
            border-top: 1px solid #e2e8f0;
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #4a5568;
        }

        .btn-restore {
            width: 100%;
            padding: 0.75rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            background: linear-gradient(45deg, #10B981, #059669);
            border: none;
            color: white;
            margin-top: 1rem;
        }

        .btn-restore:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.2);
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            border-radius: 15px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .empty-state i {
            font-size: 3rem;
            color: #94a3b8;
            margin-bottom: 1rem;
        }

        .empty-state h4 {
            color: #64748b;
            font-weight: 500;
        }

        /* Loading skeleton animation */
        @keyframes shimmer {
            0% {
                background-position: -1000px 0;
            }

            100% {
                background-position: 1000px 0;
            }
        }

        .loading {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite linear;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="#">LibraTech</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item">Hallo, <?= $_SESSION['username'] ?></a></li>
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
                            style="padding-left: 15px;" href="daftar_anggota.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Anggota
                        </a>

                        <div class="sb-sidenav-menu-heading">Tools</div>
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'recovery.php' ? 'active' : ''; ?>"
                            href="#">
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
                    <h1 class="mt-4">Recovery</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Recovery</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-trash-restore me-1"></i>
                            Deleted Books
                        </div>
                        <div class="card-body">
                            <div class="book-grid">
                                <?php
                                $query = "SELECT * FROM buku WHERE if_visible = 0";
                                $result = mysqli_query($conn, $query);

                                if (mysqli_num_rows($result) == 0): ?>
                                    <div class="empty-state">
                                        <i class="fas fa-books"></i>
                                        <h4>Tidak ada buku yang dihapus</h4>
                                        <p class="text-muted">Jika buku dihapus, maka akan muncul di sini untuk dipulihkan
                                        </p>
                                    </div>
                                <?php endif;

                                while ($book = mysqli_fetch_assoc($result)): ?>
                                    <div class="book-card">
                                        <div class="book-cover">
                                            <img src="<?= $book['cover'] ?>" alt="<?= $book['judul'] ?>"
                                                onerror="this.src='../assets/img/no-cover.png';">
                                        </div>
                                        <div class="book-info">
                                            <div class="book-title"><?= $book['judul'] ?></div>
                                            <div class="book-author" title="Pengarang"><i
                                                    class="fas fa-user-edit me-2"></i><?= $book['pengarang'] ?></div>
                                            <div class="book-meta">
                                                <span title="ID Buku"><i
                                                        class="fas fa-hashtag me-1"></i><?= $book['id_buku'] ?></span>
                                                <span title="Tahun Terbit"><i
                                                        class="fas fa-calendar me-1"></i><?= $book['tahun_terbit'] ?></span>
                                            </div>

                                            <div class="book-info-extra">
                                                <div class="mb-2" title="Penerbit">
                                                    <i class="fas fa-building me-2"></i><?= $book['penerbit'] ?>
                                                </div>
                                                <div title="Kategori">
                                                    <i class="fas fa-bookmark me-2"></i><?= $book['kategori'] ?>
                                                </div>
                                            </div>


                                            <div class=" d-flex gap-2">
                                                <button type="button" class="btn btn-danger mt-3" style="height: 50px;"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal<?= $book['id_buku'] ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                <button type="button" class="btn btn-restore" data-bs-toggle="modal"
                                                    data-bs-target="#restoreModal<?= $book['id_buku'] ?>">
                                                    <i class="fas fa-trash-restore me-2"></i>Restore
                                                </button>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal<?= $book['id_buku'] ?>" tabindex="-1"
                                                aria-labelledby="deleteModal<?= $book['id_buku'] ?>Label"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title"
                                                                id="deleteModal<?= $book['id_buku'] ?>Label">
                                                                Delete Permanently
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Anda yakin ingin hapus buku ini ? :</p>
                                                            <div class="d-flex align-items-center gap-3 mb-3">
                                                                <img src="<?= $book['cover'] ?>" alt="<?= $book['judul'] ?>"
                                                                    width="100"
                                                                    onerror="this.src='../assets/img/no-cover.png';">
                                                                <div>
                                                                    <h5 class="mb-0"><?= $book['judul'] ?></h5>
                                                                    <small><?= $book['pengarang'] ?></small>
                                                                </div>
                                                            </div>
                                                            <p class="text-muted">Tindakan ini permanen dan tidak dapat
                                                                dibatalkan</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <form method="POST">
                                                                <input type="hidden" name="id_buku"
                                                                    value="<?= $book['id_buku'] ?>">
                                                                <button type="submit" class="btn btn-danger"
                                                                    name="delete">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Restore Modal -->
                                        <div class="modal fade" id="restoreModal<?= $book['id_buku'] ?>" tabindex="-1"
                                            aria-labelledby="restoreModal<?= $book['id_buku'] ?>Label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success text-white ">
                                                        <h5 class="modal-title"
                                                            id="restoreModal<?= $book['id_buku'] ?>Label">
                                                            Restore Book
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Anda yakin akan Recover buku ini :</p>
                                                        <div class="d-flex align-items-center gap-3 mb-3">
                                                            <img src="<?= $book['cover'] ?>" alt="<?= $book['judul'] ?>"
                                                                style="width:150px;height:200px;object-fit:cover;border-radius:8px;">
                                                            <div>
                                                                <strong style="position: relative; top: -30px;"><?= $book['judul'] ?></strong><br>
                                                                <div style="position: relative; top: -5px;">
                                                                    <i class="fas fa-user-edit me-2"></i><small
                                                                        class="text-muted"><?= $book['pengarang'] ?></small><br>
                                                                    <i class="fas fa-calendar me-2"></i><small
                                                                        class="text-muted"><?= $book['tahun_terbit'] ?></small><br>
                                                                    <i class="fas fa-building me-2"></i><small class="text-muted"><?= $book['penerbit'] ?></small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="POST">
                                                            <input type="hidden" name="id_buku"
                                                                value="<?= $book['id_buku'] ?>">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" name="restore"
                                                                class="btn btn-success">Restore</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new simpleDatatables.DataTable(datatablesSimple);
            }
        });
    </script>

    <!-- Restore Function -->
    <?php
    if (isset($_POST['restore'])) {
        $id_buku = $_POST['id_buku'];
        $query = "UPDATE buku SET if_visible = 1 WHERE id_buku = '$id_buku'";
        if (mysqli_query($conn, $query)) {
            echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
            echo "<script>
                    swal({
                        title: 'Book restored successfully',
                        icon: 'success',
                        buttons: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href='recovery.php';
                    });
                  </script>";
        }
    }
    ?>

    <!-- Delete Function -->
    <?php
    if (isset($_POST['delete'])) {
        $id_buku = $_POST['id_buku'];

        // Get the cover image path
        $query = "SELECT cover FROM buku WHERE id_buku = '$id_buku'";
        $result = mysqli_query($conn, $query);
        $book = mysqli_fetch_assoc($result);

        if ($book) {
            $coverPath = $book['cover'];

            // Delete the book record
            $deleteQuery = "DELETE FROM buku WHERE id_buku = '$id_buku'";
            if (mysqli_query($conn, $deleteQuery)) {
                // Delete the cover image file if it exists
                if (file_exists($coverPath)) {
                    unlink($coverPath);
                }

                echo "<script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>";
                echo "<script>
                        swal({
                            title: 'Book deleted successfully',
                            icon: 'success',
                            buttons: false,
                            timer: 1500
                        }).then(function() {
                            window.location.href='recovery.php';
                        });
                      </script>";
            }
        }
    }
    ?>

</body>

</html>