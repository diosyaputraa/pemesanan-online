<?php
include 'config/koneksi.php';

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM barang WHERE id='$id'");
$row = mysqli_fetch_assoc($data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Barang</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* GROUP TOMBOL */
.btn-group {
    display: flex;
    gap: 12px; /* JARAK ANTAR TOMBOL */
    margin-top: 10px;
}

/* OVERRIDE BIAR TIDAK FULL KEBAWAH */
.btn-group .btn {
    width: 50%;
    text-align: center;
}

/* Biar tombol kembali rapi */
.back {
    display: flex;
    justify-content: center;
    align-items: center;
}
* { font-family: 'Poppins', sans-serif; }

body {
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CARD */
.card {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(12px);
    padding: 30px;
    border-radius: 20px;
    width: 400px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    color: white;
}

h2 { text-align: center; }

/* INPUT */
input {
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: none;
    margin-bottom: 15px;
}

/* BUTTON */
.btn {
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
}

.update { background: #facc15; color: black; }
.back { background: #64748b; color: white; margin-top: 10px; }

/* IMAGE */
.preview img {
    width: 120px;
    border-radius: 10px;
    margin-bottom: 10px;
}
</style>
</head>

<body>

<div class="card">

<h2>✏️ Edit Barang</h2>

<form id="formEdit" action="update_barang.php" method="POST" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?= $row['id']; ?>">

<label>Nama Barang</label>
<input type="text" name="nama" value="<?= $row['nama']; ?>" required>

<label>Harga</label>
<input type="number" id="harga" name="harga" value="<?= $row['harga']; ?>" required>

<div class="preview">
    <p>Gambar Saat Ini</p>
    <img id="previewImg" src="gambar/<?= $row['gambar']; ?>">
</div>

<label>Ganti Gambar</label>
<input type="file" id="gambarInput" name="gambar">

<div class="btn-group">
    <button type="submit" class="btn update">💾 Update</button>
    <a href="barang.php" class="btn back">⬅ Kembali</a>
</div>

</form>

</div>

<script>

// 🔥 PREVIEW GAMBAR LANGSUNG
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

// 🔥 VALIDASI HARGA
document.getElementById("formEdit").addEventListener("submit", function(e){
    let harga = document.getElementById("harga").value;

    if(harga <= 0){
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Harga tidak valid!',
            text: 'Harga harus lebih dari 0'
        });
        return;
    }

    // KONFIRMASI UPDATE
    e.preventDefault();

    Swal.fire({
        title: 'Update Barang?',
        text: 'Yakin ingin menyimpan perubahan?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#22c55e',
        cancelButtonColor: '#ef4444',
        confirmButtonText: 'Ya, Update!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});

</script>

</body>
</html>