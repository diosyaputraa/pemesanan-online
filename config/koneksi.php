<?php

$conn = mysqli_connect("localhost", "root", "", "pemesanan_db", 3307);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

?>