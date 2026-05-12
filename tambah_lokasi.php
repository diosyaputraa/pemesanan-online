<?php
include 'config/koneksi.php';

if(isset($_POST['simpan'])){

    $nama_kecamatan   = $_POST['nama_kecamatan'];
    $biaya_pengiriman = $_POST['biaya_pengiriman'];

    mysqli_query($conn,"
    INSERT INTO kecamatan
    (
        nama_kecamatan,
        biaya_pengiriman
    )
    VALUES
    (
        '$nama_kecamatan',
        '$biaya_pengiriman'
    )
    ");

    echo "
    <script>
    alert('Lokasi berhasil ditambahkan');
    window.location='barang.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Lokasi</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
min-height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#1e3c72,#2a5298);
padding:20px;
}

.card{
width:420px;
background:white;
padding:30px;
border-radius:20px;
box-shadow:0 10px 30px rgba(0,0,0,0.3);
}

h2{
margin-bottom:20px;
text-align:center;
}

.input{
margin-bottom:15px;
}

.input label{
display:block;
margin-bottom:6px;
font-weight:bold;
}

.input input{
width:100%;
height:50px;
padding:10px;
border:1px solid #ddd;
border-radius:12px;
}

button{
width:100%;
height:50px;
border:none;
border-radius:12px;
background:linear-gradient(135deg,#3b82f6,#2563eb);
color:white;
font-weight:bold;
cursor:pointer;
font-size:15px;
}

button:hover{
opacity:.9;
}

.back{
display:block;
text-align:center;
margin-top:15px;
text-decoration:none;
font-weight:bold;
color:#2563eb;
}

</style>
</head>

<body>

<div class="card">

<h2>📍 Tambah Lokasi</h2>

<form method="POST">

<div class="input">
<label>Nama Kecamatan</label>
<input type="text" name="nama_kecamatan" required>
</div>

<div class="input">
<label>Biaya Pengiriman</label>
<input type="number" name="biaya_pengiriman" required>
</div>

<button type="submit" name="simpan">
💾 Simpan Lokasi
</button>

</form>

<a href="barang.php" class="back">
⬅ Kembali
</a>

</div>

</body>
</html>