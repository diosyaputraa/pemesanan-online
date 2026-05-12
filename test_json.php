<?php
include 'config/koneksi_json.php';

$db = getJsonConnection();

$db->addData([
    "nama" => "TEST",
    "barang" => "Baju",
    "total" => 12345
]);

echo "BERHASIL";