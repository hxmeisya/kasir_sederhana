<?php
    $conn = mysqli_connect("localhost", "root", "", "kasirr");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    function query($query) {
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        return $rows;
    }

    function login($username, $password) {
        global $conn;
    
        $query = "SELECT * FROM pegawai WHERE username = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['admin'] = $row['admin'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['login'] = true;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    
    function registrasi($data) {
        global $conn;
    
        $nama = htmlspecialchars($data["nama"]);
        $email = htmlspecialchars($data["email"]);
        $admin = htmlspecialchars($data["admin"]);
        $no_hp = htmlspecialchars($data["no_hp"]);
        $alamat = htmlspecialchars($data["alamat"]);
    
        $username = strtolower(stripslashes($data["username"]));
        $password = mysqli_real_escape_string($conn, $data["password"]);
        $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    
        $result = mysqli_query($conn, "SELECT username FROM pegawai WHERE username = '$username'");
        if (mysqli_fetch_assoc($result)) {
            echo "<script>
                alert('Username sudah terdaftar!');
            </script>";
            return false;
        }
    
        if ($password !== $password2) {
            echo "<script>
                alert('Konfirmasi password tidak sesuai!');
            </script>";
            return false;
        }
        $password = password_hash($password, PASSWORD_DEFAULT);
    
        mysqli_query($conn, "INSERT INTO pegawai (nama, email, admin, no_hp, alamat, username, password) VALUES ('$nama', '$email', '$admin', '$no_hp', '$alamat', '$username', '$password')");
        return mysqli_affected_rows($conn);
    }
    

    function tambahBarang($data) {
        global $conn;
    
        $nama = htmlspecialchars($data["nama"]);
        $harga_beli = htmlspecialchars($data["harga_beli"]);
        $harga_jual = htmlspecialchars($data["harga_jual"]);
        $diskon = htmlspecialchars($data["diskon"]);
        $stok = htmlspecialchars($data["stok"]);
        $kode_barang = htmlspecialchars($data["kode_barang"]);
        $expired = htmlspecialchars($data["expired"]);

        $gambar = upload();
        if( !$gambar ) {
            return false;
        }
    
        $query = "INSERT INTO barang (nama, harga_beli, harga_jual, diskon, stok, kode_barang, expired, gambar) 
                  VALUES ('$nama', '$harga_beli', '$harga_jual', '$diskon', '$stok', '$kode_barang', '$expired', '$gambar')";
    
        mysqli_query($conn, $query);
    
        return mysqli_affected_rows($conn);
    }
    function upload() {
        $namaFile = $_FILES['gambar']['name'];
        $ukuranFile = $_FILES['gambar']['size'];
        $error = $_FILES['gambar']['error'];
        $tmpName = $_FILES['gambar']['tmp_name'];

        if($error === 4 ) {
            echo "<script>
                alert('pilih gambar terlebih dahulu!')
            </script>";
        return false;
        }

        $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
        $ekstensiGambar = explode('.', $namaFile);
        $ekstensiGambar = strtolower(end($ekstensiGambar));
        if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
        echo "<script>
                alert('yang anda upload bukan gambar!')
            </script>";
        return false;
        }

        if( $ukuranFile > 1000000 ) {
            echo "<script>
                alert('ukuran gambar terlalu besar!')
            </script>";
        return false;
        }

        $namaFileBaru = uniqid();
        $namaFileBaru .= '.' ;
        $namaFileBaru .= $ekstensiGambar;

        move_uploaded_file($tmpName, 'img/' . $namaFile);

        return $namaFile;
    }

    function hapusBarang($id) {
        global $conn;
        mysqli_query($conn, "DELETE FROM barang WHERE id='$id'");
        return mysqli_affected_rows($conn);
    }

    function ubahBarang($data) {
        global $conn;

        $id = $data["id"];
        $nama = htmlspecialchars($data["nama"]);
        $harga_beli = htmlspecialchars($data["harga_beli"]);
        $harga_jual = htmlspecialchars($data["harga_jual"]);
        $diskon = htmlspecialchars($data["diskon"]);
        $stok = htmlspecialchars($data["stok"]);
        $kode_barang = htmlspecialchars($data["kode_barang"]);
        $expired = htmlspecialchars($data["expired"]);
        $gambarLama = htmlspecialchars($data["gambarLama"]);

        if( $_FILES['gambar']['error'] === 4 ) {
            $gambar = $gambarLama;
        } else {
            $gambar = upload();
        }

        $query = "UPDATE barang SET
                    nama = '$nama',
                    harga_beli = '$harga_beli',
                    harga_jual = '$harga_jual',
                    diskon = '$diskon',
                    stok = '$stok',
                    kode_barang = '$kode_barang',
                    expired = '$expired',
                    gambar = '$gambar'
                WHERE id = $id
                ";

        mysqli_query($conn, $query);

        return mysqli_affected_rows($conn);
    }

    function simpanTransaksi($id_pelanggan, $id_pegawai, $total_harga, $barang) {
        global $conn;
        
        $query = "INSERT INTO transaksi (id_pelanggan, id_pegawai, total_harga, tanggal) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iid", $id_pelanggan, $id_pegawai, $total_harga);
        $stmt->execute();
        
        $transaksi_id = $conn->insert_id;
        
        foreach ($barang as $item) {
            $query_detail = "INSERT INTO detail_transaksi (id_transaksi, id_barang, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)";
            $stmt_detail = $conn->prepare($query_detail);
            $stmt_detail->bind_param("iiidd", $transaksi_id, $item['id'], $item['jumlah'], $item['harga'], $item['subtotal']);
            $stmt_detail->execute();
        }
        
        return $transaksi_id;
    }
?>