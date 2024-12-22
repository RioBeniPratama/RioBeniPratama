<?php
include('db.php'); // Koneksi ke database

// Cek jika booking_id ada di URL
if (isset($_GET['booking_id']) && is_numeric($_GET['booking_id'])) {
    $booking_id = $_GET['booking_id'];

    // Ambil data booking dan nota
    $query = "SELECT bookings.*, users.name AS customer_name, nota.* 
              FROM bookings
              JOIN users ON bookings.user_id = users.id
              LEFT JOIN nota ON bookings.id = nota.booking_id
              WHERE bookings.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        $error_message = "Booking tidak ditemukan.";
    }
} else {
    $error_message = "ID booking tidak valid.";
}

// Proses pembayaran saat form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];
    $payment_status = $_POST['payment_status'];
    $proof_payment = $_FILES['proof_payment']['name'];

    // Cek jika file diunggah
    if ($_FILES['proof_payment']['error'] != UPLOAD_ERR_OK) {
        $error_message = "Error saat mengunggah file: " . $_FILES['proof_payment']['error'];
    } else {
        // Validasi bukti pembayaran jika menggunakan transfer bank
        if ($payment_method == 'Bank Transfer' && !empty($proof_payment)) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["proof_payment"]["name"]);

            // Pastikan file diunggah dengan benar
            if (move_uploaded_file($_FILES["proof_payment"]["tmp_name"], $target_file)) {
                // Debugging: Cek apakah file berhasil di-upload
                echo "File berhasil di-upload: " . $proof_payment . "<br>";

                // Update status pembayaran dengan bukti transfer
                $sql_update = "UPDATE bookings SET payment_status = ?, proof_payment = ? WHERE id = ?";
                $stmt_update = $conn->prepare($sql_update);
                $stmt_update->bind_param('ssi', $payment_status, $proof_payment, $booking_id);
                $stmt_update->execute();
            } else {
                $error_message = "Gagal mengunggah bukti pembayaran.";
            }
        } else if ($payment_method == 'E-wallet' && empty($proof_payment)) {
            // Pembayaran via e-wallet tidak membutuhkan bukti transfer
            $sql_update = "UPDATE bookings SET payment_status = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('si', $payment_status, $booking_id);
            $stmt_update->execute();
        }

        // Jika tidak ada error, redirect ke halaman konfirmasi atau riwayat pembayaran
        if (!isset($error_message)) {
            $_SESSION['message'] = "Pembayaran berhasil diproses.";
            header('Location: dashboard.php');
            exit;
        }
    }
}

?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            margin-top: 30px;
        }
        .form-group {
            margin-top: 15px;
        }
        .payment-details {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .payment-details h5 {
            font-weight: bold;
        }
        .btn-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Proses Pembayaran - Booking ID: <?php echo $booking_id; ?></h3>
        </div>
        <div class="card-body">
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
            <?php else: ?>
                <h4>Detail Booking</h4>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Konsumen</th>
                            <td><?php echo htmlspecialchars($data['customer_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Booking</th>
                            <td><?php echo htmlspecialchars($data['booking_date']); ?></td>
                        </tr>
                        <tr>
                            <th>Deskripsi Kerusakan</th>
                            <td><?php echo htmlspecialchars($data['kerusakan']); ?></td>
                        </tr>
                        <tr>
                            <th>Suku Cadang</th>
                            <td>
                                <?php
                                // Pastikan ada nilai di kolom suku_cadang
                                $suku_cadang = isset($data['suku_cadang']) ? $data['suku_cadang'] : '';

                                if (!empty($suku_cadang)) {
                                    // Pisahkan berdasarkan koma (atau karakter lain jika perlu)
                                    $suku_cadang_list = explode(',', $suku_cadang); 

                                    // Tampilkan tiap item dalam suku cadang per baris
                                    foreach ($suku_cadang_list as $item) {
                                        echo htmlspecialchars(trim($item)) . "<br>"; // Menampilkan tiap item dalam baris baru
                                    }
                                } else {
                                    echo "Tidak ada suku cadang."; // Jika tidak ada data
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Total Harga</th>
                            <td>Rp. <?php echo number_format($data['harga'], 0, ',', '.'); ?></td>
                        </tr>
                    </thead>
                </table>
                    <div class="btn-container">
                        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
                    </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Script untuk menampilkan informasi berdasarkan pilihan metode pembayaran -->
<script>
    document.getElementById('payment_method').addEventListener('change', function() {
        var method = this.value;
        if (method == 'Bank Transfer') {
            document.getElementById('bank-details').style.display = 'block';
            document.getElementById('ewallet-details').style.display = 'none';
        } else if (method == 'E-wallet') {
            document.getElementById('ewallet-details').style.display = 'block';
            document.getElementById('bank-details').style.display = 'none';
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
