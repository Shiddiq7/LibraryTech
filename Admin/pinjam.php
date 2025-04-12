<?php
require "../func.php";
require "../Auth/cek_log.php";

require "../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : 0;
$pinjam = query("SELECT * FROM pinjam WHERE id_user = $id_user AND status = 'Dipinjam' ORDER BY tanggal_kembali ASC");

foreach ($pinjam as $pj) {
    if (strtotime($pj['tanggal_kembali']) < time()) {
        $lastSent = isset($_SESSION['pengingat_' . $pj['id_pinjam']]) ? $_SESSION['pengingat_' . $pj['id_pinjam']] : 0;
        // limit pengiriman email pengingat 5 jam sekali
        if (time() - $lastSent >= 5 * 3600) { // 5 hours
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'libratech21@gmail.com';
                $mail->Password = 'wwxhbkuejyygwrvl';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                // pengirim
                $mail->setFrom('no-reply@librarytech.com', 'LibraTech');

                // penerima
                $email_user = query("SELECT Email FROM pinjam WHERE id_pinjam = " . $pj['id_pinjam'] . " LIMIT 1");
                if (isset($email_user[0]['Email'])) {
                    $mail->addAddress($email_user[0]['Email']);
                }

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Pengingat Penting: Pengembalian Buku Terlambat';
                $pengingat = query("SELECT username FROM pinjam WHERE Email = '" . $email_user[0]['Email'] . "'");
                $mail->Body = '<p>Yth. ' . $pengingat[0]['username'] . ',</p>
                <p>Dengan hormat, kami ingin memberitahukan bahwa Anda telah melewati batas waktu pengembalian untuk buku :</p>
                <p><strong>Judul Buku:</strong> ' . $pj['judul'] . '</p>
                <p><strong>ID Buku:</strong> ' . $pj['id_buku'] . '</p>
                <p><strong>Tanggal Peminjaman:</strong> ' . $pj['tanggal_pinjam'] . '</p>
                <p><strong>Tanggal Pengembalian:</strong> ' . $pj['tanggal_kembali'] . '</p>
                <p>Kami mohon agar Anda dapat segera mengembalikan buku tersebut.</p>
                <p>Terima kasih atas perhatian dan kerja sama Anda.</p>
                <p>Salam hormat,</p>
                <p><strong>Tim LibraTech</strong></p>';

                $mail->send();

                $_SESSION['pengingat_' . $pj['id_pinjam']] = time();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="LibraTech - Sistem Manajemen Perpustakaan Digital" />
    <meta name="author" content="LibraTech" />
    <title>Daftar Buku - LibraTech</title>

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
        /* Card loading styles */
        .card {
            position: relative;
            transition: transform 0.3s ease-in-out;
            background: #fff;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-loading {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10;
            border-radius: 0.25rem;
        }

        .card-spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #3498db;
            border-radius: 50%;
            animation: cardSpin 1s linear infinite;
        }

        .card.loading .card-loading {
            display: flex;
        }

        @keyframes cardSpin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
            padding: 1rem;
        }

        .card-img-container {
            position: relative;
            padding-top: 140%;
            /* Aspect ratio 1.4:1 */
            overflow: hidden;
            background: #f8f9fa;
        }

        .card-img-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card-img-top.loaded {
            opacity: 1;
        }

        .card-img-placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #adb5bd;
            font-size: 2rem;
        }

        .card-body {
            background: #fff;
            padding: 1.25rem;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.35em 0.65em;
        }

        @media (max-width: 768px) {
            .book-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
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
                            href="#">
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
                    <h1 class="mt-4">Daftar Buku Pinjam & Kembali</h1>
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

                            <form method="get" class="mb-4">
                                <div class="row g-3">
                                    <!-- Search -->
                                    <div class="col-12 col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0">
                                                <i class="fas fa-search text-primary"></i>
                                            </span>
                                            <input type="text" class="form-control border-0 shadow-sm" name="search"
                                                id="searchInput"
                                                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                                                placeholder="Search for..." aria-label="Search"
                                                onkeyup="debounce(filterData, 300)()" />
                                        </div>
                                    </div>

                                    <!-- Export -->
                                    <div class="col-12 col-md-3">
                                        <div class="dropdown">
                                            <button class="btn btn-outline-primary dropdown-toggle w-100" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-file-export me-2"></i> Export Table
                                            </button>
                                            <ul class="dropdown-menu w-100">
                                                <li>
                                                    <h6 class="dropdown-header">Export By Status</h6>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="export_table/export_pinjam.php?status=">
                                                        <i class="fas fa-circle text-primary me-2"></i> All Status</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="export_table/export_pinjam.php?status=Menunggu+Konfirmasi">
                                                        <i class="fas fa-circle text-warning me-2"></i> Menunggu
                                                        Konfirmasi</a></li>
                                                <li><a class="dropdown-item"
                                                        href="export_table/export_pinjam.php?status=Dipinjam">
                                                        <i class="fas fa-circle text-success me-2"></i> Dipinjam</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="export_table/export_pinjam.php?status=Dikembalikan">
                                                        <i class="fas fa-circle text-secondary me-2"></i>
                                                        Dikembalikan</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Status Filter -->
                                    <div class="col-12 col-md-2">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0">
                                                <i class="fas fa-filter text-primary"></i>
                                            </span>
                                            <select class="form-select border-0 shadow-sm" name="status"
                                                id="statusFilter" onchange="filterData()">
                                                <option value="">All Status</option>
                                                <option value="Menunggu Konfirmasi" <?= isset($_GET['status']) && $_GET['status'] == 'Menunggu Konfirmasi' ? 'selected' : ''; ?>>
                                                    Menunggu Konfirmasi
                                                </option>
                                                <option value="Dipinjam" <?= isset($_GET['status']) && $_GET['status'] == 'Dipinjam' ? 'selected' : ''; ?>>
                                                    Dipinjam
                                                </option>
                                                <option value="Dikembalikan" <?= isset($_GET['status']) && $_GET['status'] == 'Dikembalikan' ? 'selected' : ''; ?>>
                                                    Dikembalikan
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Month Filter -->
                                    <div class="col-12 col-md-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0">
                                                <i class="fas fa-calendar text-primary"></i>
                                            </span>
                                            <select class="form-select border-0 shadow-sm" name="month" id="monthFilter"
                                                onchange="filterData()">
                                                <option value="">All Months</option>
                                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                                    <option value="<?= $m ?>" <?= isset($_GET['month']) && $_GET['month'] == $m ? 'selected' : ''; ?>>
                                                        <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                                    </option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div id="bookGrid" class="book-grid">
                                <?php
                                $statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
                                $search = isset($_GET['search']) ? $_GET['search'] : '';
                                $monthFilter = isset($_GET['month']) ? $_GET['month'] : '';

                                $conditions = [];
                                $params = [];

                                if ($search) {
                                    $conditions[] = "(id_buku LIKE ? OR judul LIKE ? OR pengarang LIKE ? OR penerbit LIKE ? OR username LIKE ?)";
                                    $searchParam = "%$search%";
                                    $params = array_merge($params, [$searchParam, $searchParam, $searchParam, $searchParam, $searchParam]);
                                }

                                if ($statusFilter) {
                                    $conditions[] = "status = ?";
                                    $params[] = $statusFilter;
                                }

                                if ($monthFilter) {
                                    $conditions[] = "MONTH(tanggal_pinjam) = ?";
                                    $params[] = $monthFilter;
                                }

                                $query = "SELECT * FROM pinjam";
                                if (!empty($conditions)) {
                                    $query .= " WHERE " . implode(" AND ", $conditions);
                                }
                                $query .= " ORDER BY FIELD(status, 'Menunggu Konfirmasi') DESC, FIELD(status, 'Dikembalikan') ASC";

                                $stmt = mysqli_prepare($conn, $query);
                                if (!empty($params)) {
                                    $types = str_repeat('s', count($params));
                                    mysqli_stmt_bind_param($stmt, $types, ...$params);
                                }

                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);
                                $pinjam = mysqli_fetch_all($result, MYSQLI_ASSOC);

                                if (empty($pinjam)): ?>
                                    <div class="col-12 text-center p-4">
                                        <h5>Buku Pinjam Kosong</h5>
                                    </div>
                                <?php else:
                                    foreach ($pinjam as $pj):
                                        // jika tanggal_kembali sudah lewat 3 hari maka status akan berubah otomatis menjadi Dikembalikan
                                        if (strtotime($pj['tanggal_kembali']) < time() - 3 * 24 * 60 * 60 && $pj['status'] != 'Dikembalikan') {
                                            $query = "UPDATE pinjam SET status = 'Dikembalikan' WHERE id_pinjam = " . $pj['id_pinjam'];
                                            mysqli_query($conn, $query);

                                            // kirim pesan pengembalian otomatis ini ke email user
                                            $email_user = query("SELECT Email FROM pinjam WHERE id_pinjam = " . $pj['id_pinjam'] . " LIMIT 1");
                                            if (isset($email_user[0]['Email'])) {
                                                $mail = new PHPMailer(true);

                                                try {
                                                    //Server settings
                                                    $mail->isSMTP();
                                                    $mail->Host = 'smtp.gmail.com';
                                                    $mail->SMTPAuth = true;
                                                    $mail->Username = 'libratech21@gmail.com';
                                                    $mail->Password = 'wwxhbkuejyygwrvl';
                                                    $mail->SMTPSecure = 'tls';
                                                    $mail->Port = 587;

                                                    // pengirim
                                                    $mail->setFrom('no-reply@librarytech.com', 'LibraTech');

                                                    // penerima
                                                    $mail->addAddress($email_user[0]['Email']);

                                                    // Content
                                                    $mail->isHTML(true);
                                                    $mail->Subject = 'Pengembalian Buku Otomatis - ' . $pj['judul'];
                                                    $mail->Body = '<p>Yth. ' . $pj['username'] . ',</p>
                                                    <p>Kami sampaikan bahwa buku yang Anda pinjam dengan judul "<b>' . $pj['judul'] . '</b>" dan ID Buku "<b>' . $pj['id_buku'] . '</b>" telah dikembalikan secara otomatis oleh sistem karena telah terlambat dikembalikan selama 3 hari.</p>
                                                    <p>Tanggal peminjaman Buku         :' . date('d F Y', strtotime($pj['tanggal_pinjam'])) . '</p>
                                                    <p>Tanggal pengembalian seharusnya : ' . date('d F Y', strtotime($pj['tanggal_kembali'])) . '</p>
                                                    <p>Mohon diperhatikan untuk pengembalian buku tepat waktu di masa mendatang</p>
                                                    <p>Terima kasih atas perhatian dan kerja sama Anda.</p>
                                                    <p>Salam hormat,</p>
                                                    <p><strong>Tim LibraTech</strong></p>';

                                                    $mail->send();
                                                } catch (Exception $e) {
                                                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                                }
                                            }

                                            echo '<meta http-equiv="refresh" content="0;url=pinjam.php" />';
                                        }
                                        ?>
                                        <div class="card h-100 shadow-md border-0 rounded-lg" data-id="<?= $pj['id_pinjam'] ?>">
                                            <!-- Card loading overlay -->
                                            <div class="card-loading">
                                                <div class="card-spinner"></div>
                                            </div>

                                            <div class="card-img-container position-relative">
                                                <i class="fas fa-book card-img-placeholder text-muted"></i>
                                                <img class="card-img-top rounded-top"
                                                    src="<?= htmlspecialchars($pj['cover']); ?>"
                                                    alt="<?= htmlspecialchars($pj['judul']); ?>" loading="lazy"
                                                    style="width: 100%; height: 100%; object-fit: cover;"
                                                    onerror="this.style.display='none'; this.parentElement.querySelector('.card-img-placeholder').style.display='block';"
                                                    onload="this.classList.add('loaded'); this.parentElement.querySelector('.card-img-placeholder').style.display='none';">
                                                <?php if ($pj['status'] == 'Dipinjam' && strtotime($pj['tanggal_kembali']) < time()): ?>
                                                    <span class="badge bg-danger position-absolute top-0 end-0 m-2 fs-4"
                                                        style="opacity: 0.9;">Terlambat</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-body bg-light rounded-bottom">
                                                <h5 class="card-title text-primary fw-bold">
                                                    <?= htmlspecialchars($pj['judul']); ?>
                                                    <span class="text-muted">[<?= htmlspecialchars($pj['id_buku']); ?>]</span>
                                                </h5>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item d-flex justify-content-start align-items-center">
                                                        <i class="fas fa-user me-2"></i>
                                                        <span
                                                            class="text-secondary"><?= htmlspecialchars($pj['pengarang']); ?></span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-start align-items-center">
                                                        <i class="fas fa-building me-2"></i>
                                                        <span class="text-secondary">Penerbit:
                                                            <?= htmlspecialchars($pj['penerbit']); ?></span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-start align-items-center">
                                                        <i class="fas fa-user-circle me-2"></i>
                                                        <span class="fw-bold text-secondary">Peminjam:
                                                            <?= htmlspecialchars($pj['username']); ?>
                                                            [<?= htmlspecialchars($pj['id_user']); ?>]</span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-start align-items-center">
                                                        <i class="fas fa-calendar-alt me-2"></i>
                                                        <span class="text-secondary">Tanggal Pinjam:
                                                            <?= $pj['tanggal_pinjam']; ?></span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-start align-items-center">
                                                        <i class="fas fa-calendar-check me-2"></i>
                                                        <span class="text-secondary">Tanggal Kembali:
                                                            <?= $pj['tanggal_kembali']; ?></span>
                                                    </li>
                                                    <li class="list-group-item d-flex justify-content-start align-items-center">
                                                        <span
                                                            class="badge <?= $pj['status'] == 'Menunggu Konfirmasi' ? 'bg-warning text-dark' :
                                                                ($pj['status'] == 'Dipinjam' ? 'bg-success' : 'bg-secondary'); ?>">
                                                            <?= $pj['status']; ?>
                                                        </span>
                                                    </li>
                                                </ul>
                                                <hr class="my-2">
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <button class="btn btn-primary btn-sm px-4 rounded-pill"
                                                        onclick="showConfirmModal('<?= $pj['id_pinjam'] ?>', '<?= htmlspecialchars($pj['judul']) ?>', '<?= htmlspecialchars($pj['id_buku']) ?>', '<?= htmlspecialchars($pj['username']) ?>', '<?= htmlspecialchars($pj['id_user']) ?>')"
                                                        <?= $pj['status'] == 'Dipinjam' || $pj['status'] == 'Dikembalikan' ? 'disabled' : ''; ?>>
                                                        Confirm
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Kamu yakin ingin mengonfirmasi peminjaman buku ini?</p>
                    <ul id="confirmDetails"></ul>
                </div>
                <div class="modal-footer">
                    <form method="POST" id="confirmForm">
                        <input type="hidden" name="id_pinjam" id="confirmIdPinjam">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary" name="confirmPinjam">Confirm</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Load scripts at the end -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="../js/scripts.js" defer></script>

    <script>
        // Debounce function
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        // Show loading state for specific card
        function toggleCardLoading(cardElement, show) {
            if (show) {
                cardElement.classList.add('loading');
            } else {
                cardElement.classList.remove('loading');
            }
        }

        // Handle image loading
        function handleImageLoad(img) {
            img.classList.add('loaded');
            const placeholder = img.parentElement.querySelector('.card-img-placeholder');
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        }

        // Handle image error
        function handleImageError(img) {
            img.style.display = 'none';
            const placeholder = img.parentElement.querySelector('.card-img-placeholder');
            if (placeholder) {
                placeholder.style.display = 'block';
            }
        }

        // Filter data with card-specific loading
        async function filterData() {
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => toggleCardLoading(card, true));

            try {
                const searchQuery = document.getElementById('searchInput').value;
                const statusFilter = document.getElementById('statusFilter').value;
                const monthFilter = document.getElementById('monthFilter').value;

                const response = await fetch(
                    `?search=${encodeURIComponent(searchQuery)}&status=${encodeURIComponent(statusFilter)}&month=${encodeURIComponent(monthFilter)}`
                );

                if (!response.ok) throw new Error('Network response was not ok');

                const text = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(text, 'text/html');
                const newContent = doc.querySelector('#bookGrid');

                if (newContent) {
                    document.getElementById('bookGrid').innerHTML = newContent.innerHTML;
                    initializeImages();
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat memfilter data. Silakan coba lagi.');
            } finally {
                const updatedCards = document.querySelectorAll('.card');
                updatedCards.forEach(card => toggleCardLoading(card, false));
            }
        }

        // Initialize images
        function initializeImages() {
            document.querySelectorAll('.card-img-top').forEach(img => {
                // Remove existing event listeners
                img.removeEventListener('load', () => handleImageLoad(img));
                img.removeEventListener('error', () => handleImageError(img));

                // Add new event listeners
                img.addEventListener('load', () => handleImageLoad(img));
                img.addEventListener('error', () => handleImageError(img));

                // Reset image state
                img.classList.remove('loaded');
                img.style.display = 'block';

                // Show placeholder initially
                const placeholder = img.parentElement.querySelector('.card-img-placeholder');
                if (placeholder) {
                    placeholder.style.display = 'block';
                }

                // Force reload image if cached
                if (img.complete) {
                    if (img.naturalHeight === 0) {
                        handleImageError(img);
                    } else {
                        handleImageLoad(img);
                    }
                }
            });
        }

        // Show confirmation modal
        function showConfirmModal(id, judul, idBuku, username, idUser) {
            document.getElementById('confirmIdPinjam').value = id;
            document.getElementById('confirmDetails').innerHTML = `
            <li>Judul: ${judul} [${idBuku}]</li>
            <li>User: ${username} [${idUser}]</li>
        `;
            new bootstrap.Modal(document.getElementById('confirmModal')).show();
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function () {
            initializeImages();

            // Add debounce to search input
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', debounce(filterData, 300));
            }
        });
    </script>
</body>

</html>