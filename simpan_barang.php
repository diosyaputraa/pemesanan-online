<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config/koneksi.php';

// ambil data
$nama  = $_POST['nama'] ?? '';
$harga = $_POST['harga'] ?? '';

$gambar = $_FILES['gambar']['name'] ?? '';
$tmp    = $_FILES['gambar']['tmp_name'] ?? '';

// validasi dasar
if($nama == '' || $harga == '' || $gambar == ''){
    tampilAlert('error','Data tidak lengkap!','tambah_barang.php');
}

// ambil ekstensi
$ext = pathinfo($gambar, PATHINFO_EXTENSION);
$namaBaru = time() . "." . $ext;

// folder
$folder = __DIR__ . "/gambar/";

// buat folder kalau belum ada
if(!is_dir($folder)){
    mkdir($folder, 0777, true);
}

// upload
if(!move_uploaded_file($tmp, $folder . $namaBaru)){
    tampilAlert('error','Upload gambar gagal!','tambah_barang.php');
}

// simpan DB
$query = mysqli_query($conn, "INSERT INTO barang (nama, harga, gambar) VALUES ('$nama','$harga','$namaBaru')");

if($query){
    tampilAlert('success','Barang berhasil ditambahkan','barang.php');
}else{
    tampilAlert('error','Gagal simpan ke database','tambah_barang.php');
}

// =======================
// FUNCTION ALERT (ANTI ERROR)
// =======================
function tampilAlert($icon,$pesan,$redirect){
    echo "<!DOCTYPE html>
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
    <script>
    Swal.fire({
        icon:'$icon',
        title:'$pesan',
        showConfirmButton:true
    }).then(()=>{
        window.location='$redirect';
    });
    </script>
    </body>
    </html>";
    exit;
}
?>