<?php
require 'functions.php';

$sql = "SELECT id, nama, harga_jual FROM barang";
$result = mysqli_query($conn, $sql);

$barang = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $barang[] = $row;
    }
}

echo json_encode($barang);
?>
