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
    <title>Daftar Buku - LibraTech</title>
    <link rel="icon" href="../assets/img/logo1.png" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/selfstyle.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3 d-flex align-items-center" href="index.php">
            <img src="../assets/img/logo1.png" width="80" height="80" class="d-inline-block align-top" alt="">
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
                    <li><a class="dropdown-item" href="../Auth/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion"
                style="background: linear-gradient(135deg, #3a3f44, #1a1d21);">
                <div class="sb-sidenav-menu" style="color: #ffffff;">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading"></div>
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>"
                            href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Management</div>
                        <?php
                        $newLibraryCount = query("SELECT COUNT(*) AS total FROM pinjam WHERE status = 'Menunggu Konfirmasi'")[0]['total'];
                        ?>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLibrary" aria-expanded="false" aria-controls="collapseLibrary">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Library
                            <?php if ($newLibraryCount > 0): ?>
                                <span style="margin-left: 20px;" class="dot bg-warning"></span>
                            <?php endif; ?>
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="collapse" id="collapseLibrary" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <!-- daftar buku -->
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'daftar_buku.php' ? 'active' : ''; ?>"
                                    href="daftar_buku.php">Daftar Buku</a>

                                <!-- peminjaman  -->
                                <?php
                                $newDataCount = query("SELECT COUNT(*) AS total FROM pinjam WHERE status = 'Menunggu Konfirmasi'")[0]['total'];
                                $isActive = basename($_SERVER['PHP_SELF']) == 'pinjam.php';
                                ?>
                                <a class="nav-link <?= $isActive ? 'active text-highlight' : ''; ?>" href="pinjam.php"
                                    style="color: <?= $newDataCount > 0 ? 'orange' : ($isActive ? 'white' : ''); ?>">
                                    Peminjaman
                                    <?php if ($newDataCount > 0): ?>
                                        <span class="dot bg-warning"></span>
                                    <?php endif; ?>
                                </a>

                                <!-- pengembalian  -->
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pengembalian.php' ? 'active' : ''; ?>"
                                    href="layout-sidenav-dark.html">Pengembalian</a>
                            </nav>
                        </div>

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


                    </div>
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Daftar Buku Pinjam</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Peminjaman</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-table me-1"></i>
                                Buku
                            </div>


                        </div>
                        <div class="card-body">
                            <!-- Search -->
                            <form method="get" class="mb-4 d-flex justify-content-between">
                                <div class="input-group shadow-md" style="width: 400px;">
                                    <input class="form-control" type="text" name="search" id="searchInput"
                                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                                        placeholder="Search for..." aria-label="Search for..."
                                        aria-describedby="btnNavbarSearch" onkeyup="filterData()" />

                                </div>
                            </form>

                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 d-flex flex-wrap">
                                <?php
                                if (isset($_GET['search'])) {
                                    $search = $_GET['search'];
                                    $pinjam = query("SELECT * FROM pinjam WHERE id_buku LIKE '%$search%' OR judul LIKE '%$search%' 
                                        OR pengarang LIKE '%$search%' OR penerbit LIKE '%$search%' 
                                        OR username LIKE '%$search%' ORDER BY FIELD(status, 'Menunggu Konfirmasi') DESC");
                                } else {
                                    $pinjam = query("SELECT * FROM pinjam ORDER BY FIELD(status, 'Menunggu Konfirmasi')  DESC");
                                }

                                if (count($pinjam) > 0) {
                                    foreach ($pinjam as $pj):
                                        ?>
                                        <div class="col mb-2">
                                            <div class="card h-100 shadow-lg">
                                                <div class="card h-100">
                                                    <img class="card-img-top" src="<?= $pj['cover']; ?>" alt="Book Cover"
                                                        style="object-fit: cover; width: 100%; height: 500px;">
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= $pj['judul']; ?> [<?= $pj['id_buku']; ?>]</h5>
                                                    <p class="card-text"><?= $pj['pengarang']; ?></p>
                                                    <p class="card-text"><span class="badge bg-secondary">Penerbit:</span>
                                                        <?= $pj['penerbit']; ?></p>

                                                    <p class="card-text"><span class="badge bg-secondary">Username:</span>
                                                        <?= $pj['username']; ?> [<?= $pj['id_user']; ?>]</p>
                                                    <p class="card-text"><span class="badge bg-secondary">Tanggal Pinjam:</span>
                                                        <?= $pj['tanggal_pinjam']; ?></p>
                                                    <p class="card-text"><span class="badge bg-secondary">Tanggal
                                                            Kembali:</span>
                                                        <?= $pj['tanggal_kembali']; ?></p>
                                                    <p class="card-text">
                                                        <span
                                                            class="badge <?= $pj['status'] == 'Menunggu Konfirmasi' ? 'bg-warning' : ($pj['status'] == 'Dipinjam' ? 'bg-success' : ($pj['status'] == 'Dikembalikan' ? 'bg-secondary' : '')); ?>">Status:</span>

                                                        <span
                                                            style="color: <?= $pj['status'] == 'Menunggu Konfirmasi' ? 'orange' : ($pj['status'] == 'Dipinjam' ? 'green' : ($pj['status'] == 'Dikembalikan' ? '' : '')) ?>">
                                                            <?= $pj['status']; ?>
                                                        </span>
                                                    </p>
                                                    <hr class="my-2"><br>

                                                    <div class="d-flex justify-content-end">
                                                        <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                                            data-bs-target="#confirmModal<?= $pj['id_pinjam'] ?>"
                                                            <?= $pj['status'] == 'Dipinjam' || $pj['status'] == 'Dikembalikan' ? 'disabled' : ''; ?>>Confirm</button>
                                                    </div>

                                                    <!-- Modal Pinjam -->
                                                    <div class="modal fade" id="confirmModal<?= $pj['id_pinjam'] ?>"
                                                        tabindex="-1" aria-labelledby="confirmModalLabel<?= $pj['id_pinjam'] ?>"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="confirmModalLabel<?= $pj['id_pinjam'] ?>">Konfirmasi
                                                                        Peminjaman</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Kamu yakin ingin mengonfirmasi peminjaman buku ini?
                                                                    <ul>
                                                                        <li>Judul: <?= $pj['judul'] ?> [<?= $pj['id_buku'] ?>]
                                                                        </li>
                                                                        <li>User: <?= $pj['username'] ?> [<?= $pj['id_user'] ?>]
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form method="POST">
                                                                        <input type="hidden" name="id_pinjam"
                                                                            value="<?= $pj['id_pinjam'] ?>">
                                                                        <button type="button" class="btn btn-outline-danger"
                                                                            data-bs-dismiss="modal">Close</button>
                                                                        <button type="submit" class="btn btn-outline-primary"
                                                                            name="confirmPinjam">Confirm</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
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
                    </div>
                </div>
            </main>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>

    <!--  search Buku -->
    <script>
        function filterData() {
            const searchQuery = document.getElementById('searchInput').value;
            fetch(`?search=${encodeURIComponent(searchQuery)}`)
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