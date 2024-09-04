<?php
require 'functions.php'; // Pastikan functions.php berisi koneksi database yang valid

// Decode JSON data from the request body
$data = json_decode(file_get_contents('php://input'), true);

// Check if all necessary data is provided
if (isset($data['id_pelanggan']) && isset($data['id_pegawai']) && isset($data['total_harga']) && isset($data['barang'])) {
    
    $id_pelanggan = $data['id_pelanggan'];
    $id_pegawai = $data['id_pegawai'];
    $total_harga = $data['total_harga'];
    $tanggal = date('Y-m-d H:i:s');

    // Prepare the SQL statement to prevent SQL injection
    if ($stmt = $conn->prepare("INSERT INTO transaksi (id_pelanggan, id_pegawai, total_harga, tanggal) VALUES (?, ?, ?, ?)")) {
        $stmt->bind_param("iiis", $id_pelanggan, $id_pegawai, $total_harga, $tanggal);

        // Execute the query
        if ($stmt->execute()) {
            $id_transaksi = $conn->insert_id;

            // Prepare the SQL statement for detail transaksi
            if ($stmt_detail = $conn->prepare("INSERT INTO detail_transaksi (id_transaksi, id_barang, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)")) {
                foreach ($data['barang'] as $barang) {
                    $id_barang = $barang['id'];
                    $jumlah = $barang['jumlah'];
                    $harga_satuan = $barang['harga'];
                    $subtotal = $harga_satuan * $jumlah;
                    $stmt_detail->bind_param("iiidd", $id_transaksi, $id_barang, $jumlah, $harga_satuan, $subtotal);
                    $stmt_detail->execute();
                }

                // Send success response
                echo json_encode(['success' => true, 'id_transaksi' => $id_transaksi]);
            } else {
                // Send error response for detail transaksi
                echo json_encode(['success' => false, 'message' => 'Gagal menyiapkan query detail transaksi: ' . $conn->error]);
            }

            // Close detail transaksi statement
            $stmt_detail->close();
        } else {
            // Send error response for transaksi
            echo json_encode(['success' => false, 'message' => 'Gagal menyimpan transaksi: ' . $conn->error]);
        }

        // Close transaksi statement
        $stmt->close();
    } else {
        // Send error response for transaksi preparation
        echo json_encode(['success' => false, 'message' => 'Gagal menyiapkan query transaksi: ' . $conn->error]);
    }
} else {
    // Send error response
    echo json_encode(['success' => false, 'message' => 'Data tidak lengkap']);
}

// Close the database connection
$conn->close();
?>
