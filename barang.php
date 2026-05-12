<?php
include 'config/koneksi.php';

/* DATA BARANG */
$data = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");

/* DATA KECAMATAN */
$kecamatan = mysqli_query($conn, "SELECT * FROM kecamatan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<title>Data Barang</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:linear-gradient(135deg,#1e3c72,#2a5298);
padding:30px;
color:white;
}

/* TOP BAR */
.top-bar{
margin-bottom:20px;
}

.btn-dashboard{
display:inline-block;
padding:10px 18px;
background:linear-gradient(135deg,#22c55e,#16a34a);
color:white;
border-radius:14px;
text-decoration:none;
font-weight:bold;
box-shadow:0 8px 20px rgba(0,0,0,0.25);
transition:0.3s;
}

.btn-dashboard:hover{
transform:translateY(-3px);
}

/* HEADER */
.header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:25px;
flex-wrap:wrap;
gap:15px;
}

.group-btn{
display:flex;
gap:10px;
flex-wrap:wrap;
}

h2{
font-weight:bold;
}

/* BUTTON */
.btn{
padding:10px 18px;
border-radius:14px;
text-decoration:none;
font-size:14px;
font-weight:bold;
transition:0.3s;
box-shadow:0 8px 18px rgba(0,0,0,0.25);
display:inline-block;
}

.btn:hover{
transform:translateY(-3px) scale(1.03);
}

.tambah{
background:linear-gradient(135deg,#22c55e,#16a34a);
color:white;
}

.edit{
background:#facc15;
color:black;
}

.hapus{
background:#ef4444;
color:white;
}

/* KECAMATAN */
.kecamatan-box{
background:rgba(255,255,255,0.08);
backdrop-filter:blur(10px);
padding:20px;
border-radius:18px;
margin-bottom:25px;
box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

.kecamatan-box h3{
margin-bottom:15px;
}

.kecamatan-grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(180px,1fr));
gap:15px;
}

.kecamatan-card{
background:rgba(255,255,255,0.08);
padding:15px;
border-radius:15px;
text-align:center;
box-shadow:0 8px 20px rgba(0,0,0,0.3);
transition:0.3s;
}

.kecamatan-card:hover{
transform:translateY(-6px);
}

.kecamatan-card h4{
margin-bottom:8px;
font-size:15px;
}

.kecamatan-card p{
font-weight:bold;
color:#a5f3fc;
}

/* GRID BARANG */
.grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(220px,1fr));
gap:20px;
}

/* CARD */
.card{
background:rgba(255,255,255,0.08);
backdrop-filter:blur(10px);
border-radius:18px;
padding:15px;
text-align:center;
box-shadow:0 10px 25px rgba(0,0,0,0.3);
transition:0.3s;
}

.card:hover{
transform:translateY(-8px);
}

.card img{
width:100%;
height:180px;
object-fit:cover;
border-radius:12px;
background:white;
}

.nama{
font-size:16px;
margin-top:10px;
font-weight:bold;
}

.harga{
margin:5px 0;
font-size:14px;
color:#a5f3fc;
}

.aksi{
margin-top:10px;
}

</style>
</head>

<body>

<!-- KEMBALI -->
<div class="top-bar">

<a href="dashboard.php" class="btn-dashboard">
⬅ Kembali ke Dashboard
</a>

</div>

<!-- HEADER -->
<div class="header">

<h2>📦 Data Barang</h2>

<div class="group-btn">

<a href="tambah_barang.php" class="btn tambah">
➕ Tambah Barang
</a>

<a href="tambah_lokasi.php" class="btn lokasi">
📍 Tambah Lokasi
</a>

</div>

</div>

<!-- DATA KECAMATAN -->
<div class="kecamatan-box">

<h3>🚚 Biaya Pengiriman</h3>

<div class="kecamatan-grid">

<?php
if(mysqli_num_rows($kecamatan) > 0){
while($k = mysqli_fetch_assoc($kecamatan)){
?>

<div class="kecamatan-card">

<h4><?= $k['nama_kecamatan']; ?></h4>

<p>
Rp <?= number_format($k['biaya_pengiriman']); ?>
</p>

<div style="margin-top:10px;">

<a href="edit_lokasi.php?id=<?= $k['id']; ?>" class="btn edit">
Edit
</a>

<a href="hapus_lokasi.php?id=<?= $k['id']; ?>" class="btn hapus">
Hapus
</a>

</div>

</div>

<?php
}
}else{
?>

<div style="color:white;">
Belum ada data lokasi
</div>

<?php } ?>

</div>

<!-- DATA BARANG -->
<div class="grid">

<?php while($row = mysqli_fetch_assoc($data)) { ?>

<div class="card">

<img 
src="gambar/<?= $row['gambar']; ?>" 
onerror="this.src='gambar/default.png'"
>

<div class="nama">
<?= $row['nama_barang']; ?>
</div>

<div class="harga">
Rp <?= number_format($row['harga']); ?>
</div>

<div class="aksi">

<a href="edit_barang.php?id=<?= $row['id']; ?>" class="btn edit">
Edit
</a>

<a href="#" onclick="hapus(<?= $row['id']; ?>)" class="btn hapus">
Hapus
</a>

</div>

</div>

<?php } ?>

</div>

<script>

/* HAPUS BARANG */
function hapus(id){

Swal.fire({

title:'Hapus barang?',
text:'Data barang akan dihapus permanen!',
icon:'warning',
showCancelButton:true,
confirmButtonColor:'#22c55e',
cancelButtonColor:'#ef4444',
confirmButtonText:'Ya, hapus!',
cancelButtonText:'Batal'

}).then((result)=>{

if(result.isConfirmed){

Swal.fire({
title:'Berhasil!',
text:'Barang sedang dihapus...',
icon:'success',
timer:1000,
showConfirmButton:false
});

setTimeout(function(){

window.location='hapus_barang.php?id='+id;

},1000);

}

});

}

</script>

</body>
</html> 