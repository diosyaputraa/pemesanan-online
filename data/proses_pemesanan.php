<?php
include '../config/koneksi_json.php';

if (isset($_POST['submit'])) {

    $nama       = $_POST['nama'];
    $barang     = $_POST['barang'];
    $jumlah     = (int) $_POST['jumlah'];
    $kecamatan  = $_POST['kecamatan'];

    // harga barang
    $hargaList = [
        "T-shirt" => 50000,
        "Celana Joger" => 125000,
        "Celana Chinos" => 112000,
        "Blues" => 87000,
        "Dress" => 172000,
        "Kemeja" => 162000
    ];

    $hargabarang = $hargaList[$barang] ?? 0;

    // ongkir
    $ongkirList = [
        "Muara Bangkahulu" => 15000,
        "Ratu Agung" => 20000,
        "Ratu Samban" => 25000,
        "Selebar" => 17000,
        "Pagar Dewa" => 13000,
        "Singaran Pati" => 32000
    ];

    $biayapengiriman = $ongkirList[$kecamatan] ?? 0;

    // total
    $totalbiaya = ($hargabarang * $jumlah) + $biayapengiriman;

    // data JSON
    $dataBaru = [
        "nama" => $nama,
        "barang" => $barang,
        "jumlah" => $jumlah,
        "kecamatan" => $kecamatan,
        "harga_barang" => $hargabarang,
        "ongkir" => $biayapengiriman,
        "total" => $totalbiaya,
        "tanggal" => date("Y-m-d H:i:s")
    ];

    // simpan
    $jsonConn = getJsonConnection();
    $jsonConn->addData($dataBaru);

    // notifikasi
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Pesanan berhasil!',
            text: 'Total: Rp " . number_format($totalbiaya, 0, ',', '.') . "'
        }).then(() => {
            window.location.href = 'pemesanan.php';
        });
    </script>";
}