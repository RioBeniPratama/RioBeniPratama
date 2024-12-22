<?php
// Mulai sesi
session_start();

// Hapus semua data sesi
session_unset();
session_destroy();

// Redirect ke halaman login admin
header("Location: login_admin.php");
exit();
?>
