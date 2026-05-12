<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location:index.php");
    exit;
}

include 'config/koneksi.php';

/* ==========================
   TOTAL BARANG
========================== */
$qBarang = mysqli_query($conn, "SELECT COUNT(*) as total FROM barang");
$dBarang = mysqli_fetch_assoc($qBarang);
$total_barang_db = $dBarang['total'] ?? 0;

/* ==========================
   TOTAL PESANAN
========================== */
$qPesanan = mysqli_query($conn, "SELECT COUNT(*) as total FROM pesanan");
$dPesanan = mysqli_fetch_assoc($qPesanan);
$total_pesanan_db = $dPesanan['total'] ?? 0;

/* ==========================
   TOTAL PENJUALAN
========================== */
$qTotal = mysqli_query($conn, "
SELECT SUM(total_biaya) as total
FROM pesanan
");

$dTotal = mysqli_fetch_assoc($qTotal);
$total_penjualan_db = $dTotal['total'] ?? 0;

/* ==========================
   PRODUK TERLARIS
========================== */
$qProduk = mysqli_query($conn, "
SELECT
nama_barang,
SUM(jumlah_barang) as total_terjual
FROM pesanan
GROUP BY nama_barang
ORDER BY total_terjual DESC
LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial, sans-serif;
    min-height:100vh;
    color:white;
    background:
    radial-gradient(circle at top left,#1d4ed8 0%,transparent 30%),
    radial-gradient(circle at bottom right,#7c3aed 0%,transparent 30%),
    linear-gradient(135deg,#0f172a,#111827,#020617);
    overflow-x:hidden;
}

/* LOADER */
#loader{
    position:fixed;
    inset:0;
    background:#020617;
    z-index:99999;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-direction:column;
}

.spin{
    width:70px;
    height:70px;
    border:5px solid rgba(255,255,255,.15);
    border-top:5px solid #38bdf8;
    border-radius:50%;
    animation:putar 1s linear infinite;
}

@keyframes putar{
    100%{
        transform:rotate(360deg);
    }
}

/* LAYOUT */
.wrap{
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:270px;
    min-height:100vh;
    padding:25px;
    background:rgba(255,255,255,.05);
    backdrop-filter:blur(18px);
    border-right:1px solid rgba(255,255,255,.08);
}

.logo{
    text-align:center;
    margin-bottom:32px;
}

.logo img{
    width:95px;
    height:95px;
    object-fit:cover;
    border-radius:50%;
    padding:4px;
    background:rgba(255,255,255,0.95);
    border:3px solid rgba(255,255,255,0.20);
    box-shadow:
        0 0 0 4px rgba(56,189,248,0.12),
        0 12px 25px rgba(0,0,0,0.35),
        0 0 22px rgba(56,189,248,0.35);
    transition:0.35s ease;
}

.logo img:hover{
    transform:scale(1.08) rotate(4deg);
}

.logo h4{
    margin-top:14px;
    font-weight:700;
    font-size:20px;
}

.sidebar a{
    display:block;
    color:white;
    text-decoration:none;
    padding:13px 15px;
    border-radius:14px;
    margin-bottom:10px;
    transition:.3s;
}

.sidebar a:hover{
    background:linear-gradient(90deg,#2563eb,#7c3aed);
    transform:translateX(6px);
}

/* CONTENT */
.content{
    flex:1;
    padding:30px;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
    margin-bottom:25px;
}

.jam{
    background:rgba(255,255,255,.08);
    padding:12px 18px;
    border-radius:14px;
    font-weight:bold;
}

/* CARD */
.card-box{
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.08);
    border-radius:24px;
    padding:25px;
    box-shadow:0 15px 35px rgba(0,0,0,.35);
    transition:.3s;
    position:relative;
    overflow:hidden;
}

.card-box:hover{
    transform:translateY(-8px);
}

.card-box small{
    color:#cbd5e1;
    font-size:14px;
}

.card-box h2{
    font-size:34px;
    margin-top:10px;
    font-weight:bold;
}

/* PANEL */
.panel{
    margin-top:28px;
    background:rgba(255,255,255,.06);
    border-radius:24px;
    padding:25px;
    box-shadow:0 15px 35px rgba(0,0,0,.25);
}

canvas{
    background:white;
    border-radius:18px;
    padding:15px;
}

/* RANK */
.rank{
    display:flex;
    justify-content:space-between;
    padding:13px 0;
    border-bottom:1px solid rgba(255,255,255,.08);
}

/* BUTTON */
.btn-neon{
    border:none;
    color:white;
    padding:10px 16px;
    border-radius:12px;
    background:linear-gradient(90deg,#0ea5e9,#7c3aed);
}

/* DARK MODE */
.dark{
    filter:brightness(.92);
}

/* MOBILE */
@media(max-width:900px){

.wrap{
    flex-direction:column;
}

.sidebar{
    width:100%;
    min-height:auto;
}

}

</style>
</head>

<body>

<!-- Loader -->
<div id="loader">
    <div class="spin"></div>
    <p class="mt-3">Loading Dashboard...</p>
</div>

<div class="wrap">

<!-- Sidebar -->
<div class="sidebar">

    <div class="logo">
        <img src="assets/images/yoow.png">
        <h4>Yoow Store</h4>
    </div>

    <a href="dashboard.php">🏠 Dashboard</a>
    <a href="barang.php">📦 Data Barang</a>
    <a href="data_pesanan.php">🛒 Data Pesanan</a>
    <a href="javascript:void(0)" onclick="darkMode()">🌙 Dark Mode</a>
    <a href="javascript:void(0)" onclick="konfirmasiLogout()">🚪 Logout</a>

</div>

<!-- Content -->
<div class="content">

<div class="topbar">
    <h2>👑 Dashboard Admin</h2>
    <div class="jam" id="jam">00:00:00</div>
</div>

<div class="row g-4">

<div class="col-md-4">
<div class="card-box text-center">
<small>Total Barang</small>
<h2><?= $total_barang_db; ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="card-box text-center">
<small>Total Pesanan</small>
<h2><?= $total_pesanan_db; ?></h2>
</div>
</div>

<div class="col-md-4">
<div class="card-box text-center">
<small>Total Penjualan</small>
<h2>Rp <?= number_format($total_penjualan_db); ?></h2>
</div>
</div>

</div>

<!-- Chart -->
<div class="panel">

<h5 class="mb-3">📈 Statistik Penjualan</h5>

<canvas id="chartBarang"></canvas>

</div>

<!-- Ranking -->
<div class="panel">

<div class="d-flex justify-content-between align-items-center mb-2">
<h5>🏆 Produk Terlaris</h5>
<button class="btn-neon">Live Data</button>
</div>

<?php while($p = mysqli_fetch_assoc($qProduk)) { ?>

<div class="rank">
    <span>🛍️ <?= $p['nama_barang']; ?></span>
    <span><?= $p['total_terjual']; ?> Terjual</span>
</div>

<?php } ?>

</div>

</div>
</div>

<script>

/* LOADER */
window.onload=function(){

setTimeout(()=>{

document.getElementById("loader").style.display="none";

},900);

}

/* JAM */
function waktu(){

let t = new Date();

document.getElementById("jam").innerHTML =
t.toLocaleTimeString('id-ID');

}

setInterval(waktu,1000);
waktu();

/* DARK MODE */
function darkMode(){

document.body.classList.toggle("dark");

}

/* CHART */
const ctx = document.getElementById('chartBarang');

new Chart(ctx,{

type:'line',

data:{

labels:['Barang','Pesanan','Penjualan'],

datasets:[{

label:'Data Dashboard',

data:[
<?= $total_barang_db; ?>,
<?= $total_pesanan_db; ?>,
<?= $total_penjualan_db / 10000; ?>
],

fill:true,
tension:0.4,
borderWidth:3

}]

},

options:{
responsive:true,
plugins:{
legend:{display:true}
}
}

});

/* LOGOUT */
function konfirmasiLogout(){

Swal.fire({

title:'Logout?',
text:'Yakin ingin keluar dari dashboard?',
icon:'warning',
showCancelButton:true,
confirmButtonText:'Ya Logout',
cancelButtonText:'Batal'

}).then((result)=>{

if(result.isConfirmed){

window.location.href='logout.php';

}

});

}

</script>

</body>
</html>