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
    <title>Dashboard - LibraTech</title>
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
    <nav class="navbar navbar-expand-lg shadow-lg"
        style="background: linear-gradient(139deg, #0f509e 0%, #ffffff 100%);">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img style="height: 50px;" alt="LibraryTech Logo" src="../assets/img/logo1.png" />
                <b>LibraTech</b>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>"
                            href="dashboard.php"><b>Dashboard</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'peminjaman.php' ? 'active' : ''; ?>"
                            href="peminjaman.php"><b>Peminjaman</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'pengembalian.php' ? 'active' : ''; ?>"
                            href="pengembalian.php"><b>Pengembalian</b></a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false"><i class="fas fa-bars fa-fw"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href=""><b><?php echo $_SESSION['username'] ?></b></a></li>
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider" />
                            </li>
                            <li><a class="dropdown-item" href="../Auth/logout.php"><b>Logout</b></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <br><br>
    <section class="hero-section" style="max-height: 500px;">
        <div class="container-fluid px-0">
            <div id="carouselExampleCaptions" class="carousel slide shadow-lg rounded-5" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../assets/img/Libr.jpeg" class="d-block w-100 rounded-5" alt="..."
                            style="height: 600px; object-fit: cover; box-shadow: 0 0 10px rgba(0,0,0,0.5);">
                        <div
                            class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                            <img src="../assets/img/logo1.png" class="img-fluid"
                                style="height: 160px; position: absolute; top: 60px;" alt="LibraryTech Logo">
                            <h1 style="color: #fff; text-align: center; animation: fadeIn 2s;">Welcome to LibraTech</h1>
                            <p class="d-none d-md-block"
                                style="color: lightgray; position: absolute; bottom: 30px; animation: slideUp 3.8s;">
                                <b>LibraryTech</b> adalah perpustakaan digital modern yang menyediakan
                                akses mudah ke berbagai koleksi buku, jurnal, dan sumber pembelajaran digital. Dengan
                                sistem peminjaman dan pengembalian yang efisien, kami berkomitmen untuk memudahkan
                                pengguna dalam mengakses sumber daya perpustakaan kapan saja dan di mana saja.
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
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <br><br><br><br><br><br>
    <hr style="border: 1px solid #666; margin: 40px 0; box-shadow: 0 0 10px rgba(0,0,0,0.2);">

    <section class="features">
        <div class="container">
            <h2 class="text-center mt-"
                style="font-family: 'Lato', sans-serif; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: #4a4a4a;">
                DAFTAR BUKU</h2>
            <br><br>

            <!-- Search and Filter -->
            <form method="GET" class="mb-4 d-flex justify-content-between">
                <div class="input-group shadow" style="width: 400px;">
                    <input class="form-control" type="text" name="search" id="searchInput"
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                        placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch"
                        onkeyup="filterData()" />
                    <!-- Search input untuk mencari buku berdasarkan judul, pengarang, penerbit, atau kategori -->
                </div>
                <div class="input-group shadow" style="width: 200px;">
                    <span class="input-group-text" id="basic-addon2"><i class="fas fa-filter"></i></span>
                    <select class="form-select" name="category" id="categoryFilter" onchange="filterData()">
                        <option value="">All Categories</option>
                        <?php
                        $categories = query("SELECT DISTINCT kategori FROM buku WHERE if_visible = TRUE");
                        foreach ($categories as $category) {
                            $selected = isset($_GET['category']) && $_GET['category'] == $category['kategori'] ? 'selected' : '';
                            echo "<option value=\"{$category['kategori']}\" $selected>{$category['kategori']}</option>";
                        }
                        ?>
                    </select>
                    <!-- Filter untuk memilih kategori buku -->
                </div>
            </form>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 d-flex flex-wrap">
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
                $query .= " ORDER BY tahun_terbit DESC";

                $buku = query($query);
                if (count($buku) > 0) {
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
                                    <p class="card-text text-small "><?= $bk['pengarang']; ?></p>
                                    <p class="card-text text-start"><span class="badge bg-secondary">Penerbit:</span>
                                        <?= $bk['penerbit']; ?></p>
                                    <p class="card-text text-start"><span class="badge bg-secondary">Tahun Terbit:</span>
                                        <?= $bk['tahun_terbit']; ?></p>
                                    <p class="card-text text-start"><span class="badge bg-secondary">Jumlah Halaman:</span>
                                        <?= $bk['halaman']; ?></p>
                                    <p class="card-text text-start"><span class="badge bg-secondary">Kategori:</span>
                                        <?= $bk['kategori']; ?></p>

                                    <div class="d-flex justify-content-end">
                                        <a href="detail_buku.php?id_buku=<?= $bk['id_buku']; ?>"
                                            class="btn btn-outline-primary">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                } else {
                    ?>
                    <div class="col mb-4">
                        <div class="card h-100 shadow-md">
                            <div class="card-body">
                                <h5 class="card-title">Buku Kosong </h5>
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
        style="background: linear-gradient(129deg, #1a202c 0%, #010035 100%); font-size: 0.8rem;">
        <div class="container py-3">
            <div class="row g-4 justify-content-center">
                <!-- Logo and Description -->
                <div class="col-md-4 text-center">
                    <div class="mb-4 d-flex align-items-center ms-5">
                        <img src="../assets/img/logo1.png" alt="LibraryTech Logo" style="height: 60px;">
                        <span class="ms-2 text-white fs-4">LibraryTech</span>
                    </div>
                    <p class="text-light opacity-75">
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
                        <li class="mb-2 text-center"><a href="peminjaman.php"
                                class="text-light text-decoration-none <?php echo basename($_SERVER['PHP_SELF']) == 'peminjaman.php' ? 'opacity-100' : 'opacity-75'; ?>"
                                style="transition: all 0.3s;" onmouseover="this.style.color='#ffd700'"
                                onmouseout="this.style.color='#fff'">Peminjaman</a>
                        </li>
                        <li class="mb-2 text-center"><a href="pengembalian.php"
                                class="text-light text-decoration-none <?php echo basename($_SERVER['PHP_SELF']) == 'pengembalian.php' ? 'opacity-100' : 'opacity-75'; ?>"
                                style="transition: all 0.3s;" onmouseover="this.style.color='#ffd700'"
                                onmouseout="this.style.color='#fff'">Pengembalian</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-white mb-3 fw-bold text-center">Contact</h6>
                    <div class="text-light opacity-75 text-center">
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
                                style="margin-left: 8px;">Bandung, Indonesia</span></p>

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
            fetch(`?search=${encodeURIComponent(searchQuery)}&category=${encodeURIComponent(category)}`)
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const newContent = doc.querySelector('.row');
                    document.querySelector('.row').innerHTML = newContent.innerHTML;
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
</body>



</html>