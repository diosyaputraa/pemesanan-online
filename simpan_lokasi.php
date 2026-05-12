<?php
include 'config/koneksi.php';

$nama = $_POST['nama_kecamatan'];
$biaya = $_POST['biaya_pengiriman'];

mysqli_query($conn,"INSERT INTO kecamatan VALUES(
'',
'$nama',
'$biaya'
)");

header("Location: barang.php");
?>