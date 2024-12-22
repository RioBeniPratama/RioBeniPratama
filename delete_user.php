<?php
session_start();
include 'db.php';

// Cek apakah parameter 'id' ada
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus user berdasarkan ID
    $sql = "DELETE FROM users WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "User berhasil dihapus!";
        header("Location: dashboard_admin.php"); // Redirect setelah penghapusan
        exit();
    } else {
        echo "Error saat menghapus user: " . $conn->error;
    }
} else {
    echo "ID tidak ada!";
}
?>
