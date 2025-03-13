<?php
require "../../func.php";
require "../../Auth/cek_log.php";
?>
<html>

<head>
    <title> Daftar Anggota</title>
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
        <h2 class="mb-4 text-center text-primary">Daftar Anggota</h2>
        <div class="table-responsive shadow-lg p-3 mb-5 bg-white rounded">
            <table class="table table-striped table-hover" id="mauexport" width="100%" cellspacing="0">
                <thead class="table-dark">
                    <tr>
                        <th>No.</th>
                        <th>ID User</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Nomor HP</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $database = mysqli_query($conn, 'select * from user where role="anggota" and if_visible="1"');
                    $i = 1;
                    while ($data = mysqli_fetch_array($database)) {
                        $id_user = $data['id_user'];
                        $email = $data['Email'];
                        $username = $data['username'];
                        $nomorhp = $data['nomorhp'];
                        $role = $data['role'];
                        ?>
                        <tr>
                            <td class="align-middle"><?= $i++ ?></td>
                            <td class="align-middle"><?php echo $id_user ?></td>
                            <td class="align-middle"><?php echo $email ?></td>
                            <td class="align-middle"><?php echo $username ?></td>
                            <td class="align-middle"><?php echo $nomorhp ?></td>
                            <td class="align-middle"><?php echo $role ?></td>
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