<?php
session_start();
include 'db.php'; // Pastikan Anda menyertakan file koneksi database

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form login
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Query untuk cek admin berdasarkan email
    $sql = "SELECT * FROM users WHERE email = ? AND role = 'admin'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika admin ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password dengan MD5
        if (md5($password) === $user['password']) {
            // Set session untuk login
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            // Redirect ke dashboard admin
            header("Location: dashboard_admin.php");
            exit();
        } else {
            // Password salah
            $_SESSION['error'] = "Password salah!";
            header("Location: login_admin.php");
            exit();
        }
    } else {
        // Email tidak ditemukan
        $_SESSION['error'] = "Email tidak ditemukan!";
        header("Location: login_admin.php");
        exit();
    }
}
?>
