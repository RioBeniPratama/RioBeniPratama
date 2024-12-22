<?php
// submit_login.php

// Menyertakan file koneksi ke database
include('db.php'); // pastikan db.php sudah ada dengan informasi koneksi database

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menangkap data dari form login
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Menggunakan prepared statements untuk mencegah SQL Injection
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); // Mengikat parameter email

    // Menjalankan query dan mendapatkan hasil
    $stmt->execute();
    $result = $stmt->get_result();

    // Mengecek apakah email ditemukan di database
    if ($result->num_rows > 0) {
        // Mengambil data pengguna
        $user = $result->fetch_assoc();

        // Memeriksa apakah password yang dimasukkan cocok dengan yang ada di database
        if (password_verify($password, $user['password'])) {
            // Jika login berhasil, mulai sesi dan arahkan ke halaman dashboard
            session_start();
            $_SESSION['user_id'] = $user['id']; // Menyimpan ID pengguna ke dalam sesi
            $_SESSION['name'] = $user['name'];  // Menyimpan nama pengguna ke dalam sesi
            $_SESSION['email'] = $user['email']; // Menyimpan email pengguna ke dalam sesi
            $_SESSION['phone'] = $user['phone']; // Menyimpan nomor telepon ke dalam sesi
            $_SESSION['address'] = $user['address']; // Menyimpan alamat ke dalam sesi

            // Mengarahkan pengguna ke halaman dashboard setelah login berhasil
            header("Location: dashboard.php");
            exit();
        } else {
            // Password salah
            echo "<script>alert('Password salah!'); window.location='login.php';</script>";
        }
    } else {
        // Jika email tidak ditemukan
        echo "<script>alert('Email tidak ditemukan!'); window.location='login.php';</script>";
    }

    // Menutup prepared statement
    $stmt->close();
}

// Menutup koneksi
$conn->close();
?>
