<?php
require 'functions.php';
session_start();

    if( !isset($_SESSION["login"]) ) {
        header("Location: login.php");
        exit;
    }

if (isset($_POST["submit"])) {
    if (tambahBarang($_POST) > 0) {
        echo "
        <script>
        alert('barang berhasil ditambahkan!');
        document.location.href='index.php';
        </script>";
    } else {
        echo "
        <script>
        alert('barang gagal ditambahkan!');
        document.location.href='index.php';
        </script>";
    }
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
    <title>Tambah Barang | Aplikasi Kasir</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        h4 {
            text-align: center;
            color: #333;
            padding-top: 35px;
        }

        nav {
            width: 100%;
            background-color: #212529;
            padding-left: 1rem !important;
            padding: 15px;
            font-size: 19px;
            color: white;
            height: 100px;
        }

        form {
            width: 100%;
            max-width: 500px;
            margin: 20px 10px;
            padding: 20px;
            background: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="number"],
        input[type="date"],
        button,
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
            color: black;
            cursor: pointer;
        }

        input[type="file"]::file-selector-button {
            background-color: black;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="file"]::file-selector-button:hover {
            background-color: dimgrey;
        }

        button {
            border-radius: 8px;
            background-color: black;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: dimgrey;
        }
    </style>
</head>
<body>
    <nav>
        <a class="navbar-brand" href="index.php" style="color: white;">Aplikasi Kasir</a>
    </nav>
    <h4>Tambah daftar barang</h4>
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama">
            </li>
            <li>
                <label for="harga_beli">Harga Beli</label>
                <input type="text" name="harga_beli" id="harga_beli">
            </li>
            <li>
                <label for="harga_jual">Harga Jual</label>
                <input type="text" name="harga_jual" id="harga_jual">
            </li>
            <li>
                <label for="diskon">Diskon (%)</label>
                <input type="number" name="diskon" id="diskon" value="<?= $row['diskon']; ?>">
            </li>
            <li>
                <label for="stok">Stok</label>
                <input type="number" name="stok" id="stok">
            </li>
            <li>
                <label for="kode_barang">Kode Barang</label>
                <input type="text" name="kode_barang" id="kode_barang">
            </li>
            <li>
                <label for="expired">Expired</label>
                <input type="date" name="expired" id="expired">
            </li>
            <li class="image">
                <label for="gambar">Gambar</label>
                <input type="file" name="gambar" id="gambar">
            </li>
            <li>
                <button type="submit" name="submit">Tambah Data</button>
            </li>
        </ul>
    </form>
</body>
</html>
