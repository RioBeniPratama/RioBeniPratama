<?php
$servername = "localhost"; // Sesuaikan dengan server Anda
$username = "root";        // Sesuaikan dengan username database Anda
$password = "";            // Sesuaikan dengan password database Anda
$dbname = "rajawali_motor_sport"; // Nama database yang digunakan

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
