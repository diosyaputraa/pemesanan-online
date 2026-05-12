<?php
include '../config/koneksi_json.php';

$jsonConn = getJsonConnection();
$data = $jsonConn->getData();
?>

<h2>Data Pemesanan</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Nama</th>
        <th>Barang</th>
        <th>Jumlah</th>
        <th>Kecamatan</th>
        <th>Total</th>
    </tr>

    <?php foreach ($data as $d) { ?>
        <tr>
            <td><?= $d['nama_pelanggan']; ?></td>
            <td><?= $d['nama_barang']; ?></td>
            <td><?= $d['jumlah_barang']; ?></td>
            <td><?= $d['kecamatan']; ?></td>
            <td>Rp <?= number_format($d['total']); ?></td>
        </tr>
    <?php } ?>

</table>