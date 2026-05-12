<?php
session_start();
include 'config/koneksi.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_login'])) {
    header("Location: login_user.php");
    exit;
}

// Ambil data barang dan kecamatan dari database
$barang = mysqli_query($conn, "SELECT * FROM barang");
$kecamatan = mysqli_query($conn, "SELECT * FROM kecamatan");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pemesanan Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body style="background: linear-gradient(135deg, #74ebd5, #ACB6E5);">

<nav class="navbar navbar-dark bg-primary px-4">
    <span class="navbar-brand">Pemesanan Barang</span>
    <a href="dashboard_user.php" class="btn btn-light btn-sm">Kembali</a>
</nav>

<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h3 class="text-center mb-4">Form Pemesanan</h3>
        <form action="proses.php" method="POST">
            <!-- Nama Pelanggan -->
            <div class="mb-3">
                <label>Nama Pelanggan</label>
                <input type="text" name="nama_pelanggan" class="form-control"
                       value="<?php echo $_SESSION['username']; ?>" readonly>
            </div>

            <!-- Pilih Barang -->
            <div class="mb-3">
                <label>Pilih Barang</label>
                <select name="barang_id" class="form-control" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php while ($b = mysqli_fetch_assoc($barang)) { ?>
                        <option value="<?php echo $b['id']; ?>">
                            <?php echo $b['nama']; ?> - Rp. <?php echo number_format($b['harga'],0,',','.'); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Jumlah Barang -->
            <div class="mb-3">
                <label>Jumlah Barang</label>
                <input type="number" name="jumlah_barang" class="form-control" min="1" required>
            </div>

            <!-- Pilih Kecamatan -->
            <div class="mb-3">
                <label>Pilih Kecamatan</label>
                <select name="kecamatan_id" class="form-control" required>
                    <option value="">-- Pilih Kecamatan --</option>
                    <?php while ($k = mysqli_fetch_assoc($kecamatan)) { ?>
                        <option value="<?php echo $k['id']; ?>">
                            <?php echo $k['nama_kecamatan']; ?> - Ongkir Rp. <?php echo number_format($k['biaya_pengiriman'],0,',','.'); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <button type="submit" name="submit" class="btn btn-success w-100">
                Pesan Sekarang
            </button>
        </form>
    </div>
</div>

</body>
</html>