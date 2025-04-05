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
        /* Critical inline styles */
        .card {
            transition: all 0.3s;
            height: 100%;
        }

        .card:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        .card-img-top {
            object-fit: cover;
            width: 100%;
            height: 250px;
            aspect-ratio: 3/4;
        }

        .search-filter {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .search-group {
            width: 400px;
        }

        .filter-group {
            display: flex;
            gap: 1rem;
        }

        .book-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 1rem;
        }

        .rating-stars {
            color: #ffc107;
        }

        .book-details {
            padding: 1rem;
        }

        .badge {
            margin-right: 0.5rem;
        }

        /* Loading placeholder animation */
        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .loading-placeholder {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
            border-radius: 4px;
        }
    </style>
</head>

<body class="sb-nav-fixed">
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
                                href="#">
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
                            <div><i class="fas fa-table me-1"></i> Buku</div>
                        </div>
                        <div class="card-body">
                            <!-- Search and Filter -->
                            <div class="search-filter">
                                <div class="search-group">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Cari buku..."
                                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                                        onkeyup="debounce(filterData, 300)()">
                                </div>
                                <div class="filter-group">
                                    <a href="export_table/export_buku.php" class="btn btn-outline-primary">
                                        <i class="fas fa-file-export me-2"></i>Export Table
                                    </a>
                                    <select class="form-select" id="categoryFilter" onchange="filterData()"
                                        style="width: 200px;">
                                        <option value="">Semua Kategori</option>
                                        <?php
                                        $categories = query("SELECT DISTINCT nama_kategori FROM kategori");
                                        foreach ($categories as $category) {
                                            $selected = isset($_GET['category']) && $_GET['category'] == $category['nama_kategori'] ? 'selected' : '';
                                            echo "<option value=\"" . htmlspecialchars($category['nama_kategori']) . "\" $selected>" .
                                                htmlspecialchars($category['nama_kategori']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Book Grid -->
                            <div class="book-grid" id="bookContainer">
                                <!-- Add Book Card -->
                                <div class="card h-100 d-flex justify-content-center align-items-center add-book-card"
                                    style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#tambahBuku">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Tambah Buku</h5>
                                        <div class="add-icon"><i class="fas fa-plus-circle"></i></div>
                                    </div>
                                </div>

                                <?php
                                $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
                                $category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';

                                // Pagination setup
                                $limit = 15; // Jumlah buku per halaman
                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                $start = ($page - 1) * $limit;

                                // Query untuk menghitung total buku
                                $countQuery = "SELECT COUNT(*) as total FROM buku b WHERE b.if_visible = TRUE";
                                if ($search) {
                                    $countQuery .= " AND (b.judul LIKE '%$search%' OR b.pengarang LIKE '%$search%' 
                                              OR b.penerbit LIKE '%$search%' OR b.kategori LIKE '%$search%')";
                                }
                                if ($category) {
                                    $countQuery .= " AND b.kategori = '$category'";
                                }
                                
                                $totalResult = query($countQuery);
                                $total = $totalResult[0]['total'];
                                $pages = ceil($total / $limit);

                                // Query untuk mengambil data buku dengan pagination
                                $query = "SELECT b.*, COALESCE(AVG(r.rating), 0) as avg_rating 
                                        FROM buku b 
                                        LEFT JOIN review r ON b.id_buku = r.id_buku 
                                        WHERE b.if_visible = TRUE";
                                if ($search) {
                                    $query .= " AND (b.judul LIKE '%$search%' OR b.pengarang LIKE '%$search%' 
                                              OR b.penerbit LIKE '%$search%' OR b.kategori LIKE '%$search%')";
                                }
                                if ($category) {
                                    $query .= " AND b.kategori = '$category'";
                                }
                                $query .= " GROUP BY b.id_buku ORDER BY b.tahun_terbit DESC LIMIT $start, $limit";

                                $buku = query($query);
                                foreach ($buku as $bk):
                                    $avgRating = number_format($bk['avg_rating'], 1);
                                    ?>
                                    <div class="card book-card">
                                        <div class="book-cover-container">
                                            <div class="card-img-placeholder">
                                                <i class="fas fa-book fa-3x"></i>
                                            </div>
                                            <img src="<?= htmlspecialchars($bk['cover']); ?>" class="card-img-top"
                                                alt="<?= htmlspecialchars($bk['judul']); ?>" loading="lazy">
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex justify-content-center rating-stars">
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    echo $i <= $avgRating
                                                        ? '<i class="fas fa-star"></i>'
                                                        : '<i class="far fa-star"></i>';
                                                }
                                                ?>
                                                <small class="text-muted">(<?= $avgRating ?>)</small>
                                            </div>
                                            <h5 class="card-title text-truncate"><?= htmlspecialchars($bk['judul']); ?></h5>
                                            <p class="card-author text-truncate"><?= htmlspecialchars($bk['pengarang']); ?></p>
                                        </div>
                                        <div class="book-details">
                                            <h5 class="card-title"><?= htmlspecialchars($bk['judul']); ?></h5>
                                            <p class="card-text"><?= htmlspecialchars($bk['pengarang']); ?></p>
                                            <div class="book-info mt-4">
                                                <p>
                                                    <span class="badge bg-secondary">ID Buku:</span>
                                                    <?= htmlspecialchars($bk['id_buku']); ?>
                                                </p>
                                                <p>
                                                    <span class="badge bg-secondary">Penerbit:</span>
                                                    <?= htmlspecialchars($bk['penerbit']); ?>
                                                </p>
                                                <p>
                                                    <span class="badge bg-secondary">Tahun:</span>
                                                    <?= htmlspecialchars($bk['tahun_terbit']); ?>
                                                </p>
                                                <p>
                                                    <span class="badge bg-secondary">Halaman:</span>
                                                    <?= htmlspecialchars($bk['halaman']); ?>
                                                </p>
                                                <p>
                                                    <span class="badge bg-secondary">Kategori:</span>
                                                    <?= htmlspecialchars($bk['kategori']); ?>
                                                </p>
                                            </div>
                                            <a href="detail_buku.php?id_buku=<?= htmlspecialchars($bk['id_buku']); ?>"
                                                class="btn btn-outline-primary w-100">Lihat Detail</a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Pagination -->
                            <div class="pagination-container mt-4 d-flex justify-content-center">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>" aria-label="Previous">
                                                    <span aria-hidden="true">&laquo;</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        
                                        <?php for ($i = 1; $i <= $pages; $i++): ?>
                                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                                <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>" style="color:rgb(0, 0, 0);">
                                                    <?= $i ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>
                                        
                                        <?php if ($page < $pages): ?>
                                            <li class="page-item">
                                                <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>&category=<?= urlencode($category) ?>" aria-label="Next">
                                                    <span aria-hidden="true">&raquo;</span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>

                            <style>
                                .book-grid {
                                    display: grid;
                                    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                                    gap: 20px;
                                    margin-top: 20px;
                                }
                                
                                .book-card {
                                    border-radius: 10px;
                                    overflow: hidden;
                                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                                    transition: transform 0.3s ease, box-shadow 0.3s ease;
                                    height: 100%;
                                    position: relative;
                                }
                                
                                .book-card:hover {
                                    transform: translateY(-5px);
                                    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
                                }
                                
                                .book-cover-container {
                                    height: 280px;
                                    overflow: hidden;
                                    position: relative;
                                    background-color: #f8f9fa;
                                }
                                
                                .card-img-top {
                                    width: 100%;
                                    height: 100%;
                                    object-fit: cover;
                                    object-position: center;
                                    transition: opacity 0.3s ease;
                                }
                                
                                .card-img-placeholder {
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    height: 100%;
                                    width: 100%;
                                    background-color: #f0f0f0;
                                    color: #aaa;
                                    position: absolute;
                                    top: 0;
                                    left: 0;
                                }
                                
                                .card-footer {
                                    padding: 12px;
                                    background-color: white;
                                    border-top: none;
                                }
                                
                                .rating-stars {
                                    margin-bottom: 8px;
                                    color: #ffc107;
                                }
                                
                                .card-title {
                                    font-size: 16px;
                                    font-weight: 600;
                                    margin-bottom: 5px;
                                }
                                
                                .card-author {
                                    font-size: 14px;
                                    color: #6c757d;
                                    margin-bottom: 0;
                                }
                                
                                .book-details {
                                    position: absolute;
                                    top: 0;
                                    left: 0;
                                    width: 100%;
                                    height: 100%;
                                    background-color: rgba(255, 255, 255, 0.95);
                                    padding: 15px;
                                    opacity: 0;
                                    transition: opacity 0.3s ease;
                                    display: flex;
                                    flex-direction: column;
                                    overflow-y: auto;
                                }
                                
                                .book-card:hover .book-details {
                                    opacity: 1;
                                }
                                
                                .book-info {
                                    flex-grow: 1;
                                    margin-bottom: 15px;
                                }
                                
                                .book-info p {
                                    margin-bottom: 8px;
                                    font-size: 14px;
                                }
                                
                                .add-book-card {
                                    border: 2px dashed #dee2e6;
                                    background-color: #f8f9fa;
                                    transition: all 0.3s ease;
                                }
                                
                                .add-book-card:hover {
                                    border-color: #007bff;
                                    background-color: #e9f5ff;
                                }
                                
                                .add-icon {
                                    font-size: 48px;
                                    color: #007bff;
                                }
                                
                                .pagination {
                                    margin-top: 20px;
                                }
                                
                                .pagination .page-link {
                                    color:rgb(0, 0, 0);
                                    border-radius: 4px;
                                    margin: 0 3px;
                                }
                                
                                .pagination .page-item.active .page-link {
                                    background-color:rgb(255, 255, 255);
                                    border-color: #007bff;
                                }
                            </style>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    // Handle image error
                                    const images = document.querySelectorAll('.card-img-top');
                                    images.forEach(img => {
                                        img.onerror = function() {
                                            img.style.display = 'none';
                                            const placeholder = img.parentElement.querySelector('.card-img-placeholder');
                                            if (placeholder) {
                                                placeholder.style.display = 'block';
                                            }
                                        };
                                    });
                                });
                            </script>
                        </div>

                        <style>
                            .card-img-placeholder {
                                display: none;
                                height: 200px;
                                background-color: #f0f0f0;
                            }
                        </style>
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
                        <img src="" id="preview"
                            style="max-width:200px;max-height:200px; display:block; margin: 0 auto; margin-bottom: 1rem;">

                        <div class="mb-3">
                            <label for="judul" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="judul" name="judul" required maxlength="50">
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"></textarea>
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
                                <?php
                                $kategoriQuery = "SELECT DISTINCT nama_kategori FROM kategori";
                                $kategoriResult = mysqli_query($conn, $kategoriQuery);
                                while ($row = mysqli_fetch_assoc($kategoriResult)) {
                                    $selected = $data['nama_kategori'] == $row['nama_kategori'] ? 'selected' : '';
                                    echo "<option value='{$row['nama_kategori']}' $selected>{$row['nama_kategori']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary" name="tambahBuku">Tambah Buku</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Load non-critical scripts at the end -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="../js/scripts.js" defer></script>

    <script>
        // Debounce function untuk mencegah terlalu banyak request
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

        // Lazy loading untuk gambar
        document.addEventListener('DOMContentLoaded', function () {
            const lazyImages = document.querySelectorAll('img.lazy');
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            lazyImages.forEach(img => imageObserver.observe(img));
        });

        // Filter data dengan fetch API
        async function filterData() {
            const searchQuery = document.getElementById('searchInput').value;
            const category = document.getElementById('categoryFilter').value;
            const container = document.getElementById('bookContainer');

            // Tampilkan loading state
            container.innerHTML = '<div class="loading-placeholder" style="height: 300px; width: 100%;"></div>'.repeat(4);

            try {
                const response = await fetch(`?search=${encodeURIComponent(searchQuery)}&category=${encodeURIComponent(category)}`);
                const text = await response.text();
                const parser = new DOMParser();
                const doc = parser.parseFromString(text, 'text/html');
                const newContent = doc.querySelector('.book-grid');

                if (newContent) {
                    container.innerHTML = newContent.innerHTML;
                    // Reinitialize lazy loading
                    const lazyImages = document.querySelectorAll('img.lazy');
                    const imageObserver = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                const img = entry.target;
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                                imageObserver.unobserve(img);
                            }
                        });
                    });
                    lazyImages.forEach(img => imageObserver.observe(img));
                }
            } catch (error) {
                console.error('Error fetching data:', error);
                container.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan saat memuat data</div>';
            }
        }

        // Preview image untuk form tambah buku
        function previewImage() {
            const image = document.querySelector('#cover');
            const preview = document.querySelector('#preview');
            const file = image.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onloadend = () => preview.src = reader.result;
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>
</body>

</html>