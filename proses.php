<?php
include 'config/koneksi.php';
if (isset($_POST['submit'])) {

    $nama_pelanggan = $_POST['nama_pelanggan'];
    $nama_barang    = $_POST['nama_barang'];
    $jumlah_barang  = (int) $_POST['jumlah_barang'];
    $kecamatan      = $_POST['kecamatan'];

    // Menentukan harga barang
    if ($nama_barang == "T-Shirt") {
        $hargabarang = 50000;
    } elseif ($nama_barang == "Celana Joger") {
        $hargabarang = 125000;
    } elseif ($nama_barang == "Celana Chinos") {
        $hargabarang = 112000;
    } elseif ($nama_barang == "Blues") {
        $hargabarang = 87000;
    } elseif ($nama_barang == "Dress") {
        $hargabarang = 172000;
    } elseif ($nama_barang == "Kemeja") {
        $hargabarang = 162000;
    } else {
        $hargabarang = 0;
    }

    // Menentukan biaya pengiriman
    if ($kecamatan == "Muara Bangkahulu") {
        $biayapengiriman = 15000;
    } elseif ($kecamatan == "Ratu Agung") {
        $biayapengiriman = 20000;
    } elseif ($kecamatan == "Ratu Samban") {
        $biayapengiriman = 25000;
    } elseif ($kecamatan == "Selebar") {
        $biayapengiriman = 17000;
    } elseif ($kecamatan == "Pagar Dewa") {
        $biayapengiriman = 13000;
    } elseif ($kecamatan == "Singaran Pati") {
        $biayapengiriman = 32000;
    } else {
        $biayapengiriman = 0;
    }

    // Fungsi menghitung total biaya
    function hitungTotalBiaya($hargabarang, $jumlah_barang, $biayapengiriman) {
        return ($hargabarang * $jumlah_barang) + $biayapengiriman;
    }

    $totalbiaya = hitungTotalBiaya($hargabarang, $jumlah_barang, $biayapengiriman);

    // Data yang akan disimpan ke JSON
    $data_pesanan = [
        "tanggal" => date("Y-m-d H:i:s"),
        "nama_pelanggan" => $nama_pelanggan,
        "nama_barang" => $nama_barang,
        "jumlah_barang" => $jumlah_barang,
        "harga_barang" => $hargabarang,
        "kecamatan" => $kecamatan,
        "biaya_pengiriman" => $biayapengiriman,
        "total_biaya" => $totalbiaya
    ];

$query = "INSERT INTO pesanan 
(nama_pelanggan, nama_barang, jumlah_barang, harga_barang, kecamatan, biaya_pengiriman, total_biaya)
VALUES 
('$nama_pelanggan', '$nama_barang', '$jumlah_barang', '$hargabarang', '$kecamatan', '$biayapengiriman', '$totalbiaya')";

mysqli_query($conn, $query) or die(mysqli_error($conn));

$file = 'data/data.json';

    // Membaca data lama jika ada
    if (file_exists($file)) {
        $current_data = json_decode(file_get_contents($file), true);
        if (!is_array($current_data)) {
            $current_data = [];
        }
    } else {
        $current_data = [];
    }

    // Menambahkan data baru
    $current_data[] = $data_pesanan;

    // Menyimpan kembali ke file JSON
    file_put_contents($file, json_encode($current_data, JSON_PRETTY_PRINT));

    // Redirect dengan SweetAlert
    echo "
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Pesanan Berhasil!',
                text: 'Total biaya: Rp. " . number_format($totalbiaya, 0, ',', '.') . "',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'tambah_barang.php';
            });
        </script>
    </body>
    </html>
    ";
}
?>