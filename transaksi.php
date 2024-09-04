<?php
require 'functions.php';
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
        <title>Transaksi | Aplikasi Kasir</title>
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

button {
    display: inline-block;
    padding: 3px 6px;
    font-size: 12px;
    background-color: #f8f9fa;
    color: #007bff;
    border: 1px solid #007bff;
    border-radius: 3px;
    text-decoration: none;
}

button:hover {
    background-color: #007bff;
    color: #ffffff;
}

button:focus {
    outline: none;
}

input[type="number"] {
    width: 80px;
    padding: 5px;
    margin: 0 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button[type="button"] {
    padding: 8px 12px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    margin-top: 10px;
}

button[type="button"]:hover {
    background-color: #0056b3;
    transition: background-color 0.3s;
}

.total-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.total-container label {
    font-size: 16px;
    font-weight: bold;
}

.total-container input[type="text"] {
    font-size: 16px;
    text-align: right;
}

button#kosongkan_daftar {
    background-color: #dc3545;
    border: none;
    color: white;
}

button#kosongkan_daftar:hover {
    background-color: #c82333;
}

button#kosongkan_daftar:active {
    background-color: #bd2130;
}

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

#cetak_struk {
    padding: 8px 12px;
    background-color: lightblue;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    margin-top: 10px;
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
            <h1 class="mt-4">Transaksi</h1>
            <ol class="breadcrumb mb-4"></ol>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> Daftar Transaksi
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                    <form id="transaksi_form">
                                <div>
                                    <label for="nama_pegawai">Nama Kasir</label>
                                    <select id="nama_pegawai">
                                    </select>
                                </div>

                                <div>
                                    <label for="nama_pelanggan">Nama Pelanggan</label>
                                    <input type="text" id="nama_pelanggan" placeholder="Masukkan nama pelanggan jika ada">
                                </div>
                                
                                <div>
                                    <label for="nama_barang">Nama Barang</label>
                                    <select id="nama_barang">
                                    </select>

                                    <label for="jumlah_barang">Jumlah Barang</label>
                                    <input type="number" id="jumlah_barang" min="1" value="1">

                                    <button type="button" id="tambah_barang">Tambah</button>
                                </div>

                            </form>
                            
                            <table id="daftarBarang" class="mt-3">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Harga Satuan</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>

                            <button type="button" id="kosongkan_daftar" class="mt-3">Kosongkan Daftar</button>

                            <div class="total-container mt-3">
                                <label for="total_semua">Total Harga:</label>
                                <input type="text" id="total_semua" readonly value="Rp 0">
                            </div>

                            <div class="payment-container mt-3">
                                <label for="uang_pelanggan">Bayar:</label>
                                <input type="text" id="uang_pelanggan" min="0" placeholder="Masukkan jumlah uang" oninput="updateKembalian()">

                                <label for="kembalian">Kembali:</label>
                                <input type="text" id="kembalian" readonly value="Rp 0">
                            </div>

                            <button type="submit" onclick="window.location.href='simpan_transaksi.php'" id="simpan_transaksi" class="mt-3">Simpan Transaksi</button>
                            <button type="button" id="cetak_struk" class="mt-3">Cetak Struk</button>
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
let daftarBarang = [];
const daftarBarangTable = document.querySelector("#daftarBarang tbody");
const totalSemuaInput = document.getElementById("total_semua");

