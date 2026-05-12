<?php
session_start();

include __DIR__ . '/koneksi_user.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM barang");
?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout Pesanan</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    radial-gradient(circle at top left,#fb923c 0%,transparent 25%),
    radial-gradient(circle at bottom right,#f97316 0%,transparent 25%),
    linear-gradient(135deg,#111827,#1f2937,#111827);
}

/* CONTAINER */
.wrapper{
    max-width:1200px;
    margin:auto;
    display:grid;
    grid-template-columns:1.2fr .8fr;
    gap:25px;
    align-items:start;
}

/* CARD */
.card{
    background:white;
    border-radius:24px;
    padding:28px;
    box-shadow:0 20px 40px rgba(0,0,0,.15);
}

/* TITLE */
.title{
    font-size:24px;
    font-weight:700;
    color:#111827;
    margin-bottom:6px;
}

.sub{
    font-size:14px;
    color:#6b7280;
    margin-bottom:25px;
}

/* INPUT */
.group{
    margin-bottom:16px;
}

label{
    display:block;
    font-size:14px;
    font-weight:600;
    margin-bottom:7px;
    color:#374151;
}

input,
select{
    width:100%;
    height:52px;
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:0 15px;
    font-size:15px;
    outline:none;
    transition:.2s;
}

input:focus,
select:focus{
    border-color:#f97316;
    box-shadow:0 0 0 4px rgba(249,115,22,.12);
}

/* BUTTON */
button{
    width:100%;
    height:55px;
    border:none;
    border-radius:14px;
    font-size:16px;
    font-weight:700;
    cursor:pointer;
    color:white;
    background:linear-gradient(90deg,#f97316,#ea580c);
    transition:.3s;
    margin-top:10px;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 14px 25px rgba(249,115,22,.30);
}

/* SIDE CARD */
.summary{
    background:linear-gradient(135deg,#f97316,#ea580c);
    color:white;
    border-radius:24px;
    padding:28px;
    box-shadow:0 20px 40px rgba(0,0,0,.18);
}

.summary h3{
    font-size:22px;
    margin-bottom:18px;
}

.list{
    display:flex;
    justify-content:space-between;
    padding:12px 0;
    border-bottom:1px solid rgba(255,255,255,.15);
    font-size:14px;
}

.badge{
    margin-top:18px;
    padding:12px;
    border-radius:14px;
    background:rgba(255,255,255,.14);
    font-size:14px;
    line-height:1.6;
}

.back{
    display:inline-block;
    margin-top:18px;
    color:white;
    text-decoration:none;
    font-weight:600;
}

/* MOBILE */
@media(max-width:900px){
    .wrapper{
        grid-template-columns:1fr;
    }
}

</style>
</head>

<body>

<div class="wrapper">

    <!-- FORM CHECKOUT -->
    <div class="card">

        <div class="title">🛒 Checkout Pesanan</div>
        <div class="sub">
            Lengkapi data pembelian seperti aplikasi Shopee / marketplace
        </div>

        <form method="POST" action="proses_pesan.php">

            <div class="group">
                <label>Nama Pembeli</label>

                <input
                    type="text"
                    name="nama_pelanggan"
                    value="<?= $_SESSION['user']; ?>"
                    placeholder="Masukkan nama pembeli"
                    required>
            </div>

            <div class="group">
                <label>Pilih Produk</label>

                <select name="nama_barang" required>

                    <option value="">
                        -- Pilih Barang --
                    </option>

                    <?php while ($row = mysqli_fetch_assoc($data)) { ?>

                    <option value="<?= $row['nama_barang']; ?>">

                        <?= $row['nama_barang']; ?>
                        - Rp <?= number_format($row['harga']); ?>

                    </option>

                    <?php } ?>

                </select>
            </div>

            <div class="group">
                <label>Jumlah Pesanan</label>

                <input
                    type="number"
                    name="jumlah_barang"
                    min="1"
                    placeholder="Masukkan jumlah barang"
                    required>
            </div>

            <div class="group">
                <label>Alamat / Kecamatan</label>

                <select name="kecamatan" required>

                    <option value="">
                        -- Pilih Kecamatan --
                    </option>

                    <option>Muara Bangkahulu</option>
                    <option>Pagar Dewa</option>
                    <option>Ratu Agung</option>
                    <option>Ratu Samban</option>
                    <option>Selebar</option>
                    <option>Singaran Pati</option>

                </select>
            </div>

            <button type="submit">
                🚀 Buat Pesanan Sekarang
            </button>

        </form>

    </div>

    <!-- SIDE INFO -->
    <div class="summary">

        <h3>📦 Info Belanja</h3>

        <div class="list">
            <span>Pembayaran</span>
            <span>COD / Cash</span>
        </div>

        <div class="list">
            <span>Pengiriman</span>
            <span>Same Day</span>
        </div>

        <div class="list">
            <span>Keamanan</span>
            <span>100% Aman</span>
        </div>

        <div class="list">
            <span>Support</span>
            <span>24 Jam</span>
        </div>

        <div class="badge">
            🔥 Tips: Pilih kecamatan dengan benar agar ongkir otomatis sesuai dan pesanan cepat diproses.
        </div>

        <a href="barang_user.php" class="back">
            ⬅ Kembali ke Produk
        </a>

    </div>

</div>

</body>
</html>