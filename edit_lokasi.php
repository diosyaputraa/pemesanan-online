<?php
include 'config/koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM kecamatan WHERE id='$id'");
$d = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<title>Edit Lokasi</title>

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
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

.card{
    width:430px;
    background:rgba(255,255,255,0.10);
    backdrop-filter:blur(15px);
    border-radius:22px;
    padding:30px;
    color:white;
    box-shadow:0 15px 35px rgba(0,0,0,0.30);
    animation:fade .5s ease;
}

@keyframes fade{
    from{
        opacity:0;
        transform:translateY(25px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

h2{
    text-align:center;
    margin-bottom:25px;
    font-size:24px;
}

label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    font-weight:600;
}

input{
    width:100%;
    padding:12px 14px;
    border:none;
    outline:none;
    border-radius:12px;
    margin-bottom:18px;
    font-size:14px;
}

.btn{
    width:100%;
    padding:13px;
    border:none;
    border-radius:14px;
    font-weight:bold;
    cursor:pointer;
    transition:.3s;
    text-decoration:none;
    display:block;
    text-align:center;
}

.btn:hover{
    transform:translateY(-2px);
}

.simpan{
    background:linear-gradient(135deg,#22c55e,#16a34a);
    color:white;
}

.kembali{
    margin-top:10px;
    background:linear-gradient(135deg,#64748b,#475569);
    color:white;
}
</style>
</head>

<body>

<div class="card">

<h2>📍 Edit Lokasi</h2>

<form id="formEdit" action="simpan_edit_lokasi.php" method="POST">

<input type="hidden" name="id" value="<?= $d['id']; ?>">

<label>Nama Kecamatan</label>
<input type="text" name="nama_kecamatan" value="<?= $d['nama_kecamatan']; ?>" required>

<label>Biaya Pengiriman</label>
<input type="number" name="biaya_pengiriman" value="<?= $d['biaya_pengiriman']; ?>" required>

<button type="submit" class="btn simpan">💾 Simpan Perubahan</button>

<a href="barang.php" class="btn kembali">⬅ Kembali</a>

</form>

</div>

<script>
document.getElementById("formEdit").addEventListener("submit", function(e){

    e.preventDefault();

    Swal.fire({
        title:'Simpan perubahan?',
        text:'Data lokasi akan diperbarui',
        icon:'question',
        showCancelButton:true,
        confirmButtonColor:'#22c55e',
        cancelButtonColor:'#ef4444',
        confirmButtonText:'Ya, simpan!',
        cancelButtonText:'Batal'
    }).then((result)=>{
        if(result.isConfirmed){
            this.submit();
        }
    });

});
</script>

</body>
</html>