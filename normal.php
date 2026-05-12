<?php
session_start();
unset($_SESSION['reset']);

header("Location: dashboard.php");
exit;
?>