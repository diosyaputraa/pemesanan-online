<?php
include __DIR__ . '/koneksi_user.php';

$pesan = "";

if (isset($_POST['daftar'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $email    = $_POST['email'];
    $no_hp    = $_POST['no_hp'];

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    if (mysqli_num_rows($cek) > 0) {
        $pesan = "
        Swal.fire({
            title: 'Oops!',
            text: 'Username sudah digunakan',
            icon: 'warning',
            confirmButtonColor: '#3b82f6'
        });
        ";
    } else {
        mysqli_query($conn, "INSERT INTO users (username, password, email, no_hp) 
                             VALUES ('$username','$password','$email','$no_hp')");

        $pesan = "
        Swal.fire({
            title: 'Berhasil!',
            text: 'Akun berhasil dibuat',
            icon: 'success',
            confirmButtonColor: '#3b82f6'
        }).then(() => {
            window.location='login.php';
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
<title>Daftar User</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
    radial-gradient(circle at bottom right,#22d3ee 0%,transparent 30%),
    linear-gradient(135deg,#0f172a,#1e293b,#0f172a);
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
    background:linear-gradient(135deg,#3b82f6,#06b6d4);
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
.group{
    margin-bottom:16px;
}

.input-box input{
    width:100%;
    height:52px;
    border:none;
    outline:none;
    border-radius:14px;
    padding:0 16px;
    background:rgba(255,255,255,.14);
    color:white;
    font-size:15px;
}

.input-box input::placeholder{
    color:#dbeafe;
}

.input-box input:focus{
    box-shadow:0 0 0 3px rgba(59,130,246,.28);
}

/* Button */
button{
    width:100%;
    height:52px;
    border:none;
    border-radius:14px;
    cursor:pointer;
    font-size:16px;
    font-weight:700;
    color:white;
    margin-top:5px;
    background:linear-gradient(90deg,#2563eb,#06b6d4);
    transition:.3s;
}

button:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 24px rgba(37,99,235,.35);
}

/* Bottom */
.bottom{
    text-align:center;
    margin-top:18px;
    color:#dbeafe;
    font-size:14px;
}

.bottom a{
    color:#fff;
    font-weight:600;
    text-decoration:none;
}

.bottom a:hover{
    text-decoration:underline;
}
</style>
</head>

<body>

<div class="login-box">

    <div class="logo">
        <div class="circle">📝</div>
        <h2>Daftar User</h2>
        <p>Buat akun baru Yoow Store</p>
    </div>

    <form method="POST">

        <div class="group">
            <div class="input-box">
                <input type="text" name="username" placeholder="Masukkan Username" required>
            </div>
        </div>

        <div class="group">
            <div class="input-box">
                <input type="password" name="password" placeholder="Masukkan Password" required>
            </div>
        </div>

        <div class="group">
            <div class="input-box">
                <input type="email" name="email" placeholder="Masukkan Email" required>
            </div>
        </div>

        <div class="group">
            <div class="input-box">
                <input type="text" name="no_hp" placeholder="Masukkan No HP" required>
            </div>
        </div>

        <button type="submit" name="daftar">📝 DAFTAR SEKARANG</button>

    </form>

    <div class="bottom">
        Sudah punya akun?
        <a href="login.php">Login</a>
    </div>

</div>

<?php if ($pesan != ""): ?>
<script>
<?= $pesan; ?>
</script>
<?php endif; ?>

</body>
</html>