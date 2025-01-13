<?php
require "../func.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - LibraryTech</title>
    <link rel="icon" href="../assets/img/logo1.png" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3 d-flex align-items-center" href="index.php">
            <img src="../assets/img/logo1.png" width="80" height="80" class="d-inline-block align-top" alt="">
            <span class="ms-2">LibraryTech</span>
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
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading"></div>
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>"
                            href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>

                        <div class="sb-sidenav-menu-heading">Management</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLibrary" aria-expanded="false" aria-controls="collapseLibrary">
                            <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                            Library
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>

                        <div class="collapse" id="collapseLibrary" aria-labelledby="headingOne"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'daftar_buku.php' ? 'active' : ''; ?>"
                                    href="layout-static.html">Daftar Buku</a>
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'peminjaman.php' ? 'active' : ''; ?>"
                                    href="layout-sidenav-light.html">Peminjaman</a>
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pengembalian.php' ? 'active' : ''; ?>"
                                    href="layout-sidenav-dark.html">Pengembalian</a>
                            </nav>
                        </div>

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
                    <h1 class="mt-4">Daftar Buku</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Daftar Buku</li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-table me-1"></i>
                                Buku
                            </div>

                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#tambahBuku">Tambah Buku</button>
                        </div>
                        <div class="card-body">
                            <!-- Search -->
                            <form method="get" class="mb-4 d-flex justify-content-start">
                                <div class="input-group shadow-md" style="width: 400px;">
                                    <input class="form-control" type="text" name="search" id="searchInput"
                                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                                        placeholder="Search for..." aria-label="Search for..."
                                        aria-describedby="btnNavbarSearch" onkeyup="filterData()" />
                                </div>
                            </form>

                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 d-flex flex-wrap">
                                <?php
                                $search = isset($_GET['search']) ? $_GET['search'] : '';

                                $buku = query("SELECT * FROM buku WHERE judul LIKE '%$search%' OR pengarang LIKE '%$search%' OR penerbit LIKE '%$search%' OR kategori LIKE '%$search%'");
                                foreach ($buku as $bk):
                                    ?>
                                    <div class="col mb-2">
                                        <div class="card h-100 shadow-lg">
                                            <div class="card h-100">
                                                <img class="card-img-top" src="<?= $bk['cover']; ?>" alt="Book Cover"
                                                    style="object-fit: cover; width: 100%; height: 500px;">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $bk['judul']; ?></h5>
                                                <p class="card-text"><?= $bk['pengarang']; ?></p>
                                                <p class="card-text"><span class="badge bg-secondary">Penerbit:</span>
                                                    <?= $bk['penerbit']; ?></p>
                                                <p class="card-text"><span class="badge bg-secondary">Tahun Terbit:</span>
                                                    <?= $bk['tahun_terbit']; ?></p>
                                                <p class="card-text"><span class="badge bg-secondary">Jumlah Halaman:</span>
                                                    <?= $bk['halaman']; ?></p>
                                                <p class="card-text"><span class="badge bg-secondary">Kategori:</span>
                                                    <?= $bk['kategori']; ?></p>
                                                <div class="d-flex justify-content-end">
                                                    <a href="detail_buku.php?id_buku=<?= $bk['id_buku']; ?>"
                                                        class="btn btn-outline-primary">Lihat Detail</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>


    <!-- Modal Tambah Buku -->
    <div class="modal fade" id="tambahBuku" tabindex="-1" aria-labelledby="tambahBukuLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahBukuLabel">Tambah Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" id="id_buku" name="id_buku">

                        <div class="mb-3">
                            <label for="cover" class="form-label">Cover Buku</label>
                            <input type="file" class="form-control" id="cover" name="cover" accept=".jpg, .jpeg, .png"
                                required onchange="previewImage()">
                        </div>
                        <img src="" id="preview" style="max-width:200px;max-height:200px; display:block; margin: 0 auto; margin-bottom: 1rem;">

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" required maxlength="50">
                        </div>

                        <div class="mb-3">
                            <label for="pengarang" class="form-label">Pengarang</label>
                            <input type="text" class="form-control" id="pengarang" name="pengarang" required
                                maxlength="50">
                        </div>

                        <div class="mb-3">
                            <label for="penerbit" class="form-label">Penerbit</label>
                            <input type="text" class="form-control" id="penerbit" name="penerbit" required
                                maxlength="50">
                        </div>

                        <div class="mb-3">
                            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                            <input type="number" class="form-control" id="tahun_terbit" name="tahun_terbit" required>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_halaman" class="form-label">Jumlah Halaman</label>
                            <input type="number" class="form-control" id="halaman" name="halaman" required
                                maxlength="30">
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="fiksi">Fiksi</option>
                                <option value="non-fiksi">Non-Fiksi</option>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" name="tambahBuku">Tambah Buku</button>
                    </form>
                </div>
            </div>
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