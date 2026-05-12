<?php
include 'config/koneksi.php';

$data = mysqli_query($conn, "SELECT * FROM pesanan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Data Pesanan</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body{
    background:
    radial-gradient(circle at top left,#1d4ed8,transparent),
    radial-gradient(circle at bottom right,#7c3aed,transparent),
    #020617;
    color:white;
    font-family:'Poppins',sans-serif;
}

.card-pesanan{
    background:rgba(255,255,255,.05);
    backdrop-filter:blur(20px);
    border-radius:25px;
    padding:30px;
    box-shadow:0 15px 40px rgba(0,0,0,.4);
    margin-top:30px;
}

h2{
    background:linear-gradient(90deg,#38bdf8,#a78bfa);
    background-clip:text;
    -webkit-text-fill-color:transparent;
    color:transparent;
}

.table{
    background:white;
    border-radius:15px;
    overflow:hidden;
}

.table thead{
    background:linear-gradient(90deg,#2563eb,#7c3aed);
    color:white;
}

.table tbody tr:hover{
    background:#eef2ff;
}

.badge-status{
    padding:6px 10px;
    border-radius:8px;
    font-size:12px;
    font-weight:bold;
}

.status-proses{
    background:#f59e0b;
    color:white;
}

.btn-back{
    margin-top:20px;
    border-radius:12px;
    padding:10px 15px;
}
</style>
</head>

<body class="p-4">

<h2>📦 Data Pesanan Admin</h2>

<div class="card-pesanan">

<h4 class="text-center mb-4">🔥 Data Pesanan Masuk</h4>

<div class="table-responsive">

<table class="table table-bordered text-dark align-middle">

<thead>
<tr>
<th>Nama</th>
<th>Barang</th>
<th>Jumlah</th>
<th>Total</th>
<th>Kecamatan</th>
<th>Status</th>
<th>Tanggal Pesan</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php while ($row = mysqli_fetch_assoc($data)) { ?>

<tr>

<td><?= htmlspecialchars($row['nama_pelanggan']); ?></td>

<td><?= htmlspecialchars($row['nama_barang']); ?></td>

<td><?= $row['jumlah_barang']; ?></td>

<td>Rp <?= number_format($row['total_biaya']); ?></td>

<td><?= htmlspecialchars($row['kecamatan']); ?></td>

<td>
<span class="badge-status status-proses">Diproses</span>
</td>

<td>
<?= !empty($row['tanggal_pesan']) ? date('d-m-Y H:i', strtotime($row['tanggal_pesan'])) : '-'; ?>
</td>

<td>
<a href="hapus_pesanan.php?id=<?= $row['id']; ?>" 
class="btn btn-danger btn-sm btn-hapus">
Hapus
</a>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>
</div>

<a href="dashboard.php" class="btn btn-secondary btn-back">⬅ Kembali</a>

<script>
document.querySelectorAll('.btn-hapus').forEach(function(button){
button.addEventListener('click', function(e){
e.preventDefault();

const url = this.getAttribute('href');

Swal.fire({
title:'Yakin ingin menghapus?',
text:'Data tidak bisa dikembalikan!',
icon:'warning',
showCancelButton:true,
confirmButtonColor:'#d33',
cancelButtonColor:'#3085d6',
confirmButtonText:'Ya, hapus!',
cancelButtonText:'Batal'
}).then((result)=>{
if(result.isConfirmed){
window.location.href = url;
}
});

});
});
</script>

</body>
</html>