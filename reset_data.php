<?php
session_start();

// aktifkan mode reset (hanya tampilan)
$_SESSION['reset'] = true;

header("Location: dashboard.php");
exit;
?>