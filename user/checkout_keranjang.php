<?php
session_start();
include __DIR__ . '/koneksi_user.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

/* CEK KERANJANG */
if (empty($_SESSION['keranjang'])) {
    header("Location: keranjang.php");
    exit;
}

/* CEK KECAMATAN */
if (!isset($_POST['kecamatan']) || $_POST['kecamatan'] == '') {
    header("Location: keranjang.php");
    exit;
}

$nama_pelanggan = $_SESSION['user'];
$kecamatan      = $_POST['kecamatan'];

/* ONGKIR MANUAL */
switch ($kecamatan) {

    case "Muara bangkahulu":
        $ongkir = 15000;
        break;

    case "Ratu Agung":
        $ongkir = 20000;
        break;

    case "Ratu samban":
        $ongkir = 25000;
        break;

    case "Selebar":
        $ongkir = 17000;
        break;

    case "Pagar Dewa":
        $ongkir = 13000;
        break;

    case "Singaran Pati":
        $ongkir = 32000;
        break;

    default:
        $ongkir = 0;
}

/* LOOP KERANJANG */
foreach ($_SESSION['keranjang'] as $id => $jumlah) {

    $query = mysqli_query($conn, "
    SELECT * FROM barang 
    WHERE id='$id'
    ");

    $barang = mysqli_fetch_assoc($query);

    if (!$barang) {
        continue;
    }

    /* SESUAI DATABASE BARANG */
    $nama_barang  = $barang['nama_barang'];
    $harga_barang = $barang['harga'];

    /* HITUNG TOTAL */
    $total_biaya = ($harga_barang * $jumlah) + $ongkir;

    /* SIMPAN KE DATABASE */
    mysqli_query($conn,"
    INSERT INTO pesanan
    (
        nama_pelanggan,
        nama_barang,
        jumlah_barang,
        harga_barang,
        kecamatan,
        biaya_pengiriman,
        total_biaya,
        tanggal
    )
    VALUES
    (
        '$nama_pelanggan',
        '$nama_barang',
        '$jumlah',
        '$harga_barang',
        '$kecamatan',
        '$ongkir',
        '$total_biaya',
        NOW()
    )
    ");
}

/* KOSONGKAN KERANJANG */
$_SESSION['keranjang'] = [];

/* ALERT */
$_SESSION['alert_checkout'] = "sukses";

/* REDIRECT */
header("Location: keranjang.php");
exit;
?> 