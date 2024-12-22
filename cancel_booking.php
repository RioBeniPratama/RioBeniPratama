<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'rajawali_motor_sport');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah 'booking_id' ada di POST
if (isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];

    // Pastikan booking yang akan dibatalkan masih berstatus 'Pending'
    $stmt = $conn->prepare("SELECT status FROM bookings WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if ($booking && $booking['status'] === 'Pending') {
        // Update status menjadi 'Dibatalkan'
        $stmt = $conn->prepare("UPDATE bookings SET status = 'Dibatalkan' WHERE id = ?");
        $stmt->bind_param("i", $booking_id);
        
        if ($stmt->execute()) {
            // Redirect setelah berhasil
            echo "<script>alert('Booking berhasil dibatalkan!'); window.location.href = 'dashboard.php';</script>";
        } else {
            echo "<script>alert('Gagal membatalkan booking. Silakan coba lagi.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Booking ini sudah tidak dapat dibatalkan.'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
