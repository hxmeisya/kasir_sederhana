<?php

session_start();

    if( !isset($_SESSION["login"]) ) {
        header("Location: login.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pembayaran | Aplikasi Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .payment-methods {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        .payment-methods h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .payment-method {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin: 10px;
            width: 80%;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .payment-method img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .payment-method p {
            margin: 0;
            font-size: 18px;
            color: #555;
        }

        .payment-method .details {
        display: none;
        margin-top: 10px;
    }

    .payment-method.show-details .details {
        display: block;
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
                    <h1 class="mt-4">Pembayaran</h1>
                    <div class="payment-methods">
                    <div class="payment-method">
                        <img src="img/cash.png" alt="Tunai"/>
                        <h5>Tunai</h5>
                        <p>Bayar dengan uang tunai, menerima semua nilai uang</p>
                    </div>
                        <div class="payment-method">
                            <img src="img/credit-card.png" alt="Kartu Kredit/Debit" />
                            <h5>Kartu Kredit/Debit</h5>
                            <p>Bayar dengan kartu kredit atau debit, menerima berbagai jenis kartu, termasuk Visa, Mastercard, dan JCB</p>
                        </div>
                        <div class="payment-method">
                            <img src="img/ewallet.png" alt="E-Wallet" />
                            <h5>E-Wallet</h5>
                            <p>Bayar dengan e-wallet, menerima berbagai e-wallet seperti OVO, GoPay, ShopeePay, Dana, dan LinkAja</p>
                            <div class="details">
                                <img src="img/qr-code-shopeepay.jpg" alt="QR Code E-Wallet" />
                            </div>
                        </div>
                        <div class="payment-method">
                            <img src="img/bank-transfer.png" alt="Transfer Bank" />
                            <h5>Transfer Bank</h5>
                            <p>Bayar dengan transfer bank ke rekening kami, menerima transfer dari berbagai bank di Indonesia</p>
                            <div class="details">
                                <p><strong>Rekening Kasir</strong> 123-456-7890</p>
                                <p><strong>A/N</strong> LuxeLoft Market</p>
                                <p><strong>Bank</strong> BCA (014)</p>
                            </div>
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
    const paymentMethods = document.querySelectorAll('.payment-method');

    paymentMethods.forEach(method => {
        method.addEventListener('click', () => {
            method.classList.toggle('show-details');
        });
    });
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>