<?php
include 'config/koneksi.php';

$id = $_POST['id'];
$nama = $_POST['nama_kecamatan'];
$biaya = $_POST['biaya_pengiriman'];

mysqli_query($conn,"UPDATE kecamatan SET
nama_kecamatan='$nama',
biaya_pengiriman='$biaya'
WHERE id='$id'");

header("Location: barang.php");
?>