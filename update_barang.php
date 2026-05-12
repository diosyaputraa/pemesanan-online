<?php
include 'config/koneksi.php';

// 🔥 tampilkan error kalau ada (biar tidak putih)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// validasi
if(!isset($_POST['id'])){
    echo "Akses tidak valid!";
    exit;
}

$id    = intval($_POST['id']);
$nama  = mysqli_real_escape_string($conn, $_POST['nama']);
$harga = intval($_POST['harga']);

// ambil data lama
$data = mysqli_query($conn, "SELECT * FROM barang WHERE id='$id'");
$row  = mysqli_fetch_assoc($data);

if(!$row){
    echo "Data tidak ditemukan!";
    exit;
}

$gambarLama = $row['gambar'];
$folder = "images/";

// =======================
// PROSES GAMBAR
// =======================
if(isset($_FILES['gambar']) && $_FILES['gambar']['name'] != ""){

    $namaFile = $_FILES['gambar']['name'];
    $tmp      = $_FILES['gambar']['tmp_name'];

    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png'];

    if(!in_array($ext, $allowed)){
        tampilAlert('error','Format salah','Harus JPG / PNG');
        exit;
    }

    $namaBaru = time().'_'.rand(100,999).'.'.$ext;

    if(move_uploaded_file($tmp, $folder.$namaBaru)){

        // hapus lama
        if($gambarLama && file_exists($folder.$gambarLama)){
            unlink($folder.$gambarLama);
        }

        $update = mysqli_query($conn, "UPDATE barang SET
            nama='$nama',
            harga='$harga',
            gambar='$namaBaru'
            WHERE id='$id'");

    } else {
        tampilAlert('error','Upload gagal','Gagal upload gambar');
        exit;
    }

} else {

    // tanpa ganti gambar
    $update = mysqli_query($conn, "UPDATE barang SET
        nama='$nama',
        harga='$harga'
        WHERE id='$id'");
}

// =======================
// HASIL
// =======================
if($update){
    tampilAlert('success','Berhasil','Data berhasil diupdate');
} else {
    tampilAlert('error','Gagal','Terjadi kesalahan saat update');
}


// =======================
// FUNCTION SWEETALERT
// =======================
function tampilAlert($icon,$title,$text){
    echo "
    <html>
    <head>
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
    <script>
    Swal.fire({
        icon: '$icon',
        title: '$title',
        text: '$text'
    }).then(()=>{
        window.location='barang.php';
    });
    </script>
    </body>
    </html>
    ";
}
?>