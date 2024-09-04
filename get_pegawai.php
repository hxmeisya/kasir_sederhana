<?php
header('Content-Type: application/json');

// Koneksi ke database
$host = 'localhost'; // Ganti dengan host database Anda
$dbname = 'kasirr'; // Ganti dengan nama database Anda
$user = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query untuk mengambil nama pegawai
    $stmt = $pdo->query("SELECT id, nama FROM pegawai");
    $pegawai = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($pegawai);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
