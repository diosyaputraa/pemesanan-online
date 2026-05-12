<?php
session_start();

include __DIR__ . '/koneksi_user.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];

/* Ambil pesanan user */
$data = mysqli_query($conn,
"SELECT * FROM pesanan WHERE nama_pelanggan='$user'");

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Pesanan Saya</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Poppins',sans-serif;
}

body{
    min-height:100vh;
    padding:25px;
    background:
    radial-gradient(circle at top left,#60a5fa 0%,transparent 30%),
    radial-gradient(circle at bottom right,#22d3ee 0%,transparent 30%),
    linear-gradient(135deg,#0f172a,#1e293b,#0f172a);
}

/* Container */
.container{
    max-width:1200px;
    margin:auto;
    background:rgba(255,255,255,.10);
    border:1px solid rgba(255,255,255,.12);
    backdrop-filter:blur(18px);
    border-radius:28px;
    padding:30px;
    box-shadow:0 25px 50px rgba(0,0,0,.30);
    animation:muncul .8s ease;
}

@keyframes muncul{
    from{
        opacity:0;
        transform:translateY(25px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* Header */
.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
    margin-bottom:25px;
}

.top h2{
    color:white;
    font-weight:700;
}

.top p{
    color:#dbeafe;
    font-size:14px;
}

/* Button */
.btn{
    display:inline-block;
    padding:11px 18px;
    border-radius:14px;
    text-decoration:none;
    color:white;
    font-weight:600;
    background:linear-gradient(90deg,#2563eb,#06b6d4);
    transition:.3s;
}

.btn:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 24px rgba(37,99,235,.35);
}

/* Table Box */
.table-box{
    overflow-x:auto;
    border-radius:20px;
}

/* Table */
table{
    width:100%;
    border-collapse:collapse;
    min-width:900px;
    overflow:hidden;
}

th{
    background:linear-gradient(90deg,#2563eb,#06b6d4);
    color:white;
    padding:14px;
    text-align:center;
    font-size:14px;
}

td{
    background:rgba(255,255,255,.92);
    padding:13px;
    text-align:center;
    border-bottom:1px solid #e5e7eb;
    font-size:14px;
}

tr:hover td{
    background:#eff6ff;
}

/* Badge Total */
.total{
    font-weight:700;
    color:#2563eb;
}

/* Empty */
.kosong{
    text-align:center;
    padding:25px;
    color:white;
}

/* Mobile */
@media(max-width:768px){
    .container{
        padding:20px;
    }

    .top{
        flex-direction:column;
        align-items:flex-start;
    }
}
</style>
</head>

<body>

<div class="container">

    <div class="top">
        <div>
            <h2>📦 Pesanan Saya</h2>
            <p>Halo <?= $_SESSION['user']; ?>, berikut riwayat pesanan kamu</p>
        </div>

        <a href="barang_user.php" class="btn">⬅ Kembali</a>
    </div>

    <div class="table-box">

        <table>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Kecamatan</th>
                <th>Ongkir</th>
                <th>Total</th>
            </tr>

            <?php
            $no = 1;
            if(mysqli_num_rows($data) > 0):
            while($row = mysqli_fetch_assoc($data)){
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_barang']; ?></td>
                <td><?= $row['jumlah_barang']; ?></td>
                <td>Rp <?= number_format($row['harga_barang']); ?></td>
                <td><?= $row['kecamatan']; ?></td>
                <td>Rp <?= number_format($row['biaya_pengiriman']); ?></td>
                <td class="total">Rp <?= number_format($row['total_biaya']); ?></td>
            </tr>
            <?php } else: ?>
            <tr>
                <td colspan="7" class="kosong">Belum ada pesanan 😄</td>
            </tr>
            <?php endif; ?>

        </table>

    </div>

</div>

</body>
</html>