<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'config/koneksi.php';

$id = $_GET['id'] ?? '';

if($id == ''){
    tampilAlert('error','ID tidak ditemukan!','barang.php');
}

// ambil data gambar dulu
$data = mysqli_query($conn, "SELECT gambar FROM barang WHERE id='$id'");
$row  = mysqli_fetch_assoc($data);

if($row){
    $gambar = $row['gambar'];

    // hapus file gambar
    $path = __DIR__ . "/gambar/" . $gambar;
    if(file_exists($path)){
        unlink($path);
    }

    // hapus database
    $hapus = mysqli_query($conn, "DELETE FROM barang WHERE id='$id'");

    if($hapus){
        tampilAlert('success','Barang berhasil dihapus','barang.php');
    }else{
        tampilAlert('error','Gagal hapus data','barang.php');
    }
}else{
    tampilAlert('error','Data tidak ditemukan','barang.php');
}

// FUNCTION ALERT
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
        title:'$pesan'
    }).then(()=>{
        window.location='$redirect';
    });
    </script>
    </body>
    </html>";
    exit;
}
?>