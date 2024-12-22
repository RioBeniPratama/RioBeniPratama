<?php
// submit_register.php

// Menyertakan file koneksi ke database
include('db.php'); // pastikan db.php sudah ada dengan informasi koneksi database

// Memeriksa apakah form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menangkap data dari form registrasi
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Password yang dimasukkan oleh pengguna
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Mengenkripsi password menggunakan password_hash() untuk keamanan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Menggunakan prepared statements untuk mencegah SQL Injection
    $sql = "INSERT INTO users (name, email, password, phone, address, role) 
            VALUES (?, ?, ?, ?, ?, 'user')";

    // Menyiapkan query
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $address); // Mengikat parameter

    // Menjalankan query dan memeriksa apakah berhasil
    if ($stmt->execute()) {
        // Jika registrasi berhasil, arahkan ke halaman login
        header("Location: login.php");
        exit();
    } else {
        // Menampilkan pesan error jika terjadi masalah saat eksekusi query
        echo "Error: " . $stmt->error;
    }

    // Menutup prepared statement
    $stmt->close();
}

// Menutup koneksi
$conn->close();
?>
