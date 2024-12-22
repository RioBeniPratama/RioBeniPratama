<?php
session_start();
include 'db.php';

// Cek apakah user adalah admin
if ($_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit();
}

// Cek apakah ada ID booking yang diterima dari URL
if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];

    // Query untuk mengambil data booking berdasarkan ID dan join dengan tabel users untuk mendapatkan nama konsumen
    $sql_booking = "
        SELECT b.*, u.name AS customer_name 
        FROM bookings b 
        JOIN users u ON b.user_id = u.id 
        WHERE b.id = '$booking_id'
    ";
    $result_booking = $conn->query($sql_booking);
    
    // Cek apakah booking ditemukan
    if ($result_booking->num_rows > 0) {
        $booking = $result_booking->fetch_assoc();
    } else {
        echo "Booking tidak ditemukan.";
        exit();
    }

    // Proses jika form disubmit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $status = $_POST['status']; // Mendapatkan status dari form
        
        // Validasi status yang dipilih
        if ($status == 'Selesai' || $status == 'Pending') {
            // Query untuk update status booking
            $sql_update = "UPDATE bookings SET status = '$status' WHERE id = '$booking_id'";

            if ($conn->query($sql_update)) {
                echo "Status booking berhasil diubah!";
                header("Location: dashboard_admin.php"); // Redirect kembali ke dashboard
                exit();
            } else {
                echo "Error saat mengupdate status: " . $conn->error;
            }
        } else {
            echo "Status tidak valid.";
        }
    }
} else {
    echo "ID booking tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubah Status Booking - Rajawali Motor Sport</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f4f9;
    }
    .container {
      margin-top: 50px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Ubah Status Booking</h2>
    <form method="POST">
      <!-- Form Input Nama Konsumen (menggunakan nama yang diambil dari tabel users) -->
      <div class="mb-3">
        <label for="customer_name" class="form-label">Nama Konsumen</label>
        <input type="text" class="form-control" id="customer_name" value="<?php echo htmlspecialchars($booking['customer_name']); ?>" disabled>
      </div>
      
      <!-- Form Input Tanggal Booking -->
      <div class="mb-3">
        <label for="booking_date" class="form-label">Tanggal Booking</label>
        <input type="text" class="form-control" id="booking_date" value="<?php echo htmlspecialchars($booking['booking_date']); ?>" disabled>
      </div>
      
      <!-- Form Pilihan Status -->
      <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status">
          <option value="Pending" <?php echo ($booking['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
          <option value="Selesai" <?php echo ($booking['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
        </select>
      </div>
      
      <!-- Tombol Update Status -->
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
