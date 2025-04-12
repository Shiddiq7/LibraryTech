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
    <meta name="description" content="LibraTech - Sistem Peminjaman Buku Digital" />
    <meta name="author" content="LibraTech" />
    <title>LibraTech - <?php echo $_SESSION['username'] ?></title>

    <!-- Preload penting resources -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" as="style" />
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" as="style" />
    <link rel="preload" href="../css/styles.css" as="style" />
    <link rel="preload" href="../css/selfstyle.css" as="style" />

    <!-- Load CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="icon" href="../assets/img/logo1.png" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />

    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Load Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <script>
        // Fungsi untuk menginisialisasi dropdown
        function initializeDropdowns() {
            var dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(function (dropdown) {
                new bootstrap.Dropdown(dropdown);
            });
        }

        // Jalankan saat DOM loaded
        document.addEventListener('DOMContentLoaded', function () {
            initializeDropdowns();
        });

        // Jalankan saat window loaded (setelah semua resource dimuat)
        window.addEventListener('load', function () {
            initializeDropdowns();
        });

        // Jalankan setiap 1 detik untuk memastikan dropdown tetap berfungsi
        setInterval(function () {
            initializeDropdowns();
        }, 1000);
    </script>

    <!-- Defer non-critical JavaScript -->
    <script defer src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script defer src="../js/scripts.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
    <script defer src="../assets/demo/chart-area-demo.js"></script>
    <script defer src="../assets/demo/chart-bar-demo.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script defer src="../js/datatables-simple-demo.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.umd.js"></script>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #e5e5e5;
            min-width: 320px;
        }

        .navbar {
            border-bottom: 1px solid #e5e5e5;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 10;
        }

        .navbar-brand img {
            height: 30px;
            max-width: 100%;
        }

        .hero-section {
            text-align: center;
            padding: 60px 20px;
            margin-top: 60px;
            /* Add space below fixed navbar */
        }

        .hero-section h1 {
            font-size: clamp(1.5rem, 4vw, 2.5rem);
            /* Responsive font size */
            font-weight: 700;
            color: #4a4a4a;
        }

        .hero-section h1 span {
            color: #6f42c1;
        }

        .hero-section p {
            font-size: clamp(0.875rem, 2vw, 1rem);
            color: #6c757d;
            margin-bottom: 30px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-section .btn-primary {
            background-color: #6f42c1;
            border-color: #6f42c1;
        }

        .features {
            padding: 40px 20px;
            text-align: center;
        }

        .features .feature-item {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .features .feature-item img {
            height: auto;
            max-height: 50px;
            margin-bottom: 10px;
            width: auto;
        }

        .features .feature-item h5 {
            font-size: clamp(1rem, 2vw, 1.25rem);
            font-weight: 500;
            color: #4a4a4a;
        }

        .features .feature-item p {
            font-size: clamp(0.75rem, 1.5vw, 0.875rem);
            color: #6c757d;
        }

        footer {
            width: 100%;
            margin-top: auto;
            bottom: 0;
        }

        /* Responsive container widths */
        .container {
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            max-width: 1440px;
        }

        /* Responsive images */
        img {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 40px 10px;
            }

            .features {
                padding: 20px 10px;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
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
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            data-bs-auto-close="true" aria-expanded="false">
                            <?php if (file_exists('../assets/profile_picture/' . $_SESSION['username'] . '.png')): ?>
                                <img src="../assets/profile_picture/<?php echo $_SESSION['username'] . '.png?v=' . time(); ?>"
                                    onerror="this.src='../assets/img/default_profile_picture.png';"
                                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;"
                                    decoding="async" loading="lazy" />
                            <?php else: ?>
                                <i class="fas fa-user" style="font-size: 1.5rem;"></i>
                            <?php endif; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" data-bs-popper="none">
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
                            <li>
                                <a class="dropdown-item mt-3" href="#" style="color: <?php echo $dominant_color; ?>;">
                                    <b><?php echo $_SESSION['username'] ?></b>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'bg-secondary bg-opacity-25 text-dark' : ''; ?>"
                                    href="profile.php">Profile</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="../Auth/logout.php"><b>Logout</b></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <br><br><br><br>
    <section class="features">
        <div class="container">
            <h1 class="display-4 fw-bold text-center mb-4" style="background: linear-gradient(to right, #6a11cb, #2575fc); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Daftar Peminjaman</h1>
            <div class="text-center mb-5">
                <div class="divider-custom">
                    <div class="divider-custom-line" style="background: linear-gradient(to right, #6a11cb, #2575fc); height: 3px; width: 80px; margin: 0 auto;"></div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="search-filter-container mb-5 ">
                <form method="get" class="d-flex flex-column flex-md-row justify-content-between gap-3">
                    <div class="input-group shadow-lg rounded-pill overflow-hidden" style="width: 100%; max-width: 400px;">
                        <span class="input-group-text border-0 bg-white ps-3"><i class="fas fa-search text-primary"></i></span>
                        <input class="form-control border-0 py-2" type="text" name="search" id="searchInput"
                            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                            placeholder="Cari judul, pengarang, atau penerbit..." aria-label="Search" 
                            onkeyup="filterData()" />
                    </div>
                    <div class="input-group shadow-lg rounded-pill overflow-hidden" style="width: 100%; max-width: 250px;">
                        <span class="input-group-text border-0 bg-white ps-3"><i class="fas fa-filter text-primary"></i></span>
                        <select class="form-select border-0 py-2" name="status" id="statusFilter" onchange="filterData()">
                            <option value="">Semua Status</option>
                            <option value="Menunggu Konfirmasi" <?= isset($_GET['status']) && $_GET['status'] == 'Menunggu Konfirmasi' ? 'selected' : ''; ?>>Menunggu Konfirmasi</option>
                            <option value="Dipinjam" <?= isset($_GET['status']) && $_GET['status'] == 'Dipinjam' ? 'selected' : ''; ?>>Dipinjam</option>
                            <option value="Dikembalikan" <?= isset($_GET['status']) && $_GET['status'] == 'Dikembalikan' ? 'selected' : ''; ?>>Dikembalikan</option>
                        </select>
                    </div>
                </form>
            </div>

           
            <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.umd.js"></script>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php
                $statusFilter = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
                $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
                
                // Buat query dasar dengan JOIN untuk mengambil hanya data yang diperlukan
                $query = "SELECT p.id_pinjam, p.id_buku, p.judul, p.pengarang, p.penerbit, 
                          p.cover, p.status, p.tanggal_pinjam, p.tanggal_kembali 
                          FROM pinjam p 
                          WHERE p.username = '$_SESSION[username]'";

                // Tambahkan filter pencarian jika ada
                if ($search) {
                    $query .= " AND (p.id_buku LIKE '%$search%' OR p.judul LIKE '%$search%' 
                                OR p.pengarang LIKE '%$search%' OR p.penerbit LIKE '%$search%')";
                }

                // Tambahkan filter status jika ada
                if ($statusFilter) {
                    $query .= " AND p.status = '$statusFilter'";
                }

                // Urutkan berdasarkan status dan tanggal
                $query .= " ORDER BY 
                           CASE 
                               WHEN p.status = 'Dipinjam' THEN 1
                               WHEN p.status = 'Menunggu Konfirmasi' THEN 2
                               WHEN p.status = 'Dikembalikan' THEN 3
                           END,
                           p.tanggal_pinjam DESC
                           LIMIT 50"; // Batasi hasil untuk performa lebih baik
                
                $result = mysqli_query($conn, $query);
                $pinjam = [];
                
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pinjam[] = $row;
                    }
                }

                if (count($pinjam) > 0) {
                    foreach ($pinjam as $pj):
                        // Determine status class and icon
                        $statusClass = '';
                        $statusIcon = '';
                        $statusBg = '';
                        
                        if ($pj['status'] == 'Menunggu Konfirmasi') {
                            $statusClass = 'fw-bold text-warning fs-6';
                            $statusIcon = 'fa-clock';
                            $statusBg = 'bg-warning bg-opacity-10';
                        } elseif ($pj['status'] == 'Dipinjam') {
                            $statusClass = 'fw-bold text-success fs-6';
                            $statusIcon = 'fa-book-open';
                            $statusBg = 'bg-success bg-opacity-10';
                        } elseif ($pj['status'] == 'Dikembalikan') {
                            $statusClass = 'fw-bold text-info fs-6';
                            $statusIcon = 'fa-check-circle';
                            $statusBg = 'bg-secondary bg-opacity-10';
                        }
                        ?>
                        <div class="col mb-4">
                            <div class="card h-100 shadow-lg rounded-4 book-card" style="overflow: hidden; transition: all 0.3s ease;">
                                <div class="position-relative">
                                    <img class="card-img-top book-cover" src="<?= $pj['cover']; ?>"
                                        alt="<?= htmlspecialchars($pj['judul']); ?> Cover" 
                                        style="height: 450px; object-fit: cover; transition: transform 0.5s ease;"
                                        loading="lazy" onerror="this.src='../assets/img/default_book_cover.png';">
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge rounded-pill <?= $statusBg ?> <?= $statusClass ?> px-3 py-2">
                                            <i class="fas <?= $statusIcon ?> me-1"></i> <?= $pj['status']; ?>
                                        </span>
                                    </div>
                                    <?php if ($pj['status'] == 'Dipinjam' && strtotime($pj['tanggal_kembali']) < time()): ?>
                                        <div class="position-absolute top-0 start-0 m-2">
                                            <span class="badge rounded-pill bg-danger px-3 py-2">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Terlambat
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold text-truncate"><?= $pj['judul']; ?></h5>
                                    <p class="card-text text-muted mb-1"><i class="fas fa-user-edit me-2"></i><?= $pj['pengarang']; ?></p>
                                    <p class="card-text text-muted mb-1"><i class="fas fa-building me-2"></i><?= $pj['penerbit']; ?></p>
                                    
                                    <div class="mt-3 pt-2 border-top">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted small"><i class="fas fa-calendar-alt me-1"></i> Pinjam:</span>
                                            <span class="badge bg-light text-dark"><?= date('d M Y', strtotime($pj['tanggal_pinjam'])); ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted small"><i class="fas fa-calendar-check me-1"></i> Kembali:</span>
                                            <span class="badge bg-light text-dark"><?= date('d M Y', strtotime($pj['tanggal_kembali'])); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-0 bg-white">
                                    <div class="d-flex justify-content-between gap-2">
                                        <?php
                                        $currentDate = date('Y-m-d');
                                        $isLate = $currentDate > $pj['tanggal_kembali'];
                                        ?>
                                        <button class="btn <?= $isLate ? 'btn-danger' : 'btn-primary'; ?> rounded-pill flex-grow-1"
                                            data-bs-toggle="modal" data-bs-target="#kembaliModal<?= $pj['id_pinjam'] ?>"
                                            <?= $pj['status'] == 'Dikembalikan' ? 'disabled' : ''; ?>>
                                            <i class="fas fa-undo-alt me-1"></i> Kembalikan
                                        </button>

                                        <button class="btn btn-primary rounded-pill flex-grow-1" 
                                            <?= $pj['status'] == 'Menunggu Konfirmasi' || $pj['status'] == 'Dikembalikan' ? 'disabled' : ''; ?>>
                                            <i class="fas <?= $pj['status'] == 'Dikembalikan' ? 'fa-check' : 'fa-book-reader'; ?> me-1"></i>
                                            <?= $pj['status'] == 'Dikembalikan' ? 'Dikembalikan' : 'Baca Buku' ?>
                                        </button>
                                    </div>
                                </div>

                                <!-- Modal Kembali -->
                                <div class="modal fade" id="kembaliModal<?= $pj['id_pinjam'] ?>" tabindex="-1"
                                    aria-labelledby="kembaliModalLabel<?= $pj['id_pinjam'] ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                            <div class="modal-header border-0"
                                                style="background: linear-gradient(to right, #6a11cb, #2575fc); color: white;">
                                                <h5 class="modal-title" id="kembaliModalLabel<?= $pj['id_pinjam'] ?>">
                                                    <i class="fas fa-book me-2"></i> Konfirmasi Pengembalian
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row g-4">
                                                    <div class="col-md-4">
                                                        <img src="<?= $pj['cover'] ?>" alt="Cover Buku"
                                                            class="img-fluid rounded-4 shadow-sm" style="width: 100%; height: 300px; object-fit: cover;">
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h4 class="mb-3 fw-bold text-primary">
                                                            Detail Buku
                                                        </h4>
                                                        <div class="card border-0 shadow-sm rounded-4 mb-4">
                                                            <ul class="list-group list-group-flush rounded-4">
                                                                <li class="list-group-item border-0 d-flex">
                                                                    <span class="text-muted me-2 w-25"><i class="fas fa-book me-2"></i>Judul:</span>
                                                                    <span class="fw-medium"><?= $pj['judul'] ?></span>
                                                                </li>
                                                                <li class="list-group-item border-0 d-flex">
                                                                    <span class="text-muted me-2 w-25"><i class="fas fa-user-edit me-2"></i>Pengarang:</span>
                                                                    <span class="fw-medium"><?= $pj['pengarang'] ?></span>
                                                                </li>
                                                                <li class="list-group-item border-0 d-flex">
                                                                    <span class="text-muted me-2 w-25"><i class="fas fa-building me-2"></i>Penerbit:</span>
                                                                    <span class="fw-medium"><?= $pj['penerbit'] ?></span>
                                                                </li>
                                                                <li class="list-group-item border-0 d-flex">
                                                                    <span class="text-muted me-2 w-25"><i class="fas fa-calendar-alt me-2"></i>Pinjam:</span>
                                                                    <span class="fw-medium"><?= date('d M Y', strtotime($pj['tanggal_pinjam'])) ?></span>
                                                                </li>
                                                                <li class="list-group-item border-0 d-flex">
                                                                    <span class="text-muted me-2 w-25"><i class="fas fa-calendar-check me-2"></i>Kembali:</span>
                                                                    <span class="fw-medium"><?= date('d M Y', strtotime($pj['tanggal_kembali'])) ?></span>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <?php
                                                        $tanggal_kembali = date_create($pj['tanggal_kembali']);
                                                        $now = date_create();
                                                        $diff = date_diff($tanggal_kembali, $now);
                                                        $daysLeft = $diff->format('%a');
                                                        ?>
                                                        <div class="alert alert-info rounded-4 border-0 shadow-sm" role="alert">
                                                            <i class="fas fa-info-circle me-2"></i> Apakah Anda yakin ingin
                                                            mengembalikan buku ini?
                                                            <br> Waktu pinjam masih tersisa
                                                            <strong><?= $daysLeft ?></strong> hari lagi.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0">
                                                <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <form method="POST">
                                                    <input type="hidden" name="id_pinjam"
                                                        value="<?= $pj['id_pinjam'] ?>">
                                                    <button type="submit" class="btn btn-primary rounded-pill px-4"
                                                        <?= $pj['status'] == 'Dikembalikan' ? 'disabled' : ''; ?>
                                                        name="kembali">Kembalikan Sekarang</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <div class="col-12">
                        <div class="card border-0 shadow-lg rounded-4 py-5">
                            <div class="card-body text-center">
                                <i class="fas fa-times-circle text-muted" style="font-size: 100px; margin-bottom: 20px;"></i>
                                <?php
                                $filterStatus = isset($_GET['status']) ? $_GET['status'] : 'Semua';
                                $statusText = 'Belum Ada Buku yang Dipinjam';
                                switch ($filterStatus) {
                                    case 'Dipinjam':
                                        $statusText = 'Belum Ada Buku yang Sedang Dipinjam';
                                        break;
                                    case 'Dikembalikan':
                                        $statusText = 'Belum Ada Buku yang Sudah Dikembalikan';
                                        break;
                                }
                                ?>
                                <h4 class="text-muted"><?= $statusText ?></h4>
                                <p class="text-muted mt-4">Silakan kunjungi halaman dashboard untuk meminjam buku</p>
                                <a href="dashboard.php" class="btn btn-primary rounded-pill px-4 mt-3">
                                    <i class="fas fa-search me-2"></i> Cari Buku
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>




    <!-- Footer -->
    <footer class="footer mt-auto"
        style="background: linear-gradient(129deg, #1a202c 0%, #010035 100%); font-size: 0.8rem; ">
        <div class="container py-3">
            <div class="row g-4 justify-content-center">
                <!-- Logo and Description -->
                <div class="col-md-4 text-center">
                    <div class="mb-4 d-flex align-items-center ms-5">
                        <img src="../assets/img/logo1.png" alt="LibraryTech Logo" style="height: 60px;">
                        <span class="ms-2 text-white fs-4">LibraTech</span>
                    </div>
                    <p class="text-light opacity-75 text-start">
                        Transforming the way you access knowledge. Modern library solutions for the digital age.
                    </p>
                </div>
                <div class="col-md-4 absolute;">
                    <h6 class="text-white mb-3 fw-bold text-center">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-center"><a href="dashboard.php"
                                class="text-light text-decoration-none <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'opacity-100' : 'opacity-75'; ?>"
                                style="transition: all 0.3s;" onmouseover="this.style.color='#ffd700'"
                                onmouseout="this.style.color='#fff'">Dashboard</a>
                        </li>
                        <li class="mb-2 text-center"><a href="pinjam.php"
                                class="text-light text-decoration-none <?php echo basename($_SERVER['PHP_SELF']) == 'pinjam.php' ? 'opacity-100' : 'opacity-75'; ?>"
                                style="transition: all 0.3s;" onmouseover="this.style.color='#ffd700'"
                                onmouseout="this.style.color='#fff'">Peminjaman</a>
                        </li>

                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-white mb-3 fw-bold text-start">Contact</h6>
                    <div class="text-light opacity-75 text-start">
                        <p class="mb-2" style="transition: all 0.3s;" onmouseover="this.style.color='#ffd700'"
                            onmouseout="this.style.color='#fff'"><i class="fas fa-envelope me-2"></i> <span
                                style="margin-left: 8px;">Shiddiqduasatu@gmail.com</span></p>

                        <p class="mb-2" style="transition: all 0.3s;" onmouseover="this.style.color='#ffd700'"
                            onmouseout="this.style.color='#fff'"><i class="fab fa-whatsapp me-2"></i> <span
                                style="margin-left: 8px;">0853-2060-2504</span></p>

                        <p class="mb-2"><i class="fab fa-instagram me-2"></i><span style="margin-left: 8px;"><a
                                    href="https://www.instagram.com/Shiddiiq._/" class="text-light text-decoration-none"
                                    style="transition: all 0.3s;" onmouseover="this.style.color='#ffd700'"
                                    onmouseout="this.style.color='#fff'">Shiddiiq._</a></span></p>

                        <p class="mb-2"><i class="fab fa-github me-2"></i><span style="margin-left: 8px;"><a
                                    href="https://github.com/Shiddiq7" class="text-light text-decoration-none"
                                    style="transition: all 0.3s;" onmouseover="this.style.color='#ffd700'"
                                    onmouseout="this.style.color='#fff'">Shiddiq7</a></span></p>

                        <p class="mb-2" style="transition: all 0.3s;" onmouseover="this.style.color='#ffd700'"
                            onmouseout="this.style.color='#fff'"><i class="fas fa-map-marker-alt me-2"></i> <span
                                style="margin-left: 8px;"><a href="https://www.google.com/maps/place/Bandung,+Indonesia"
                                    class="text-light text-decoration-none" target="_blank"
                                    style="transition: all 0.3s;" onmouseover="this.style.color='#ffd700'"
                                    onmouseout="this.style.color='#fff'">Bandung, Indonesia</a></span>
                        </p>

                    </div>
                </div>
            </div>
        </div>
        <div class="py-2 text-center" style="background: rgba(0,0,0,0.2);">
            <small class="text-white" style="font-size: 0.8rem;">&copy; 2025 LibraTech | Shiddiq | All rights
                reserved</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="../assets/demo/chart-area-demo.js"></script>
    <script src="../assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>

    <!--  search Buku -->
    <script>
        function filterData() {
            const searchQuery = document.getElementById('searchInput').value;
            const statusFilter = document.getElementById('statusFilter').value;
            fetch(`?search=${encodeURIComponent(searchQuery)}&status=${encodeURIComponent(statusFilter)}`)
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const newContent = doc.querySelector('.row');
                    document.querySelector('.row').innerHTML = newContent.innerHTML;
                });
        }
    </script>

</body>



</html>