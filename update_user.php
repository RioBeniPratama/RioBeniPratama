<?php
session_start();
include 'db.php';

// Pastikan user yang sedang login adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Query untuk memperbarui data user
    $sql = "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $role, $id);

    if ($stmt->execute()) {
        header("Location: dashboard_admin.php"); // Redirect ke halaman admin setelah update
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
