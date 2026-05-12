<?php
session_start();
include 'config/koneksi.php';

$pesan = "";

if (isset($_POST['username'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    $cek   = mysqli_num_rows($query);

    if ($cek > 0) {
        $_SESSION['login'] = true;

        $pesan = "
        Swal.fire({
            title:'Berhasil!',
            text:'Login Admin Berhasil',
            icon:'success',
            confirmButtonColor:'#3b82f6'
        }).then(()=>{
            window.location='dashboard.php';
        });
        ";

    } else {

        $pesan = "
        Swal.fire({
            title:'Gagal!',
            text:'Username atau Password salah!',
            icon:'error',
            confirmButtonColor:'#3b82f6'
        });
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login Admin</title>

<!-- FONT -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="assets/css/style.css">

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
    overflow:hidden;
    background:
    radial-gradient(circle at top left,#60a5fa 0%,transparent 30%),
    radial-gradient(circle at bottom right,#8b5cf6 0%,transparent 30%),
    linear-gradient(135deg,#0f172a,#111827,#020617);
}

/* Bubble */
body::before,
body::after{
    content:'';
    position:absolute;
    width:320px;
    height:320px;
    border-radius:50%;
    background:rgba(255,255,255,.05);
    animation:gerak 8s infinite alternate ease-in-out;
}

body::before{
    top:-100px;
    left:-100px;
}

body::after{
    bottom:-100px;
    right:-100px;
}

@keyframes gerak{
    100%{
        transform:translate(60px,40px);
    }
}

/* Card */
.login-box{
    position:relative;
    z-index:2;
    width:420px;
    padding:38px;
    border-radius:28px;
    background:rgba(255,255,255,.10);
    border:1px solid rgba(255,255,255,.12);
    backdrop-filter:blur(20px);
    box-shadow:0 25px 50px rgba(0,0,0,.35);
    animation:muncul .8s ease;
}

@keyframes muncul{
    from{
        opacity:0;
        transform:translateY(30px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* Logo */
.logo{
    text-align:center;
    margin-bottom:22px;
}

.logo .circle{
    width:78px;
    height:78px;
    border-radius:50%;
    margin:auto;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:34px;
    background:linear-gradient(135deg,#2563eb,#8b5cf6);
    box-shadow:0 0 25px rgba(59,130,246,.45);
}

.logo h2{
    color:white;
    margin-top:14px;
    font-weight:700;
}

.logo p{
    color:#cbd5e1;
    font-size:14px;
}

/* Input */
.form-control{
    height:52px;
    border:none;
    border-radius:14px;
    padding-left:15px;
    background:rgba(255,255,255,.14);
    color:white;
    margin-bottom:15px;
}

.form-control::placeholder{
    color:#dbeafe;
}

.form-control:focus{
    background:rgba(255,255,255,.16);
    color:white;
    box-shadow:0 0 0 3px rgba(59,130,246,.28);
}

/* Button */
.btn-login{
    width:100%;
    height:52px;
    border:none;
    border-radius:14px;
    color:white;
    font-weight:700;
    background:linear-gradient(90deg,#2563eb,#8b5cf6);
    transition:.3s;
}

.btn-login:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 24px rgba(37,99,235,.35);
}

/* Footer */
.footer{
    text-align:center;
    margin-top:18px;
    font-size:13px;
    color:#cbd5e1;
}

/* Mobile */
@media(max-width:500px){
    .login-box{
        width:92%;
        padding:28px;
    }
}
</style>
</head>

<body>

<div class="login-box">

    <div class="logo">
        <div class="circle">🛍️</div>
        <h2>Login Admin</h2>
        <p>Masuk ke Dashboard Yoow Store</p>
    </div>

    <form method="POST">

        <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>

        <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>

        <button type="submit" class="btn-login">
            🔐 LOGIN SEKARANG
        </button>

    </form>

    <div class="footer">
        © <?= date('Y'); ?> Yoow Store Admin Panel
    </div>

</div>

<?php if($pesan != ""): ?>
<script>
<?= $pesan; ?>
</script>
<?php endif; ?>

</body>
</html>