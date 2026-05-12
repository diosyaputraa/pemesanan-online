<?php
session_start();

include __DIR__ . '/../config/koneksi.php';
include __DIR__ . '/../config/koneksi_json.php';

/* =========================
   CEK USER LOGIN
========================= */
if (!isset($_SESSION['user'])) {
    die("User belum login");
}

$user = $_SESSION['user'];

/* =========================
   AMBIL DATA POST
========================= */
$nama_pelanggan = $_POST['nama_pelanggan'] ?? '';
$nama_barang    = $_POST['nama_barang'] ?? '';
$jumlah_barang  = $_POST['jumlah_barang'] ?? 0;
$kecamatan      = $_POST['kecamatan'] ?? '';

/* =========================
   VALIDASI
========================= */
if (
    empty($nama_pelanggan) ||
    empty($nama_barang) ||
    empty($jumlah_barang) ||
    empty($kecamatan)
) {
    die("Data belum lengkap");
}

/* =========================
   AMBIL DATA BARANG
========================= */
$barang = mysqli_query($conn, "SELECT * FROM barang 
WHERE nama_barang='$nama_barang'");

$data_barang = mysqli_fetch_assoc($barang);

if (!$data_barang) {
    die("Barang tidak ditemukan");
}

/* =========================
   AMBIL HARGA
========================= */
$harga_barang = $data_barang['harga'];

/* =========================
   ONGKIR
========================= */
switch ($kecamatan) {

    case "Muara Bangkahulu":
        $ongkir = 15000;
        break;

    case "Pagar Dewa":
        $ongkir = 13000;
        break;

    case "Ratu Agung":
        $ongkir = 20000;
        break;

    case "Ratu Samban":
        $ongkir = 25000;
        break;

    case "Selebar":
        $ongkir = 17000;
        break;

    case "Singaran Pati":
        $ongkir = 32000;
        break;

    default:
        $ongkir = 0;
}

/* =========================
   HITUNG TOTAL
========================= */
$total = ($harga_barang * $jumlah_barang) + $ongkir;

/* =========================
   SIMPAN KE DATABASE
========================= */
$query = mysqli_query($conn, "
INSERT INTO pesanan
(
    user,
    nama_pelanggan,
    nama_barang,
    jumlah_barang,
    harga_barang,
    kecamatan,
    biaya_pengiriman,
    total_biaya
)

VALUES
(
    '$user',
    '$nama_pelanggan',
    '$nama_barang',
    '$jumlah_barang',
    '$harga_barang',
    '$kecamatan',
    '$ongkir',
    '$total'
)
");

/* =========================
   CEK QUERY
========================= */
if (!$query) {

    die("Gagal menyimpan pesanan: " . mysqli_error($conn));
}

/* =========================
   SIMPAN KE JSON
========================= */
$jsonConn = getJsonConnection();

$data_baru = [

    'user' => $user,
    'nama_pelanggan' => $nama_pelanggan,
    'nama_barang' => $nama_barang,
    'jumlah_barang' => $jumlah_barang,
    'harga_barang' => $harga_barang,
    'kecamatan' => $kecamatan,
    'ongkir' => $ongkir,
    'total' => $total,
    'tanggal' => date('Y-m-d H:i:s')

];

$jsonConn->addData($data_baru);

?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<title>Proses Pesanan</title>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<script>

Swal.fire({
    title: 'Pesanan Berhasil!',
    text: 'Pesanan kamu sudah dikirim 🎉',
    icon: 'success',
    confirmButtonColor: '#4facfe'
}).then(() => {

    window.location = 'barang_user.php';

});

</script>

</body>
</html>