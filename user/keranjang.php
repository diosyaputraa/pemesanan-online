<?php
session_start();

include __DIR__ . '/koneksi_user.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

/* SESSION KERANJANG */
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

/* GANTI LOKASI */
if (isset($_POST['ganti_lokasi'])) {

    $_SESSION['lokasi'] = $_POST['kecamatan'];

    $_SESSION['alert'] = "lokasi";

    header("Location: keranjang.php");
    exit;
}

/* HAPUS ITEM */
if (isset($_GET['hapus'])) {

    $id = $_GET['hapus'];

    unset($_SESSION['keranjang'][$id]);

    $_SESSION['alert'] = "hapus";

    header("Location: keranjang.php");
    exit;
}

/* KOSONGKAN */
if (isset($_GET['kosong'])) {

    $_SESSION['keranjang'] = [];

    $_SESSION['alert'] = "kosong";

    header("Location: keranjang.php");
    exit;
}

$totalBelanja = 0;
?>
<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Keranjang Belanja</title>

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
radial-gradient(circle at top left,#60a5fa 0%,transparent 25%),
radial-gradient(circle at bottom right,#22d3ee 0%,transparent 25%),
linear-gradient(135deg,#0f172a,#1e293b,#0f172a);
}

.container{
max-width:1250px;
margin:auto;
padding:28px;
border-radius:28px;
background:rgba(255,255,255,.10);
border:1px solid rgba(255,255,255,.12);
backdrop-filter:blur(18px);
box-shadow:0 20px 45px rgba(0,0,0,.25);
}

.top{
display:flex;
justify-content:space-between;
align-items:center;
flex-wrap:wrap;
gap:15px;
margin-bottom:25px;
}

.top h1{
color:white;
}

.actions{
display:flex;
gap:10px;
flex-wrap:wrap;
align-items:center;
}

.btn{
padding:12px 16px;
border-radius:14px;
text-decoration:none;
font-size:14px;
font-weight:700;
color:white;
transition:.3s;
cursor:pointer;
border:none;
}

.back{
background:linear-gradient(90deg,#2563eb,#06b6d4);
}

.clear{
background:linear-gradient(90deg,#ef4444,#dc2626);
}

.checkout{
background:linear-gradient(90deg,#16a34a,#22c55e);
}

.btn:hover{
transform:translateY(-2px);
}

select{
padding:12px;
border:none;
border-radius:14px;
min-width:230px;
font-weight:600;
}

.info-lokasi{
color:white;
margin-bottom:18px;
font-weight:600;
}

.table-box{
overflow-x:auto;
}

table{
width:100%;
border-collapse:collapse;
background:white;
border-radius:18px;
overflow:hidden;
}

th{
background:#2563eb;
color:white;
}

th,td{
padding:14px;
text-align:center;
border-bottom:1px solid #eee;
}

tr:hover{
background:#f8fafc;
}

img{
width:75px;
height:75px;
object-fit:cover;
border-radius:12px;
}

.hapus{
padding:9px 12px;
border-radius:10px;
text-decoration:none;
background:#ef4444;
color:white;
font-size:13px;
font-weight:700;
}

.total{
margin-top:22px;
text-align:right;
color:white;
font-size:24px;
font-weight:700;
}

.empty{
text-align:center;
padding:45px;
color:white;
}

.empty h2{
margin-bottom:10px;
}

</style>
</head>

<body>

<div class="container">

<div class="top">

<h1>🛒 Keranjang Belanja</h1>

<div class="actions">

<a href="barang_user.php" class="btn back">
⬅ Kembali
</a>

<button onclick="kosongkanKeranjang()" class="btn clear">
🗑 Kosongkan
</button>

<form action="checkout_keranjang.php" method="POST" style="display:flex; gap:10px; flex-wrap:wrap;">

<select name="kecamatan" required>

<option value="">
📍 Pilih Kecamatan
</option>

<option value="Muara bangkahulu"
<?= (isset($_SESSION['lokasi']) && $_SESSION['lokasi']=="Muara bangkahulu") ? 'selected' : ''; ?>>
Muara bangkahulu - Rp 15.000
</option>

<option value="Ratu Agung"
<?= (isset($_SESSION['lokasi']) && $_SESSION['lokasi']=="Ratu Agung") ? 'selected' : ''; ?>>
Ratu Agung - Rp 20.000
</option>

<option value="Ratu samban"
<?= (isset($_SESSION['lokasi']) && $_SESSION['lokasi']=="Ratu samban") ? 'selected' : ''; ?>>
Ratu samban - Rp 25.000
</option>

<option value="Selebar"
<?= (isset($_SESSION['lokasi']) && $_SESSION['lokasi']=="Selebar") ? 'selected' : ''; ?>>
Selebar - Rp 17.000
</option>

<option value="Pagar Dewa"
<?= (isset($_SESSION['lokasi']) && $_SESSION['lokasi']=="Pagar Dewa") ? 'selected' : ''; ?>>
Pagar Dewa - Rp 13.000
</option>

<option value="Singaran Pati"
<?= (isset($_SESSION['lokasi']) && $_SESSION['lokasi']=="Singaran Pati") ? 'selected' : ''; ?>>
Singaran Pati - Rp 32.000
</option>

</select>

<button type="submit" class="btn checkout">
💳 Checkout
</button>

<button type="submit" name="ganti_lokasi" formaction="keranjang.php" class="btn checkout">
💾 Simpan Lokasi
</button>

</form>

</div>
</div>

<?php if(isset($_SESSION['lokasi'])) { ?>

<div class="info-lokasi">
📍 Lokasi Dipilih : <?= $_SESSION['lokasi']; ?>
</div>

<?php } ?>

<?php if(count($_SESSION['keranjang']) > 0){ ?>

<div class="table-box">

<table>

<tr>
<th>No</th>
<th>Gambar</th>
<th>Barang</th>
<th>Harga</th>
<th>Jumlah</th>
<th>Subtotal</th>
<th>Aksi</th>
</tr>

<?php

$no = 1;

foreach($_SESSION['keranjang'] as $id => $jumlah){

$query = mysqli_query($conn, "
SELECT * FROM barang 
WHERE id='$id'
");

$row = mysqli_fetch_assoc($query);

if(!$row){
    continue;
}

$subtotal = $row['harga'] * $jumlah;

$totalBelanja += $subtotal;

?>

<tr>

<td><?= $no++; ?></td>

<td>
<img src="gambar/<?= $row['gambar']; ?>">
</td>

<td>
<?= $row['nama_barang']; ?>
</td>

<td>
Rp <?= number_format($row['harga']); ?>
</td>

<td>
<?= $jumlah; ?>
</td>

<td>
Rp <?= number_format($subtotal); ?>
</td>

<td>

<a href="#" onclick="hapusItem(<?= $id; ?>)" class="hapus">
Hapus
</a>

</td>

</tr>

<?php } ?>

</table>

</div>

<div class="total">
Total : Rp <?= number_format($totalBelanja); ?>
</div>

<?php } else { ?>

<div class="empty">

<h2>🛒 Keranjang Masih Kosong</h2>

<p>
Silakan pilih barang terlebih dahulu
</p>

</div>

<?php } ?>

</div>

<script>

function hapusItem(id){

Swal.fire({

title:'Hapus barang?',
text:'Barang akan dihapus dari keranjang',
icon:'warning',
showCancelButton:true,
confirmButtonText:'Ya, Hapus',
cancelButtonText:'Batal',
confirmButtonColor:'#ef4444',
cancelButtonColor:'#6b7280'

}).then((result)=>{

if(result.isConfirmed){

window.location='keranjang.php?hapus='+id;

}

});

}

function kosongkanKeranjang(){

Swal.fire({

title:'Kosongkan keranjang?',
text:'Semua barang akan dihapus',
icon:'warning',
showCancelButton:true,
confirmButtonText:'Ya, Kosongkan',
cancelButtonText:'Batal',
confirmButtonColor:'#ef4444',
cancelButtonColor:'#6b7280'

}).then((result)=>{

if(result.isConfirmed){

window.location='keranjang.php?kosong=1';

}

});

}

</script>

<?php if(isset($_SESSION['alert']) && $_SESSION['alert']=="hapus"){ ?>

<script>

Swal.fire({
icon:'success',
title:'Berhasil',
text:'Barang berhasil dihapus',
confirmButtonColor:'#16a34a'
});

</script>

<?php unset($_SESSION['alert']); } ?>

<?php if(isset($_SESSION['alert']) && $_SESSION['alert']=="kosong"){ ?>

<script>

Swal.fire({
icon:'success',
title:'Berhasil',
text:'Keranjang berhasil dikosongkan',
confirmButtonColor:'#16a34a'
});

</script>

<?php unset($_SESSION['alert']); } ?>

<?php if(isset($_SESSION['alert']) && $_SESSION['alert']=="lokasi"){ ?>

<script>

Swal.fire({
icon:'success',
title:'Berhasil',
text:'Lokasi berhasil diganti',
confirmButtonColor:'#16a34a'
});

</script>

<?php unset($_SESSION['alert']); } ?>

<?php if(isset($_SESSION['alert_checkout'])){ ?>

<script>

Swal.fire({
icon:'success',
title:'Checkout Berhasil!',
text:'Pesanan berhasil dibuat',
confirmButtonColor:'#16a34a'
});

</script>

<?php unset($_SESSION['alert_checkout']); } ?>

</body>
</html>