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
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>LibraTech - <?php echo $_SESSION['username'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet" />
    <link rel="icon" href="../assets/img/logo1.png" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
                            data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user-circle"></i></a>
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

    <br><br><br><br>
    <section class="features">
        <div class="container">
            <h1 class="display-4 fw-bold text-center">Daftar Peminjaman</h1>
            <hr class="my-4" />

            <br><br>

            <!-- Search and Filter -->
            <form method="get" class="mb-4 d-flex flex-column flex-md-row justify-content-between">
                <div class="input-group shadow-md mb-3 mb-md-0" style="width: 100%; max-width: 400px;">
                    <input class="form-control" type="text" name="search" id="searchInput"
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                        placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch"
                        onkeyup="filterData()" />
                </div>
                <div class="input-group shadow-md ms-md-2" style="width: 100%; max-width: 200px;">
                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-filter"></i></span>
                    <select class="form-select" name="status" id="statusFilter" onchange="filterData()">
                        <option value="">All Status</option>
                        <option value="Menunggu Konfirmasi" <?= isset($_GET['status']) && $_GET['status'] == 'Menunggu Konfirmasi' ? 'selected' : ''; ?>>Menunggu Konfirmasi</option>
                        <option value="Dipinjam" <?= isset($_GET['status']) && $_GET['status'] == 'Dipinjam' ? 'selected' : ''; ?>>Dipinjam</option>
                        <option value="Dikembalikan" <?= isset($_GET['status']) && $_GET['status'] == 'Dikembalikan' ? 'selected' : ''; ?>>Dikembalikan</option>
                    </select>
                </div>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const cards = document.querySelectorAll('.card');
                    cards.forEach(card => {
                        const img = card.querySelector('img');
                        if (img) {
                            const colorThief = new ColorThief();
                            if (img.complete) {
                                imgLoaded(card, colorThief.getColor(img));
                            } else {
                                img.addEventListener('load', function () {
                                    imgLoaded(card, colorThief.getColor(img));
                                });
                            }
                        }
                    });

                    function imgLoaded(card, color) {
                        const rgbColor = `rgb(${color[0] + 50}, ${color[1] + 50}, ${color[2] + 50})`;
                        card.addEventListener('mouseover', function () {
                            card.style.boxShadow = `0 0 50px ${rgbColor}`;
                        });
                        card.addEventListener('mouseout', function () {
                            card.style.boxShadow = '';
                        });
                    }
                });
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.umd.js"></script>
            
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 d-flex flex-wrap">
                <?php
                $statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $query = "SELECT * FROM pinjam WHERE username = '$_SESSION[username]'";

                if ($search) {
                    $query .= " AND (id_buku LIKE '%$search%' OR judul LIKE '%$search%' 
                                OR pengarang LIKE '%$search%' OR penerbit LIKE '%$search%' 
                                OR username LIKE '%$search%')";
                }

                if ($statusFilter) {
                    $query .= " AND status = '$statusFilter'";
                }

                $query .= " ORDER BY FIELD(status, 'Dipinjam') DESC, FIELD(status, 'Dikembalikan') ASC";
                $pinjam = query($query);

                if (count($pinjam) > 0) {
                    foreach ($pinjam as $pj):
                        ?>
                        <div class="col mb-2">
                            <div class="card h-100 shadow-lg" id="cardpinjam">
                                <div class="card h-100">
                                    <img class="card-img-top" src="<?= $pj['cover']; ?>" alt="Book Cover"
                                        style="object-fit: cover; width: 100%; height: 500px;">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?= $pj['judul']; ?> [<?= $pj['id_buku']; ?>]</h5>
                                    <p class="card-text"><?= $pj['pengarang']; ?></p>
                                    <p class="card-text text-start"><span class="badge bg-secondary">Penerbit:</span>
                                        <?= $pj['penerbit']; ?></p>

                                    <p class="card-text text-start"><span class="badge bg-secondary">Username:</span>
                                        <?= $pj['username']; ?> [<?= $pj['id_user']; ?>]</p>
                                    <p class="card-text text-start"><span class="badge bg-secondary">Tanggal Pinjam:</span>
                                        <?= $pj['tanggal_pinjam']; ?></p>
                                    <p class="card-text text-start"><span class="badge bg-secondary">Tanggal
                                            Kembali:</span>
                                        <?= $pj['tanggal_kembali']; ?></p>
                                    <p class="card-text text-start">
                                        <span
                                            class="badge <?= $pj['status'] == 'Menunggu Konfirmasi' ? 'bg-warning' : ($pj['status'] == 'Dipinjam' ? 'bg-success' : ($pj['status'] == 'Dikembalikan' ? 'bg-secondary' : '')); ?>">Status:
                                        </span>

                                        <span
                                            style="color: <?= $pj['status'] == 'Menunggu Konfirmasi' ? 'orange' : ($pj['status'] == 'Dipinjam' ? 'green' : ($pj['status'] == 'Dikembalikan' ? '' : '')) ?>">
                                            <?= $pj['status']; ?>
                                        </span>

                                    </p>
                                    <?php if ($pj['status'] == 'Dipinjam' && strtotime($pj['tanggal_kembali']) < time()): ?>
                                        <p class="card-text text-start text-danger">
                                            <span class="badge bg-danger">Terlambat</span>
                                            Terlambat dikembalikan
                                        </p>
                                    <?php endif; ?>

                                    <hr class="my-2"><br>
                                   
                                    <div class="d-flex justify-content-between">
                                        <?php
                                        $currentDate = date('Y-m-d');
                                        $isLate = $currentDate > $pj['tanggal_kembali'];
                                        ?>
                                        <button class="btn <?= $isLate ? 'btn-danger' : 'btn-outline-secondary'; ?>"
                                            data-bs-toggle="modal" data-bs-target="#kembaliModal<?= $pj['id_pinjam'] ?>"
                                            <?= $pj['status'] == 'Dikembalikan' ? 'disabled' : ''; ?>>Kembalikan Buku
                                        </button>



                                        <!-- Modal Kembali -->
                                        <div class="modal fade" id="kembaliModal<?= $pj['id_pinjam'] ?>" tabindex="-1"
                                            aria-labelledby="kembaliModalLabel<?= $pj['id_pinjam'] ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="kembaliModalLabel<?= $pj['id_pinjam'] ?>">
                                                            Konfirmasi Pengembalian
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <img src="<?= $pj['cover'] ?>" alt="Cover Buku"
                                                                    class="img-thumbnail">
                                                            </div>
                                                            <div class="col-8" style="text-align: left;">
                                                                <p class="card-text"><strong>Judul:</strong> <?= $pj['judul'] ?>
                                                                </p>
                                                                <p class="card-text"><strong>Pengarang:</strong>
                                                                    <?= $pj['pengarang'] ?></p>
                                                                <p class="card-text"><strong>Tanggal Pinjam:</strong>
                                                                    <?= $pj['tanggal_pinjam'] ?></p>
                                                                <br>
                                                                <?php
                                                                $tanggal_kembali = date_create($pj['tanggal_kembali']);
                                                                $now = date_create();
                                                                $diff = date_diff($tanggal_kembali, $now);
                                                                $daysLeft = $diff->format('%a');
                                                                ?>
                                                                <p>Apakah Anda yakin ingin mengembalikan buku ini? <p>Waktu pinjam masih tersisa  <?= $daysLeft ?> hari lagi.</p></p>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <form method="POST">
                                                            <input type="hidden" name="id_pinjam"
                                                                value="<?= $pj['id_pinjam'] ?>">
                                                            <button type="submit" class="btn btn-outline-primary"
                                                                <?= $pj['status'] == 'Dikembalikan' ? 'disabled' : ''; ?>
                                                                name="kembali">Kembalikan</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-outline-primary" <?= $pj['status'] == 'Menunggu Konfirmasi' || $pj['status'] == 'Dikembalikan' ? 'disabled' : ''; ?>>
                                            <?= $pj['status'] == 'Dikembalikan' ? 'Dikembalikan' : 'Baca Buku' ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php } else {
                    ?>
                    <div class=" col-12">
                        <div class="card h-100 shadow-md">
                            <div class="card-body d-flex justify-content-center">
                                <h5 class="card-title">Buku Pinjam Kosong</h5>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </section>




    <!-- Footer -->

    <footer class="footer mt-3"
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
            <small class="text-white" style="font-size: 0.8rem;">© 2025 LibraTech | Shiddiq | All rights
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