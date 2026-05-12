<?php
include 'config/koneksi.php';

$q = mysqli_query($conn,"SELECT id FROM pesanan ORDER BY id DESC LIMIT 1");
$d = mysqli_fetch_assoc($q);

echo json_encode([
    "last_id" => $d['id'] ?? 0
]);