<?php
include 'config/koneksi.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: data_pesanan.php");
    exit;
}

$id = (int) $_GET['id'];

// Hapus data
$query = mysqli_query($conn, "DELETE FROM pesanan WHERE id = '$id'");

if ($query) {
    echo "
    <html>
    <head>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data pesanan berhasil dihapus',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'data_pesanan.php';
            });
        </script>
    </body>
    </html>
    ";
} else {
    echo "
    <script>
        alert('Gagal menghapus data');
        window.location.href='data_pesanan.php';
    </script>
    ";
}
?>