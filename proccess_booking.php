<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'rajawali_motor_sport');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah tabel bookings ada
$result = $conn->query("SHOW TABLES LIKE 'bookings'");
if ($result->num_rows == 0) {
    die("Tabel 'bookings' tidak ditemukan di database.");
}

// Periksa apakah kolom yang dibutuhkan ada dalam tabel bookings
$columns = ['user_id', 'motor_brand', 'motor_type', 'motor_year', 'service_package', 'booking_date', 'booking_time', 'status'];
foreach ($columns as $column) {
    $check_column = $conn->query("SHOW COLUMNS FROM bookings LIKE '$column'");
    if ($check_column->num_rows == 0) {
        die("Kolom '$column' tidak ditemukan dalam tabel 'bookings'.");
    }
}

// Periksa apakah form telah dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging: Cetak semua data POST untuk memastikan form mengirim data
    echo "<pre>";
    print_r($_POST); // Hapus ini jika sudah berhasil
    echo "</pre>";

    // Ambil data dari form dan pastikan semua terisi
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';  // Ambil user_id dari session atau form
    $motor_brand = isset($_POST['motor_brand']) ? trim($_POST['motor_brand']) : '';
    $motor_type = isset($_POST['motor_type']) ? trim($_POST['motor_type']) : '';
    $motor_year = isset($_POST['motor_year']) ? trim($_POST['motor_year']) : '';
    $service_package = isset($_POST['service_package']) ? trim($_POST['service_package']) : '';
    $booking_date = isset($_POST['booking_date']) ? trim($_POST['booking_date']) : '';
    $booking_time = isset($_POST['booking_time']) ? trim($_POST['booking_time']) : '';

    // Validasi: Pastikan semua data terisi
    if (empty($user_id) || empty($motor_brand) || empty($motor_type) || empty($motor_year) || empty($service_package) || empty($booking_date) || empty($booking_time)) {
        die("Semua data harus diisi.");
    }

    // Validasi tambahan (opsional): Pastikan format data valid
    if (!preg_match('/^\d{4}$/', $motor_year) || $motor_year < 1900 || $motor_year > date('Y')) {
        die("Tahun motor tidak valid.");
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $booking_date)) {
        die("Format tanggal tidak valid.");
    }

    if (!preg_match('/^\d{2}:\d{2}$/', $booking_time)) {
        die("Format waktu tidak valid.");
    }

    // Cek apakah waktu booking sudah penuh
    $sql_check_time = "SELECT COUNT(*) AS total FROM bookings WHERE booking_date = ? AND booking_time = ?";
    $stmt = $conn->prepare($sql_check_time);
    if (!$stmt) {
        die("Error prepare statement untuk pengecekan waktu: " . $conn->error);
    }
    $stmt->bind_param("ss", $booking_date, $booking_time);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['total'] > 0) {
        echo "<script>alert('Jam ini sudah dipesan! Silakan pilih jam lain.'); window.history.back();</script>";
        exit();
    }

    // Cek apakah total booking untuk tanggal tersebut sudah mencapai 5
    $sql_check_day = "SELECT COUNT(*) AS total FROM bookings WHERE booking_date = ?";
    $stmt = $conn->prepare($sql_check_day);
    if (!$stmt) {
        die("Error prepare statement untuk pengecekan kuota: " . $conn->error);
    }
    $stmt->bind_param("s", $booking_date);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['total'] >= 5) {
        echo "<script>alert('Kuota booking untuk hari ini sudah penuh!'); window.history.back();</script>";
        exit();
    }

    // Simpan data booking
    $sql_insert = "INSERT INTO bookings (user_id, motor_brand, motor_type, motor_year, service_package, booking_date, booking_time, status) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";
    $stmt = $conn->prepare($sql_insert);
    if (!$stmt) {
        die("Error prepare statement untuk insert data booking: " . $conn->error);
    }
    $stmt->bind_param("issssss", $user_id, $motor_brand, $motor_type, $motor_year, $service_package, $booking_date, $booking_time);

    if ($stmt->execute()) {
        echo "<script>alert('Booking berhasil dibuat!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal membuat booking. Silakan coba lagi.'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