window.onload = function() {
    // Mengambil data barang untuk dropdown
    fetch('get_barang.php')
        .then(response => response.json())
        .then(data => {
            let namaBarangSelect = document.getElementById('nama_barang');
            data.forEach(barang => {
                let option = document.createElement('option');
                option.value = barang.id;
                option.setAttribute('data-harga', barang.harga_jual);
                option.textContent = barang.nama;
                namaBarangSelect.appendChild(option);
            });
        });

    // Mengambil data pegawai untuk dropdown
    fetch('get_pegawai.php')
        .then(response => response.json())
        .then(data => {
            const namaPegawaiSelect = document.getElementById('nama_pegawai');
            data.forEach(pegawai => {
                const option = document.createElement('option');
                option.value = pegawai.id;
                option.textContent = pegawai.nama;
                namaPegawaiSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
};

function updateKembalian() {
    const totalHargaInput = document.getElementById('total_semua');
    const uangPelangganInput = document.getElementById('uang_pelanggan');
    const kembalianInput = document.getElementById('kembalian');

    const totalHarga = parseFloat(totalHargaInput.value.replace('Rp ', '').replace('.', '').replace(',', '.')) || 0;
    const uangPelanggan = parseFloat(uangPelangganInput.value.replace('Rp ', '').replace('.', '').replace(',', '.')) || 0;

    const kembalian = uangPelanggan - totalHarga;
    kembalianInput.value = 'Rp ' + numberFormat(kembalian);
}

function numberFormat(number) {
    return number.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
}

document.addEventListener('DOMContentLoaded', updateKembalian);

document.getElementById('tambah_barang').addEventListener('click', function() {
    let namaBarangSelect = document.getElementById('nama_barang');
    let hargaBarang = parseFloat(namaBarangSelect.selectedOptions[0].getAttribute('data-harga'));
    let idBarang = namaBarangSelect.selectedOptions[0].value;
    let namaBarang = namaBarangSelect.options[namaBarangSelect.selectedIndex].text;
    let jumlahBarang = parseInt(document.getElementById('jumlah_barang').value);

    if (isNaN(jumlahBarang) || jumlahBarang <= 0) {
        alert('Jumlah barang harus lebih dari 0');
        return;
    }

    daftarBarang.push({ id: idBarang, nama: namaBarang, harga: hargaBarang, jumlah: jumlahBarang });
    tampilkanDaftarBarang();
    document.getElementById('jumlah_barang').value = 1;
});

function tampilkanDaftarBarang() {
    daftarBarangTable.innerHTML = '';
    let totalSemua = 0;

    daftarBarang.forEach((barang, index) => {
        let subtotal = barang.harga * barang.jumlah;
        totalSemua += subtotal;

        let row = daftarBarangTable.insertRow();
        row.insertCell(0).textContent = barang.nama;
        row.insertCell(1).textContent = "Rp " + numberFormat(barang.harga);
        row.insertCell(2).textContent = barang.jumlah;
        row.insertCell(3).textContent = "Rp " + numberFormat(subtotal);

        let aksiCell = row.insertCell(4);
        let hapusButton = document.createElement('button');
        hapusButton.textContent = 'Hapus';
        hapusButton.classList.add('small-button');
        hapusButton.addEventListener('click', function() {
            daftarBarang.splice(index, 1);
            tampilkanDaftarBarang();
        });
        aksiCell.appendChild(hapusButton);
    });

    totalSemuaInput.value = "Rp " + numberFormat(totalSemua);
}

document.getElementById('kosongkan_daftar').addEventListener('click', function() {
    daftarBarang = [];
    tampilkanDaftarBarang();
});

document.getElementById('simpan_transaksi').addEventListener('click', function() {
        if (daftarBarang.length === 0) {
            alert('Daftar barang masih kosong');
            return;
        }

        let total_harga = parseFloat(totalSemuaInput.value.replace('Rp ', '').replace(',', ''));

        const dataToSend = {
            id_pelanggan: 1, // Ubah jika perlu
            id_pegawai: document.getElementById('nama_pegawai').value,
            total_harga: total_harga,
            barang: daftarBarang
        };

        console.log('Data yang dikirim:', dataToSend);

        fetch('simpan_transaksi.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(dataToSend)
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert('Transaksi berhasil disimpan!');
                  daftarBarang = [];
                  tampilkanDaftarBarang();
              } else {
                  alert('Gagal menyimpan transaksi: ' + data.message);
              }
          });
    });

document.getElementById('cetak_struk').addEventListener('click', function() {
    let now = new Date();
    let waktuSekarang = `${now.getDate()}/${now.getMonth() + 1}/${now.getFullYear()} ${now.getHours()}:${now.getMinutes()}:${now.getSeconds()}`;

    const uangPelanggan = parseFloat(document.getElementById('uang_pelanggan').value.replace('Rp ', '').replace('.', '').replace(',', '.')) || 0;
    const totalHarga = parseFloat(totalSemuaInput.value.replace('Rp ', '').replace('.', '').replace(',', '.')) || 0;
    const kembalian = uangPelanggan - totalHarga;

    let strukContent = `
        <div style="font-family: 'Courier New', Courier, monospace;">
            <h2>Struk Pembelian</h2>
            <p>LuxeLoft Market</p>
            <p>Jl. Balai Rakyat 1 No. 15, RT. 13/RW. 07, Utan Kayu Utara, Matraman, DKI Jakarta, 13120</p>
            <p>Tanggal dan Waktu: ${waktuSekarang}</p>
            <hr>
            <table>
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    ${daftarBarang.map(barang => `
                        <tr>
                            <td>${barang.nama}</td>
                            <td>Rp ${numberFormat(barang.harga)}</td>
                            <td>${barang.jumlah}</td>
                            <td>Rp ${numberFormat(barang.harga * barang.jumlah)}</td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
            <hr>
            <p>Total: Rp ${numberFormat(totalHarga)}</p>
            <p>Bayar: Rp ${numberFormat(uangPelanggan)}</p>
            <p>Kembali: Rp ${numberFormat(kembalian)}</p>
            <p>Terima kasih telah berbelanja!</p>
        </div>
    `;

    let newWindow = window.open('', '', 'width=600,height=400');
    newWindow.document.write(strukContent);
    newWindow.document.close();
    newWindow.focus();
    newWindow.print();
    newWindow.close();
});
</script>
</body>
</html>