<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Logout</title>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body{
    margin:0;
    padding:0;
    font-family:Arial, sans-serif;
    background:linear-gradient(135deg,#4facfe,#00f2fe);
}
</style>
</head>
<body>

<script>
Swal.fire({
    title: 'Berhasil Logout!',
    text: 'Anda telah keluar dari sistem.',
    icon: 'success',
    showConfirmButton: false,
    timer: 1800,
    timerProgressBar: true
}).then(() => {
    window.location.href = 'login.php';
});
</script>

</body>
</html>