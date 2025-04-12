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
    <meta name="description" content="LibraTech - Sistem Perpustakaan Digital Modern" />
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
    <link rel="stylesheet" href="../css/selfstyle.css">

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

    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Load Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <!-- Initialize dropdowns -->
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

        // Jalankan saat window loaded
        window.addEventListener('load', function () {
            initializeDropdowns();
        });

        // Jalankan setiap 1 detik untuk memastikan dropdown tetap berfungsi
        setInterval(function () {
            initializeDropdowns();
        }, 1000);
    </script>

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

        .card {
            transition: all 0.3s;
        }

        .card:hover {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        /* Card View Styles */
        .card-view .book-item {
            width: calc(25% - 1rem);
            transition: all 0.7s ease;
        }

        .card-view .book-cover {
            height: 500px;
        }

        .card-view .rating-container {
            position: relative;
            text-align: center;
        }

        /* List View Styles */
        .list-view {
            flex-direction: column !important;
        }

        .list-view .book-item {
            width: 100% !important;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            margin-bottom: 1rem;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.7s ease;
        }

        .list-view .book-item:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .list-view .card {
            flex-direction: row !important;
            padding: 10px;
        }

        .list-view .book-cover {
            width: 200px !important;
            height: 300px !important;
            border-radius: 5px;
        }

        .list-view .card-body {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding-left: 20px;
            padding-right: 20px;
        }

        .list-view .card-footer {
            background: none;
            border-top: none;
            padding-top: 10px;
        }

        @media (max-width: 768px) {
            .card-view .book-item {
                width: calc(50% - 1rem);
            }
        }

        @media (max-width: 576px) {
            .card-view .book-item {
                width: 100%;
            }

            .list-view .card {
                flex-direction: column !important;
            }

            .list-view .book-cover {
                width: 100% !important;
                height: 300px !important;
            }
        }

        .list-view .rating-container {
            position: absolute;
            right: 20px;
            top: 20px;
            background: none;
            border: none;
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
    <br><br>
    <section class="hero-section" style="max-height: 500px;">
        <div class="container-fluid px-0">
            <div id="carouselExampleCaptions" class="carousel slide shadow-lg rounded-5" data-bs-ride="carousel"
                data-bs-interval="10000">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../assets/img/Libr.jpeg" class="d-block w-100 rounded-5" alt="Library Background"
                            style="height: 600px; object-fit: cover; box-shadow: 0 0 10px rgba(0,0,0,0.5);" width="1920"
                            height="600" loading="eager">
                        <div
                            class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                            <img src="../assets/img/logo1.png" class="img-fluid"
                                style="height: 160px; position: absolute; top: 60px;" alt="LibraryTech Logo" width="160"
                                height="160" loading="eager">
                            <h1 style="color: #fff; text-align: center; animation: fadeIn 2s;">Welcome to LibraTech</h1>
                            <p class="d-none d-md-block"
                                style="color: lightgray; position: absolute; bottom: 30px; animation: slideUp 3.8s;">
                                <b>LibraTech</b> adalah perpustakaan digital modern yang menyediakan
                                akses mudah ke berbagai koleksi buku, jurnal, dan sumber pembelajaran digital. Dengan
                                sistem peminjaman dan pengembalian yang efisien, kami berkomitmen untuk memudahkan
                                pengguna dalam mengakses sumber daya perpustakaan kapan saja dan di mana saja.
                            </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="../assets/img/ils2.jpg" class="d-block w-100 rounded-5" alt="..."
                            style="height: 600px; object-fit: cover;">
                        <div
                            class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                            <h1 style="color: #333; text-align: center; animation: fadeIn 2s;">Explore Our Collection
                            </h1>
                            <p class="d-none d-md-block"
                                style="color: black; position: absolute; bottom: 30px; animation: slideUp 3.8s;">
                                <b>LibraTech</b> menyediakan berbagai koleksi buku, jurnal, dan sumber pembelajaran
                            </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="../assets/img/albert.png" class="d-block w-100 rounded-5" alt="..."
                            style="height: 600px; object-fit: cover;">
                        <div class="carousel-caption d-flex justify-content-start align-items-center h-100">
                            <h4 style="text-align: left; font-family: 'Pacifico', cursive; color: white; animation: typeWriter 1s;"
                                id="typewriter">
                            </h4>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev" style="filter: invert(100%);">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next" style="filter: invert(100%);">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
    <br><br><br><br><br><br><br>
    <!-- Top 10 Books -->
    <?php
    $query = "SELECT buku.id_buku, buku.judul, buku.cover, AVG(review.rating) AS avg_rating FROM buku LEFT JOIN review ON buku.id_buku = review.id_buku GROUP BY buku.id_buku ORDER BY avg_rating DESC LIMIT 20";
    $result = query($query);
    ?>
    <div style="margin-left: 40px; margin-top: 70px;">
        <h3 class="position-relative d-inline-block" style="font-family: 'Lato', sans-serif; 
                   font-weight: 900;
                   letter-spacing: 3px;
                   color: #2c3e50;
                   padding: 15px 30px;
                   border-radius: 10px;
                   background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
                   box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            <span class="position-relative" style="background: linear-gradient(45deg, #4a90e2, #6f42c1);
                         -webkit-background-clip: text;
                         -webkit-text-fill-color: transparent;">
                TOP 20 BOOKS
            </span>

            <div class="position-absolute" style="bottom: -5px;
                        left: 50%;
                        transform: translateX(-50%);
                        width: 50px;
                        height: 3px;
                        background: linear-gradient(90deg, #4a90e2, #6f42c1);
                        border-radius: 3px;">
            </div>
        </h3>
    </div>
    <div class="shadow-lg rounded-5 p-4 " style="background: linear-gradient(to right, #e9ecef, #dee2e6);
               margin: 38px;">
        <div class="card-body">
            <!-- Custom scrollbar styling -->
            <div class="d-flex overflow-auto custom-scrollbar" style="scroll-snap-type: x mandatory; 
                       gap: 20px; 
                       padding: 10px;
                       scrollbar-width: thin;
                       -ms-overflow-style: none;">
                <?php foreach ($result as $book): ?>
                    <?php
                    $id_buku = $book['id_buku'];
                    $judul = $book['judul'];
                    $cover = $book['cover'];
                    $avg_rating = $book['avg_rating'] ?? 0;
                    ?>
                    <div class="card border-0 rounded-4 book-card" style="min-width: 200px; 
                               max-width: 250px; 
                               scroll-snap-align: start; 
                               cursor: pointer; 
                               background: white;
                               transition: all 0.3s ease;"
                        onclick="window.location.href='detail_buku.php?id_buku=<?= $id_buku; ?>'">

                        <img src="<?= $cover; ?>" class="card-img-top rounded-4" alt="Book Cover" style="object-fit: cover; 
                                    height: 280px;
                                    filter: brightness(0.95);">

                        <div class="card-body text-center py-3">
                            <h6 class="card-title text-truncate mb-2" style="font-weight: 600;
                                       color: #2d3436;">
                                <?= htmlspecialchars($judul); ?>
                            </h6>
                            <div class="rating" style="font-size: 0.9rem;">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="<?= $i <= $avg_rating ? 'fas' : 'far'; ?> fa-star" style="color: #ffd700;"></i>
                                <?php endfor; ?>
                                <span class="ms-2" style="color: #636e72;
                                             font-size: 0.8rem;">
                                    (<?= number_format($avg_rating, 1) ?>)
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <style>
        /* Custom scrollbar styling */
        .custom-scrollbar::-webkit-scrollbar {
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Card hover effect */
        .book-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
    <!-- End Top 10 Books -->
    <br>
    <hr style="border: 1px solid #666; margin: 40px 0; box-shadow: 0 0 10px rgba(0,0,0,0.2);">

    <section class="features" style="max-width: 100vw;">
        <div class="container-fluid">
            <h2 class="text-center mt-3" style="font-family: 'Lato', sans-serif; font-weight: bold; letter-spacing: 1px; color: #4a90e2;">
                EXPLORE OUR BOOKS
            </h2>
            <br><br><br><br>

            <!-- Search, Filter and View Toggle -->
            <form method="GET"
                class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <div class="input-group shadow-sm" style="max-width: 100%; width: 400px;">
                    <span class="input-group-text bg-white border-0" id="basic-addon1">
                        <i class="fas fa-search text-primary"></i>
                    </span>
                    <input class="form-control border-0" type="text" name="search" id="searchInput"
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                        placeholder="Cari buku..." aria-label="Search for..." aria-describedby="btnNavbarSearch"
                        onkeyup="filterData()" />
                </div>

                <div class="d-flex gap-3">
                    <!-- View Toggle Button -->
                    <div class="btn-group shadow-sm" role="group" aria-label="View Toggle" style="gap: 5px;">
                        <button type="button" class="btn btn-outline-primary active" id="cardView" title="Card View">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="listView" title="List View">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>

                    <!-- Category Filter -->
                    <div class="input-group shadow-sm" style="max-width: 100%; width: 200px;">
                        <span class="input-group-text bg-primary text-white border-0">
                            <i class="fas fa-filter"></i>
                        </span>
                        <select class="form-select border-0" name="category" id="categoryFilter"
                            onchange="filterData()">
                            <option value="">Semua Kategori</option>
                            <?php
                            $categories = query("SELECT id_kat, nama_kategori FROM kategori");
                            foreach ($categories as $category) {
                                $selected = isset($_GET['category']) && $_GET['category'] == $category['nama_kategori'] ? 'selected' : '';
                                echo "<option value=\"{$category['nama_kategori']}\" $selected>{$category['nama_kategori']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </form>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.umd.js"></script>

            <!-- Book List Container -->
            <div id="bookContainer" class="d-flex flex-wrap flex-column gap-4 mt-4">
                <?php
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $category = isset($_GET['category']) ? $_GET['category'] : '';

                $query = "SELECT * FROM buku WHERE if_visible = TRUE";
                if ($search) {
                    $query .= " AND (judul LIKE '%$search%' OR pengarang LIKE '%$search%' OR penerbit LIKE '%$search%' OR kategori LIKE '%$search%')";
                }
                if ($category) {
                    $query .= " AND kategori = '$category'";
                }
                $query .= " ORDER BY kategori, tahun_terbit DESC";

                $buku = query($query);
                $currentCategory = '';
                if (count($buku) > 0) {
                    foreach ($buku as $bk):
                        if ($currentCategory != $bk['kategori']) {
                            if ($currentCategory != '') {
                                echo '</div><hr style="border: 2px solid #e2e8f0;" class="my-5"><br>';
                            }
                            $currentCategory = $bk['kategori'];
                            echo "<div class='category-group'><h2 class='text-center fw-bold mb-5' style='background: linear-gradient(45deg, #1a202c, #010035); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-size: 1.5rem; letter-spacing: 2px;'>{$currentCategory}</h2><div class='row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 d-flex flex-wrap'>";
                        }
                        ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-2 mb-4 book-item mt-4">
                            <div class="card h-100 shadow-lg rounded-4 border-0 transition-all hover:transform hover:scale-105"
                                style="transition: all 0.3s ease;">
                                <div class="position-relative" style="height: auto;">
                                    <img class="card-img-top book-cover rounded-top-4" src="<?= $bk['cover']; ?>"
                                        alt="<?= htmlspecialchars($bk['judul']); ?> Cover"
                                        style="width: 100%; height: auto; max-height: none;" loading="lazy"
                                        onerror="this.src='../assets/img/default_book_cover.png';">

                                    <?php
                                    $id_buku = $bk['id_buku'];
                                    $avgRatingQuery = "SELECT AVG(rating) as avg_rating FROM review WHERE id_buku = '$id_buku'";
                                    $avgRatingResult = query($avgRatingQuery);
                                    $avgRating = $avgRatingResult[0]['avg_rating'] ?? 0;
                                    ?>
                                    <div class="position-absolute top-0 end-0 m-2 p-2 bg-white bg-opacity-75 rounded-pill">
                                        <div class="d-flex align-items-center gap-1">
                                            <i class="fas fa-star text-warning"></i>
                                            <span class="fw-bold"><?= number_format($avgRating, 1) ?></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title text-truncate fw-bold mb-2"><?= $bk['judul']; ?></h5>
                                    <p class="card-text text-muted mb-2"><?= $bk['pengarang']; ?></p>
                                    <div class="d-flex flex-column gap-2">
                                        <!-- Deskripsi buku untuk tampilan list -->
                                        <div class="book-description mt-3 d-none">
                                            <h6 class="fw-bold">Deskripsi:</h6>
                                            <p class="text-muted small">
                                                <?php
                                                $deskripsi = isset($bk['deskripsi']) ? $bk['deskripsi'] : 'Tidak ada deskripsi tersedia.';
                                                echo strlen($deskripsi) > 250 ? substr($deskripsi, 0, 250) . '...' : $deskripsi;
                                                ?>
                                            </p>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-primary rounded-pill">Penerbit</span>
                                            <small class="text-muted"><?= $bk['penerbit']; ?></small>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-primary rounded-pill">Tahun</span>
                                            <small class="text-muted"><?= $bk['tahun_terbit']; ?></small>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="badge bg-primary rounded-pill">Halaman</span>
                                            <small class="text-muted"><?= $bk['halaman']; ?></small>
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer bg-transparent border-0 p-3">
                                    <a href="detail_buku.php?id_buku=<?= $bk['id_buku']; ?>"
                                        class="btn btn-outline-primary w-100 rounded-pill">
                                        <i class="fas fa-info-circle me-2"></i>Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                    echo '</div>';
                } else {
                    ?>
                    <div class="col-12">
                        <div class="alert alert-info rounded-4 shadow-sm border-0">
                            <i class="fas fa-info-circle me-2"></i>Tidak ada buku yang ditemukan.
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>

            <script>
                document.getElementById('cardView').addEventListener('click', function () {
                    document.getElementById('bookContainer').classList.remove('list-view');
                    document.getElementById('cardView').classList.add('active');
                    document.getElementById('listView').classList.remove('active');

                    // Sembunyikan deskripsi buku saat dalam mode card
                    document.querySelectorAll('.book-description').forEach(function (desc) {
                        desc.classList.add('d-none');
                    });
                });

                document.getElementById('listView').addEventListener('click', function () {
                    document.getElementById('bookContainer').classList.add('list-view');
                    document.getElementById('listView').classList.add('active');
                    document.getElementById('cardView').classList.remove('active');

                    // Tampilkan deskripsi buku saat dalam mode list
                    document.querySelectorAll('.book-description').forEach(function (desc) {
                        desc.classList.remove('d-none');
                    });
                });
            </script>
    </section>


    <!-- Footer -->

    <footer class="footer mt-3"
        style="background: linear-gradient(129deg, #1a202c 0%, #010035 100%); font-size: 0.8rem;">
        <div class="container py-3">
            <div class="row g-4 justify-content-center">
                <!-- Logo and Description -->
                <div class="col-md-4 text-center">
                    <div class="mb-4 d-flex align-items-center ms-5">
                        <img src="../assets/img/logo1.png" alt="LibraryTech Logo" style="height: 60px;">
                        <span class="ms-2 text-white fs-4">LibraTech</span>
                    </div>
                    <p class="text-light opacity-75" style="text-align: left;">
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
                                class="text-light text-decoration-none <?php echo basename($_SERVER['PHP_SELF']) == 'peminjaman.php' ? 'opacity-100' : 'opacity-75'; ?>"
                                style="transition: all 0.3s;" onmouseover="this.style.color='#ffd700'"
                                onmouseout="this.style.color='#fff'">Peminjaman</a>
                        </li>

                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-white mb-3 fw-bold">Contact</h6>
                    <div class="text-light opacity-75">
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
            <small class="text-white" style="font-size: 0.8rem;">© 2025 LibraryTech | Shiddiq | All rights
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
            const category = document.getElementById('categoryFilter').value;
            fetch(`dashboard.php?search=${encodeURIComponent(searchQuery)}&category=${encodeURIComponent(category)}`)
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const newContent = doc.querySelector('#bookContainer').innerHTML;
                    document.querySelector('#bookContainer').innerHTML = newContent;
                });
        }
    </script>

    <!--  typewriter -->
    <script>
        const text = `"Satu-satunya hal yang benar-benar harus kamu ketahui adalah lokasi PERPUSTAKAAN."`;
        const author = "Albert Einstein";
        let i = 0;
        const typewriter = () => {
            if (i < text.length) {
                document.getElementById('typewriter').innerHTML += text.charAt(i);
                i++;
                setTimeout(typewriter, 50);
            } else if (i === text.length) {
                document.getElementById('typewriter').innerHTML += `<br><em style="font-size: 1rem">${author}</em>`;
                setTimeout(() => {
                    document.getElementById('typewriter').innerHTML = '';
                    i = 0;
                    typewriter();
                }, 10000);
            }
        }
        typewriter();
    </script>

    <!-- Script untuk mengatur efek hover pada card -->
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
</body>



</html>