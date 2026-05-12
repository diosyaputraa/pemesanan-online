<?php include 'config/koneksi.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Barang Premium</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
* { font-family:'Poppins'; }

body{
    background: linear-gradient(135deg,#1e3c72,#2a5298);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(15px);
    padding:30px;
    border-radius:20px;
    width:380px;
    color:white;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
    animation: fade 0.6s ease;
}

@keyframes fade{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

h2{text-align:center; margin-bottom:20px;}

input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border-radius:10px;
    border:none;
}

/* PREVIEW */
.preview{
    text-align:center;
}

.preview img{
    width:120px;
    border-radius:12px;
    margin-bottom:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.3);
}

/* BUTTON */
.btn{
    width:100%;
    padding:12px;
    border:none;
    border-radius:12px;
    font-weight:bold;
    cursor:pointer;
}

.simpan{
    background: linear-gradient(135deg,#22c55e,#16a34a);
    color:white;
}

.back{
    margin-top:10px;
    background: linear-gradient(135deg,#64748b,#475569);
    color:white;
    text-decoration:none;
    display:block;
    text-align:center;
}
</style>
</head>

<body>

<div class="card">

<h2>➕ Tambah Barang</h2>

<form id="formTambah" action="simpan_barang.php" method="POST" enctype="multipart/form-data">

<input type="text" name="nama" id="nama" placeholder="Nama Barang">

<input type="number" name="harga" id="harga" placeholder="Harga">

<div class="preview">
    <img id="previewImg" src="gambar/default.png">
</div>

<input type="file" id="gambarInput" name="gambar">

<button type="submit" class="btn simpan">Simpan</button>
<a href="barang.php" class="back">⬅ Kembali</a>

</form>

</div>

<script>
// PREVIEW GAMBAR
document.getElementById("gambarInput").addEventListener("change", function(e){
    const file = e.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){
            document.getElementById("previewImg").src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

// VALIDASI + KONFIRMASI
document.getElementById("formTambah").addEventListener("submit", function(e){
    let nama = document.getElementById("nama").value;
    let harga = document.getElementById("harga").value;
    let gambar = document.getElementById("gambarInput").files.length;

    if(nama === "" || harga === "" || gambar === 0){
        e.preventDefault();
        Swal.fire({
            icon:'error',
            title:'Data belum lengkap!',
            text:'Semua field wajib diisi'
        });
        return;
    }

    if(harga <= 0){
        e.preventDefault();
        Swal.fire({
            icon:'error',
            title:'Harga tidak valid'
        });
        return;
    }

    e.preventDefault();

    Swal.fire({
        title:'Simpan barang?',
        icon:'question',
        showCancelButton:true,
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