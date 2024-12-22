<?php
require_once 'db.php'; // Koneksi database

// Ambil ID booking dari URL
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Ambil data booking
    $sql = "SELECT bookings.*, users.name AS customer_name 
            FROM bookings 
            JOIN users ON bookings.user_id = users.id 
            WHERE bookings.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();
} else {
    echo "ID Booking tidak ditemukan.";
    exit;
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kerusakan = $_POST['kerusakan'];
    $suku_cadang = $_POST['suku_cadang'];
    $harga_total = $_POST['harga_total'];

    // Cek jika nota sudah ada, maka update; jika belum, insert baru
    $sql_check_nota = "SELECT * FROM nota WHERE booking_id = ?";
    $stmt_check = $conn->prepare($sql_check_nota);
    $stmt_check->bind_param('i', $booking_id);
    $stmt_check->execute();
    $nota_result = $stmt_check->get_result();

    if ($nota_result->num_rows > 0) {
        // Update nota yang sudah ada
        $sql_update = "UPDATE nota SET kerusakan = ?, suku_cadang = ?, harga = ? WHERE booking_id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param('ssii', $kerusakan, $suku_cadang, $harga_total, $booking_id);
        $stmt_update->execute();
    } else {
        // Insert nota baru
        $sql_insert = "INSERT INTO nota (booking_id, kerusakan, suku_cadang, harga) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param('issi', $booking_id, $kerusakan, $suku_cadang, $harga_total);
        $stmt_insert->execute();
    }

    // Update status booking menjadi selesai
    $sql_update_booking = "UPDATE bookings SET status = 'Selesai' WHERE id = ?";
    $stmt_update_booking = $conn->prepare($sql_update_booking);
    $stmt_update_booking->bind_param('i', $booking_id);
    $stmt_update_booking->execute();

    // Redirect kembali ke dashboard admin
    $_SESSION['message'] = "Nota berhasil diperbarui.";
    header('Location: dashboard_admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Nota - Booking ID: <?php echo $booking_id; ?></title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Kelola Nota - Booking ID: <?php echo $booking_id; ?></h3>
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <!-- Deskripsi Kerusakan -->
                    <div class="mb-3">
                        <label for="kerusakan" class="form-label">Deskripsi Kerusakan</label>
                        <textarea name="kerusakan" id="kerusakan" rows="4" class="form-control" required><?php echo htmlspecialchars($booking['kerusakan'] ?? ''); ?></textarea>
                    </div>

                    <!-- Suku Cadang Diganti -->
                    <div class="mb-3">
                        <label for="suku_cadang" class="form-label">Suku Cadang Diganti</label>
                        <textarea name="suku_cadang" id="suku_cadang" rows="4" class="form-control" required><?php echo htmlspecialchars($booking['suku_cadang'] ?? ''); ?></textarea>
                    </div>

                    <!-- Total Harga -->
                    <div class="mb-3">
                        <label for="harga_total" class="form-label">Total Harga</label>
                        <input type="number" name="harga_total" id="harga_total" class="form-control" required value="<?php echo htmlspecialchars($booking['harga_total'] ?? ''); ?>">
                    </div>

                    <button type="submit" class="btn btn-success">Simpan Nota</button>
                    <a href="dashboard_admin.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
