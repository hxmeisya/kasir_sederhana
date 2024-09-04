<?php
require 'functions.php';
session_start();

    if( !isset($_SESSION["login"]) ) {
        header("Location: login.php");
        exit;
    }

$jumlahDataPerHalaman = 4;
$jumlahData = count(query("SELECT * FROM transaksi"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$halamanAktif = max(1, min($halamanAktif, $jumlahHalaman)); // Pastikan halaman aktif valid

$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

$transaksi = query("SELECT transaksi.id, tanggal, pegawai.nama AS kasir, pelanggan.nama AS pelanggan, total_harga 
    FROM transaksi
    LEFT JOIN pegawai ON transaksi.id_pegawai = pegawai.id
    LEFT JOIN pelanggan ON transaksi.id_pelanggan = pelanggan.id
    LIMIT $awalData, $jumlahDataPerHalaman");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Riwayat | Aplikasi Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .container-fluid {
            margin: 0 auto;
            max-width: 1200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        thead {
            background-color: #f8f9fa;
        }

        tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        /* Style untuk tombol lihat detail */
        button.small-button {
            display: inline-block;
            padding: 3px 6px;
            font-size: 12px;
            background-color: #f8f9fa;
            color: #007bff;
            border: 1px solid #007bff;
            border-radius: 3px;
            text-decoration: none;
            cursor: pointer;
        }

        button.small-button:hover {
            background-color: #007bff;
            color: #ffffff;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            margin: 0 5px;
            padding: 10px;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #007bff;
        }

        .pagination a.active {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">Aplikasi Kasir</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                        <a class="nav-link" href="dashboard.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Barang
                        </a>
                        <a class="nav-link" href="transaksi.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-wallet"></i></div>
                            Transaksi
                        </a>
                        <a class="nav-link" href="riwayat.php">
                            <div class="sb-nav-link-icon"><i class="fa fa-history"></i></div>
                            Riwayat
                        </a>
                    </div>
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Pengaturan</div>
                            <a class="nav-link" href="pengaturan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                                Pengaturan
                            </a>
                            <a class="nav-link" href="pembayaran.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-money-bill-alt"></i></div>
                                Pembayaran
                            </a>
                            <a class="nav-link" href="akun.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-alt"></i></div>
                                Akun
                            </a>
                            <a class="nav-link" href="logout.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-sign-out"></i></div>
                                Keluar
                            </a>
                        </div>
                    </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Riwayat</h1>
                    <ol class="breadcrumb mb-4"></ol>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i> Daftar Riwayat Transaksi
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Kasir</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Total Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = $awalData + 1; ?>
                                    <?php foreach ($transaksi as $row) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= htmlspecialchars($row['tanggal']) ?></td>
                                            <td><?= htmlspecialchars($row['kasir']) ?></td>
                                            <td><?= !empty($row['pelanggan']) ? htmlspecialchars($row['pelanggan']) : 'pelanggan belum terdaftar' ?></td>
                                            <td><?php echo 'Rp ' . number_format($row['total_harga'], 0, ',', '.'); ?></td>
                                            <td>
                                                <button class="small-button" onclick="tampilkanDetailTransaksi(<?= $row['id'] ?>)">Lihat Detail</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="pagination">
                        <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                            <a href="?halaman=<?= $i ?>" class="<?= ($i == $halamanAktif) ? 'active' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>
                    </div>
                    <div id="detailModal" style="display:none;">
                        <div>
                            <h2>Detail Transaksi</h2>
                            <p><strong>Tanggal:</strong> <span id="detailTanggal"></span></p>
                            <p><strong>Nama Pegawai:</strong> <span id="detailPegawai"></span></p>
                            <table id="detailBarang">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <button onclick="tutupModal()">Tutup</button>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Aplikasi Kasir | @sasyyaw</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script>
        function tampilkanDetailTransaksi(transaksiId) {
            fetch('get_detail_transaksi.php?id=' + transaksiId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('detailTanggal').textContent = data.tanggal;
                    document.getElementById('detailPegawai').textContent = data.nama_pegawai;

                    let tbody = document.querySelector('#detailBarang tbody');
                    tbody.innerHTML = '';

                    data.barang.forEach(item => {
                        let row = tbody.insertRow();
                        row.insertCell(0).textContent = item.nama_barang;
                        row.insertCell(1).textContent = "Rp " + item.harga;
                        row.insertCell(2).textContent = item.jumlah;
                        row.insertCell(3).textContent = "Rp " + item.subtotal;
                    });

                    document.getElementById('detailModal').style.display = 'block';
                });
        }

        function tutupModal() {
            document.getElementById('detailModal').style.display = 'none';
        }
    </script>
</body>
</html>