<?php
session_start();
include __DIR__ . '/koneksi_user.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

/* TAMBAH KE KERANJANG */
if (isset($_GET['keranjang'])) {
    $id = $_GET['keranjang'];

    if (isset($_SESSION['keranjang'][$id])) {
        $_SESSION['keranjang'][$id]++;
    } else {
        $_SESSION['keranjang'][$id] = 1;
    }

    $_SESSION['alert'] = "tambah";
    header("Location: barang_user.php");
    exit;
}

/* SEARCH */
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

$data = mysqli_query($conn, "SELECT * FROM barang 
WHERE nama_barang LIKE '%$cari%'");

$totalKeranjang = array_sum($_SESSION['keranjang']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fashion Store</title>

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
    padding:25px;
    background:
    radial-gradient(circle at top left,#60a5fa 0%,transparent 25%),
    radial-gradient(circle at bottom right,#22d3ee 0%,transparent 25%),
    linear-gradient(135deg,#0f172a,#1e293b,#0f172a);
}

.container,.ship{
    max-width:1300px;
    margin:auto auto 25px;
    padding:28px;
    border-radius:28px;
    background:rgba(255,255,255,.10);
    border:1px solid rgba(255,255,255,.12);
    backdrop-filter:blur(18px);
    box-shadow:0 20px 45px rgba(0,0,0,.25);
}

.top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
}

.brand{
    display:flex;
    align-items:center;
    gap:14px;
    margin-bottom:12px;
    flex-wrap:wrap;
}

.brand img{
    width:78px;
    height:78px;
    border-radius:50%;
    object-fit:cover;
}

.brand-text h1{
    color:white;
    font-size:30px;
}

.brand-text p{
    color:#cbd5e1;
}

.actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.btn{
    padding:12px 16px;
    border-radius:14px;
    text-decoration:none;
    font-size:14px;
    font-weight:700;
    color:white;
    transition:.3s;
}

.btn:hover{
    transform:translateY(-3px);
}

.cart{
    background:linear-gradient(90deg,#16a34a,#22c55e);
}

.history{
    background:linear-gradient(90deg,#f59e0b,#facc15);
    color:black;
}

.logout{
    background:linear-gradient(90deg,#ef4444,#dc2626);
}

.search-box{
    display:flex;
    gap:10px;
    margin-top:15px;
    flex-wrap:wrap;
}

.search-box input{
    padding:10px;
    border:none;
    border-radius:10px;
    flex:1;
}

.grid{
    max-width:1300px;
    margin:auto;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:22px;
    margin-bottom:25px;
}

.card{
    background:white;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 18px 35px rgba(0,0,0,.15);
    transition:.3s;
}

.card:hover{
    transform:translateY(-8px);
}

.card img{
    width:100%;
    height:250px;
    object-fit:cover;
}

.card-body{
    padding:18px;
}

.title{
    font-size:17px;
    font-weight:700;
    min-height:48px;
}

.price{
    color:#2563eb;
    font-size:22px;
    font-weight:700;
    margin:10px 0;
}

.addcart,.buy{
    display:block;
    width:100%;
    padding:12px;
    text-align:center;
    border-radius:14px;
    text-decoration:none;
    font-weight:700;
    margin-top:10px;
    color:white;
}

.addcart{
    background:linear-gradient(90deg,#16a34a,#22c55e);
}

.buy{
    background:linear-gradient(90deg,#2563eb,#06b6d4);
}
</style>
</head>

<body>

<div class="container">
<div class="top">

<div>
<div class="brand">
<img src="../assets/images/yoow.png">

<div class="brand-text">
<h1>👕 Yoow Store</h1>
<p>Selamat datang, <b><?= $_SESSION['user']; ?></b></p>
</div>
</div>

<form method="GET" class="search-box">
<input type="text" 
name="cari" 
placeholder="Cari produk..." 
value="<?= $cari; ?>">

<button type="submit" class="btn cart">
Cari
</button>
</form>
</div>

<div class="actions">
<a href="keranjang.php" class="btn cart">
🛒 Keranjang (<?= $totalKeranjang; ?>)
</a>

<a href="pesanan_user.php" class="btn history">
📄 Pesanan Saya
</a>

<!-- LOGOUT SWEETALERT -->
<a href="#" onclick="konfirmasiLogout()" class="btn logout">
🚪 Logout
</a>

</div>

</div>
</div>

<div class="grid">

<?php while ($row = mysqli_fetch_assoc($data)) { ?>

<div class="card">

<img src="gambar/<?= $row['gambar']; ?>">

<div class="card-body">

<div class="title">
<?= $row['nama_barang']; ?>
</div>

<div class="price">
Rp <?= number_format($row['harga']); ?>
</div>

<a href="barang_user.php?keranjang=<?= $row['id']; ?>" class="addcart">
➕ Tambah Keranjang
</a>

<a href="./tambah_barang.php?barang=<?= urlencode($row['nama_barang']); ?>" class="buy">
🛍️ Beli Sekarang
</a>

</div>
</div>

<?php } ?>

</div>

<?php if (isset($_SESSION['alert']) && $_SESSION['alert'] == "tambah") { ?>

<script>
Swal.fire({
    icon:'success',
    title:'Berhasil!',
    text:'Barang berhasil ditambahkan ke keranjang',
    confirmButtonColor:'#16a34a'
});
</script>

<?php unset($_SESSION['alert']); } ?>

<!-- SWEETALERT LOGOUT -->
<script>
function konfirmasiLogout(){

    Swal.fire({
        title:'Yakin ingin logout?',
        text:'Sesi login akan berakhir!',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#e74c3c',
        cancelButtonColor:'#3498db',
        confirmButtonText:'Ya, Logout',
        cancelButtonText:'Batal',
        reverseButtons:true

    }).then((result)=>{

        if(result.isConfirmed){

            Swal.fire({
                title:'Berhasil Logout',
                text:'Anda akan keluar...',
                icon:'success',
                timer:1500,
                showConfirmButton:false

            }).then(()=>{

                window.location.href='logout.php';

            });

        }

    });

}
</script>

</body>
</html>