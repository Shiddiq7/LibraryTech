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
    <title>Dashboard - LibraTech</title>

    <!-- Critical CSS inline -->
    <style>
        /* Critical inline styles */
        .card {
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .qr-code-img {
            max-width: 100px;
            height: auto;
        }

        .chart-container {
            width: 100%;
            margin: 0 auto;
            height: 600px;
            background: linear-gradient(to bottom right, #ffffff, #f8f9fa);
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
        }

        .table-container {
            max-width: 100%;
            overflow-x: auto;
        }

        #datatablesSimple {
            width: 100%;
            margin: 0;
            padding: 0;
        }

        .qr-cell {
            width: 100px;
            text-align: center;
        }

        .sb-nav-fixed {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
        }

        /* Critical navbar styles */
        .sb-topnav {
            background-color: #212529;
            color: white;
            padding: 0.5rem 1rem;
        }

        .sb-sidenav-dark {
            background: linear-gradient(135deg, #161b22, #0f1217);
            color: white;
        }
    </style>

    <!-- Preload critical resources -->
    <link rel="preload" href="../assets/img/logo1.png" as="image">
    <link rel="icon" href="../assets/img/logo1.png" type="image/png" />

    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://api.qrserver.com">
    <link rel="preconnect" href="https://use.fontawesome.com">

    <!-- Non-critical CSS loaded asynchronously -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" media="print"
        onload="this.media='all'">
    <link rel="stylesheet" href="../css/styles.css" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="../css/selfstyle.css" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css">
        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/selfstyle.css">
    </noscript>

    <!-- Defer non-critical scripts -->
    <script defer src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"
        crossorigin="anonymous"></script>
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
                            href="#">
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
                            <div class="sb-sidenav-collapse-arrow" style="text-color: white;"><i
                                    class="fas fa-angle-down"></i></div>
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
                                <a class="nav-link d-flex align-items-center <?= $isActive ? 'active' : ''; ?>"
                                    href="pinjam.php"
                                    style="color: <?= $newDataCount > 0 ? '#ffffff' : ($isActive ? '#fff' : '#ffffff'); ?>">
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
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">

                        <!-- Total Buku -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div style="font-size: 20px;"
                                                class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Daftar Buku</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2">
                                                <?php
                                                $buku = query("SELECT COUNT(*) AS total FROM buku WHERE if_visible = TRUE")[0]['total'];
                                                echo "<small>Total Buku = " . $buku . "</small>";
                                                ?>
                                                <a href="daftar_buku.php" class="text-decoration-none text-primary">
                                                </a>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 mt-3 text-end">
                                                <a href="daftar_buku.php" class="text-decoration-none text-primary">View
                                                    Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Peminjaman -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div style="font-size: 20px;"
                                                class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Peminjaman Buku</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2">
                                                <?php
                                                $peminjaman = query("SELECT COUNT(*) AS total FROM pinjam where status = 'Dipinjam'")[0]['total'];
                                                echo "<small>Total Peminjaman = " . $peminjaman . "</small>";
                                                ?>

                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 mt-3 text-end">
                                                <a href="pinjam.php?status=Dipinjam"
                                                    class="text-decoration-none text-primary">View
                                                    Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengembalian -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div style="font-size: 20px;"
                                                class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Pengembalian Buku</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2">
                                                <?php
                                                $dikembalikan = query("SELECT COUNT(*) AS total FROM pinjam WHERE status = 'Dikembalikan'")[0]['total'];
                                                echo "<small>Total Dikembalikan = " . $dikembalikan . "</small>";
                                                ?>

                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 mt-3 text-end">
                                                <a href="pinjam.php?status=Dikembalikan"
                                                    class="text-decoration-none text-primary">View
                                                    Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Daftar Anggota -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div style="font-size: 20px;"
                                                class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Daftar Anggota</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 mt-2">
                                                <?php
                                                $anggota = query("SELECT COUNT(*) AS total FROM user where role = 'Anggota'")[0]['total'];
                                                echo "<small>Total Anggota = " . $anggota . "</small>";
                                                ?>
                                                <a href="daftar_anggota.php" class="text-decoration-none text-primary">
                                                </a>
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800 mt-3 text-end">
                                                <a href="daftar_anggota.php"
                                                    class="text-decoration-none text-primary">View
                                                    Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grafik -->
                <div class="chart-container">
                    <div id="loadingSpinner" style="text-align: center; padding: 250px 0;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div
                            style="margin-top: 10px; font-size: 18px; font-weight: bold; color: #666; margin-top: 10px;">
                            Loading Chart
                        </div>
                    </div>
                    <canvas id="myChart" style="height: 100%; display: none;"></canvas>
                </div>

                <script>
                    // Initialize chart when DOM is ready
                    document.addEventListener('DOMContentLoaded', function () {
                        const ctx = document.getElementById('myChart');
                        const loadingSpinner = document.getElementById('loadingSpinner');

                        <?php
                        // Optimize queries by reducing database calls
                        $datesQuery = "SELECT 
                                         DATE(tanggal_pinjam) AS date, 
                                         COUNT(*) AS total 
                                       FROM pinjam 
                                       GROUP BY DATE(tanggal_pinjam) 
                                       ORDER BY date";
                        $datesResult = query($datesQuery);
                        $labels = [];
                        $data = [];
                        foreach ($datesResult as $row) {
                            $labels[] = $row['date'];
                            $data[] = $row['total'];
                        }

                        if (empty($datesResult)) {
                            echo "loadingSpinner.style.display = 'none';";
                            echo "ctx.style.display = 'none';";
                            echo "const noDataDiv = document.createElement('div');";
                            echo "noDataDiv.style.textAlign = 'center';";
                            echo "noDataDiv.style.padding = '250px 0';";
                            echo "noDataDiv.style.fontSize = '24px';";
                            echo "noDataDiv.style.fontWeight = 'bold';";
                            echo "noDataDiv.style.color = '#666';";
                            echo "noDataDiv.innerText = 'Tidak ada Buku yang di pinjam';";
                            echo "ctx.parentNode.appendChild(noDataDiv);";
                        } else {
                            ?>
                            // Remove artificial timeout and render immediately
                            loadingSpinner.style.display = 'none';
                            ctx.style.display = 'block';

                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: <?php echo json_encode($labels) ?>,
                                    datasets: [{
                                        label: 'Buku Dipinjam',
                                        data: <?php echo json_encode($data) ?>,
                                        fill: true,
                                        backgroundColor: 'rgba(54, 162, 235, 0.1)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 3,
                                        pointRadius: 6,
                                        pointBackgroundColor: '#fff',
                                        pointBorderColor: 'rgba(54, 162, 235, 1)',
                                        pointHoverRadius: 8,
                                        tension: 0.3
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: { position: 'bottom' },
                                        title: {
                                            display: true,
                                            text: 'BUKU DIPINJAM PER-TANGGAL',
                                            font: { size: 24, weight: 'bold' }
                                        }
                                    }
                                }
                            });
                        <?php } ?>
                    });
                </script>


                <!-- Tabel Buku -->
                <div class="card mb-4 mt-4">
                    <div class="card-header">
                        <i class="fas fa-table me-1"></i>
                        Tabel Buku
                    </div>
                    <div class="card-body table-container">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th class="qr-cell">QR Code</th>
                                    <th>ID Buku</th>
                                    <th>Judul Buku</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Tahun Terbit</th>
                                    <th>Jumlah Halaman</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Limit initial query results for faster page load
                                $query = "SELECT * FROM buku WHERE if_visible = TRUE LIMIT 20";
                                $result = mysqli_query($conn, $query);
                                while ($data = mysqli_fetch_assoc($result)) {
                                    $qrData = $data['id_buku'] . ', ' . $data['judul'] . ', ' . $data['pengarang'] . ', ' . $data['penerbit'] . ', ' . $data['tahun_terbit'] . ', ' . $data['halaman'];
                                    $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=' . urlencode($qrData);
                                    ?>
                                    <tr>
                                        <td class="qr-cell">
                                            <img src="<?= $qrCodeUrl ?>" alt="QR Code" class="qr-code-img" loading="lazy"
                                                width="100" height="100" fetchpriority="low">
                                        </td>
                                        <td><?= htmlspecialchars($data['id_buku']) ?></td>
                                        <td><?= htmlspecialchars($data['judul']) ?></td>
                                        <td><?= htmlspecialchars($data['pengarang']) ?></td>
                                        <td><?= htmlspecialchars($data['penerbit']) ?></td>
                                        <td><?= htmlspecialchars($data['tahun_terbit']) ?></td>
                                        <td><?= htmlspecialchars($data['halaman']) ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- Footer -->
                <footer class="py-4"
                    style="background: linear-gradient(135deg, #1a202c, #343a40); color: #fff;  width: 100%; bottom: 0;">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-light">
                                <i class="fas fa-envelope me-2"></i>
                                <a class="text-decoration-none" style="color: #ffd700;"
                                    target="_blank">shiddiqduasatu@gmail.com</a>
                            </div>
                            <div class="text-light">
                                <i class="fab fa-whatsapp me-2"></i>
                                <a href="https://wa.me/6285320602504" class="text-decoration-none"
                                    style="color: #ffd700;" target="_blank">0853-2060-2504</a>
                            </div>
                            <div class="text-light">
                                <i class="fab fa-instagram me-2"></i>
                                <a href="https://www.instagram.com/Shiddiiq._/" class="text-decoration-none"
                                    style="color: #ffd700;" target="_blank">@Shiddiiq._</a>
                            </div>
                            <div class="text-light">
                                <i class="fab fa-github me-2"></i>
                                <a href="https://github.com/Shiddiq7" class="text-decoration-none"
                                    style="color: #ffd700;" target="_blank">Shiddiq7</a>
                            </div>
                        </div>
                    </div>
                </footer>
        </div>
        </main>
    </div>
    </div>
    <script src="../js/scripts.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" defer
        crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js" defer></script>

    <!-- Load remaining data for pagination after initial render -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // This will run after the initial page is displayed
            // It can be used to fetch additional data without blocking render
        });
    </script>
</body>

</html>