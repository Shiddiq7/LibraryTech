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
    <title>Daftar Kategori - LibraTech</title>
    <link rel="icon" href="../assets/img/logo1.png" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="../css/styles.css" rel="stylesheet" />
    <link href="../css/selfstyle.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>


</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3 d-flex align-items-center" href="#">
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
                                <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'daftar_buku.php' ? 'active' : ''; ?>"
                                    href="daftar_buku.php">Daftar Buku</a>

                                <!-- peminjaman  -->
                                <?php
                                $newDataCount = query("SELECT COUNT(*) AS total FROM pinjam WHERE status = 'Menunggu Konfirmasi'")[0]['total'];
                                $isActive = basename($_SERVER['PHP_SELF']) == 'pinjam.php';
                                ?>
                                <a class="nav-link d-flex align-items-center <?= $isActive ? 'active' : ''; ?>"
                                    href="pinjam.php"
                                    style="color: <?= $newDataCount > 0 ? '#ff9800' : ($isActive ? '#fff' : '#000'); ?>">
                                    <span class="me-auto">Peminjaman</span>
                                    <span class="badge bg-warning text-dark ms-2"><?= $newDataCount ?></span>
                                    <?php if ($newDataCount > 0): ?>
                                        <i class="fas fa-exclamation-circle ms-2 text-warning"></i>
                                    <?php endif; ?>
                                </a>


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
                    <h1 class="mt-4">Kategori Buku</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Kategori </li>
                    </ol>

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-table me-1"></i>
                                Kategori Buku
                            </div>
                            <div class="d-flex justify-content-between">

                                <!-- export -->
                                <a href="export_table/export_kategori.php"
                                    class="btn btn-outline-primary btn-sm me-4 d-flex align-items-center"
                                    style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: transform 0.2s, box-shadow 0.2s;"
                                    onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 10px rgba(0, 0, 0, 0.15)';"
                                    onmouseout="this.style.transform=''; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)';">
                                    <i class="fas fa-file-export me-2"></i>
                                    <span>Export Table</span>
                                </a>
                                <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#tambahKategori">Tambah Kategori</button>

                            </div>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
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
                                    $query = "SELECT * FROM kategori";
                                    $no = 1;
                                    $result = mysqli_query($conn, $query);
                                    while ($data = mysqli_fetch_array($result)) {
                                        $id_kat = $data['id_kat'];
                                        $nama_kategori = $data['nama_kategori'];
                                        $deskripsi = $data['Deskripsi'];


                                        ?>

                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $nama_kategori ?></td>
                                            <td><?= $deskripsi ?></td>
                                            <td>
                                                <button type="button" class="btn btn-outline-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#edit<?= $id_kat ?>">Edit</button>
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#delete<?= $id_kat ?>">Delete</button>
                                            </td>



                                            <!-- Modal edit-->
                                            <div class="modal fade" id="edit<?= $id_kat ?>" tabindex="-1"
                                                aria-labelledby="edit<?= $id_kat ?>Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="edit<?= $id_kat ?>Label">Edit Data
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body">
                                                            <form method="post">
                                                                <input type="hidden" name="id_kat" value="<?= $id_kat ?>">
                                                                <div class="mb-3">
                                                                    <label for="nama_kategori" class="form-label">Nama
                                                                        Kategori</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nama_kategori" name="nama_kategori"
                                                                        value="<?= $nama_kategori ?>" maxlength="50">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="deskripsi"
                                                                        class="form-label">Deskripsi</label>
                                                                    <textarea class="form-control" id="deskripsi"
                                                                        name="deskripsi"
                                                                        rows="3"><?= $deskripsi ?></textarea>
                                                                </div>
                                                                <br>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="editKategori"
                                                                        class="btn btn-outline-primary px-4">Edit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Modal delete-->
                                            <div class="modal fade" id="delete<?= $id_kat ?>" tabindex="-1"
                                                aria-labelledby="delete<?= $id_kat ?>Label" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content ">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="delete<?= $id_kat ?>Label">Delete
                                                                Data</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Kamu yakin ingin menghapus Kategori <?= $nama_kategori ?>
                                                                <?= "[", $id_kat, "]" ?> ?
                                                            </p>
                                                            <br>
                                                            <form method="post">
                                                                <input type="hidden" name="id_kat" value="<?= $id_kat ?>">
                                                                <input type="hidden" name="if_visible">
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="deleteKategori"
                                                                        class="btn btn-outline-danger px-4 me-2">Iya</button>
                                                                    <button type="button"
                                                                        class="btn btn-outline-secondary px-4"
                                                                        data-bs-dismiss="modal">Tidak</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </tr>

                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah Kategori-->
    <div class="modal fade" id="tambahKategori" tabindex="-1" aria-labelledby="tambahKategoriLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKategoriLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <input type="hidden" name="id_kat">
                        <div class="mb-3">
                            <label for="nama_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required
                                maxlength="50">
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                        </div>
                        <br>
                        <button type="submit" name="tambahKategori"
                            class="btn btn-outline-primary w-100 rounded-pill">Submit</button>
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
    <script>
        function togglePassword() {
            var x = document.getElementById("inputPassword");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>