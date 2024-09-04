<?php
require 'functions.php';
session_start();
    if( !isset($_SESSION["login"]) ) {
        header("Location: login.php");
        exit;
    }

    $barang = query('SELECT * FROM barang');
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang | Aplikasi Kasir</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>

            .tambah {
                display: block;
                margin: 20px 0 10px;
                width: 200px;
                padding: 10px 20px;
                background-color: black;
                color: white;
                text-align: center;
                text-decoration: none;
                border-radius: 10px;
            }

            .tambah:hover {
                color: white;
                background-color: dimgrey;
                transition: background-color 0.3s;
            }

            .small-button {
                display: inline-block;
                padding: 3px 6px;
                font-size: 12px;
                background-color: #f8f9fa;
                color: #007bff;
                border: 1px solid #007bff;
                border-radius: 3px;
                text-decoration: none;
            }

            .small-button:hover {
                background-color: #007bff;
                color: #ffffff;
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
                        <h1 class="mt-4">Barang</h1>
                        <ol class="breadcrumb mb-4">
                        </ol>
                        <a href="tambahbarang.php" class="tambah">Tambah daftar barang</a>
                        <br>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Daftar Barang
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Aksi</th>
                                            <th>Gambar</th>
                                            <th>Nama</th>
                                            <th>Harga Beli</th>
                                            <th>Harga Jual</th>
                                            <th>Diskon (%)</th>
                                            <th>Stok</th>
                                            <th>Kode barang</th>
                                            <th>Expired</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach( $barang as $row ) : ?>
                                            <tr>
                                                <td><?= $i; ?></td>
                                                <td class="aksi">
                                                    <a href="ubahbarang.php?id=<?= $row["id"]; ?>" class="small-button">ubah</a>
                                                    <a href="hapusbarang.php?id=<?= $row["id"]; ?>" class="small-button" onclick="return confirm('yakin?')">hapus</a>
                                                </td>
                                                <td><img src="img/<?= $row["gambar"]; ?>" width="80"></td>
                                                <td><?= $row["nama"]; ?></td>
                                                <td><?= $row["harga_beli"]; ?></td>
                                                <td><?= $row["harga_jual"]; ?></td>
                                                <td>
                                                    <?php 
                                                    $harga_jual = $row["harga_jual"];
                                                    $diskon = $row["diskon"];
                                                    $harga_setelah_diskon = $harga_jual - ($harga_jual * $diskon / 100);
                                                    ?>
                                                    <?= $harga_setelah_diskon; ?>
                                                </td>
                                                <td><?= $row["stok"]; ?></td>
                                                <td><?= $row["kode_barang"]; ?></td>
                                                <td><?= $row["expired"]; ?></td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
