<?php
include 'config/koneksi.php';

if(isset($_GET['id'])){

    $id = intval($_GET['id']);

    $hapus = mysqli_query($conn, "DELETE FROM kecamatan WHERE id='$id'");

    if($hapus){
        echo "
        <script>
        alert('Lokasi berhasil dihapus');
        window.location='barang.php';
        </script>
        ";
    }else{
        echo "
        <script>
        alert('Gagal hapus lokasi');
        window.location='barang.php';
        </script>
        ";
    }

}else{

    header("Location: barang.php");
    exit;
}
?>