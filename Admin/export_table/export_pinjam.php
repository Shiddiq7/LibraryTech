<?php
require "../../func.php";
require "../../Auth/cek_log.php";
?>
<html>

<head>
    <title> Daftar Peminjaman Buku</title>
    <link rel="icon" href="logo/logo.png" type="image/png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
</head>

<body>
    <div class="container mt-5">
        <a href="javascript:history.back()" class="btn btn-outline-secondary mb-2">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <?php
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        switch ($status) {
            case 'Menunggu Konfirmasi':
                $status = 'Menunggu Konfirmasi';
                break;
            case 'Dipinjam':
                $status = 'Dipinjam';
                break;
            case 'Dikembalikan':
                $status = 'Dikembalikan';
                break;
            default:
                $status = '';
                break;
        }
        ?>
        <h2 class="mb-4 text-center text-primary">Daftar Peminjaman Buku <?= $status ?></h2>
        <div class="table-responsive shadow-lg p-3 mb-5 bg-white rounded">
            <table class="table table-striped table-hover" id="mauexport" width="100%" cellspacing="0">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>ID Peminjaman</th>
                        <th>ID Buku</th>
                        <th>Judul Buku</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Username</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $status = isset($_GET['status']) ? $_GET['status'] : '';
                    $query = "SELECT * FROM pinjam";
                    if ($status) {
                        $query .= " WHERE status = '$status'";
                    }
                    $database = mysqli_query($conn, $query);
                    $i = 1;
                    while ($pj = mysqli_fetch_array($database)) {
                        ?>
                        <tr>
                            <td class="align-middle"><?= $i++ ?></td>
                            <td class="align-middle"><?= $pj['id_pinjam'] ?></td>
                            <td class="align-middle"><?= $pj['id_buku'] ?></td>
                            <td class="align-middle"><?= $pj['judul']; ?></td>
                            <td class="align-middle"><?= $pj['pengarang']; ?></td>
                            <td class="align-middle"><?= $pj['penerbit']; ?></td>
                            <td class="align-middle"><?= $pj['username']; ?> [<?= $pj['id_user']; ?>]</td>
                            <td class="align-middle"><?= $pj['tanggal_pinjam']; ?></td>
                            <td class="align-middle"><?= $pj['tanggal_kembali']; ?></td>
                            <td class="align-middle">
                                <span class="badge <?= $pj['status'] == 'Menunggu Konfirmasi' ? 'bg-warning' : ($pj['status'] == 'Dipinjam' ? 'bg-success' : ($pj['status'] == 'Dikembalikan' ? 'bg-secondary' : '')); ?>">Status:</span>
                                <span style="color: <?= $pj['status'] == 'Menunggu Konfirmasi' ? 'orange' : ($pj['status'] == 'Dipinjam' ? 'green' : ($pj['status'] == 'Dikembalikan' ? '' : '')) ?>"> <?= $pj['status']; ?> </span>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        $(document).ready(function () {
            $('#mauexport').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Export',
                        buttons: [
                            'copy',
                            'csv',
                            'excel',
                            'pdf',
                            'print'
                        ],
                    },
                ]
            });
        });
    </script>
</body>

</html>