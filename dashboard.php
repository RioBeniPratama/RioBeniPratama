<?php
// Memulai session
session_start();

// Mengecek apakah pengguna sudah login (session aktif)
if (!isset($_SESSION['user_id'])) {
    // Jika pengguna belum login, arahkan kembali ke halaman login
    header("Location: login.php");
    exit();
}

// Ambil data pengguna dari session
$user_id = $_SESSION['user_id'];  // ID pengguna dari session

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rajawali_motor_sport";  // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil bulan dan tahun yang dipilih dari form (jika ada)
$month = isset($_POST['month']) ? $_POST['month'] : date('m');  // Default bulan adalah bulan saat ini
$year = isset($_POST['year']) ? $_POST['year'] : date('Y');     // Default tahun adalah tahun saat ini

// Query untuk mengambil riwayat booking berdasarkan user_id dan periode (bulan dan tahun)
$sql = "SELECT * FROM bookings WHERE user_id = ? AND MONTH(booking_date) = ? AND YEAR(booking_date) = ? ORDER BY booking_date DESC, booking_time DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $user_id, $month, $year);  // Bind parameter user_id, month, year
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Konsumen - Rajawali Motor Sport</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Raleway:wght@700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f4f4f9;
      margin: 0;
      padding: 0;
    }

    /* Navbar Styling */
    .navbar {
      background: #4d4747;
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
    }
    .navbar .navbar-brand {
      color: #FFD700;
      font-weight: bold;
    }
    .navbar .navbar-brand:hover {
      color: #ffbf00;
    }
    .navbar .btn {
      color: #fff;
      border: 1px solid #FFD700;
      transition: 0.3s;
    }
    .navbar .btn:hover {
      background: #FFD700;
      color: #4d4747;
    }

    /* Sidebar Styling */
    .sidebar {
      width: 250px;
      background: #58574f;
      padding: 20px;
      height: 100vh;
      position: fixed;
      top: 60px; /* Adjusted for navbar height */
      left: 0;
      color: #fff;
    }
    .sidebar h2 {
      font-size: 1.5rem;
      font-weight: bold;
      color: #FFD700;
      margin-bottom: 20px;
    }
    .sidebar a {
      color: #fff;
      font-size: 1.1rem;
      text-decoration: none;
      display: block;
      margin: 10px 0;
      padding: 10px;
      border-radius: 5px;
      transition: 0.3s;
    }
    .sidebar a:hover, .sidebar a.active {
      background-color: #FFD700;
      color: #4d4747;
      font-weight: bold;
      text-shadow: 0 0 5px #FFD700;
    }

    /* Content Styling */
    .content {
      margin-left: 270px; /* Adjusted for sidebar width */
      margin-top: 80px; /* Adjusted for navbar height */
      padding: 20px;
    }
    .content h1, .content h2 {
      color: #4d4747;
      margin-bottom: 20px;
    }
    .content .card {
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }
    .content .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }
    .btn-primary {
      background-color: #FFD700;
      border: none;
      color: #4d4747;
      font-weight: bold;
      transition: 0.3s;
    }
    .btn-primary:hover {
      background-color: #ffbf00;
      color: #322b2c;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Rajawali Motor Sport</a>
      <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </nav>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2>Dashboard Konsumen</h2>
    <a href="#dashboard"><i class="fas fa-user"></i> Dashboard</a>
    <a href="#booking"><i class="fas fa-calendar-alt"></i> Booking</a>
    <a href="#history"><i class="fas fa-history"></i> Riwayat Booking</a>
  </div>

  <!-- Content -->
  <div class="content">
    <!-- Dashboard Section -->
    <section id="dashboard">
      <h1>Selamat Datang, <?php echo $_SESSION['name']; ?></h1>
      <p>Berikut adalah informasi akun Anda:</p>
      <div class="card p-3 mb-4">
        <h5><strong>Nama:</strong> <?php echo $_SESSION['name']; ?></h5><br>
        <h5><strong>Email:</strong> <?php echo $_SESSION['email']; ?></h5><br>
        <h5><strong>Nomor Telepon:</strong> <?php echo $_SESSION['phone']; ?></h5><br>
        <h5><strong>Alamat:</strong> <?php echo $_SESSION['address']; ?></h5><br>
      </div>
    </section>

    <!-- Booking Section -->
    <section id="booking">
    <h2>Booking Servis</h2>
    <form action="proccess_booking.php" method="POST" class="card p-3 mb-4">
        <!-- Tambahkan Hidden Field untuk User ID -->
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">

        <div class="mb-3">
            <label for="motorBrand" class="form-label">Merk Motor</label>
            <input type="text" class="form-control" id="motorBrand" name="motor_brand" required>
        </div>
        <div class="mb-3">
            <label for="motorType" class="form-label">Tipe Motor</label>
            <input type="text" class="form-control" id="motorType" name="motor_type" required>
        </div>
        <div class="mb-3">
            <label for="motorYear" class="form-label">Tahun Motor</label>
            <input type="number" class="form-control" id="motorYear" name="motor_year" required placeholder="Contoh: 2022" min="1900" max="2099">
        </div>
        <div class="mb-3">
            <label for="servicePackage" class="form-label">Paket Servis</label>
            <select class="form-select" id="servicePackage" name="service_package" required>
                <option value="" disabled selected>Pilih Servis</option>
                <option value="Ganti Oli">Ganti Oli</option>
                <option value="Servis Berkala">Servis Berkala</option>
                <option value="Perbaikan Mesin">Perbaikan Mesin</option>
                <option value="Ganti Suku Cadang">Ganti Suku Cadang</option>
                <option value="Cek Kerusakan">Cek Kerusakan</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="bookingDate" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="bookingDate" name="booking_date" required>
        </div>
        <div class="mb-3">
            <label for="bookingTime" class="form-label">Jam</label>
            <select class="form-select" id="bookingTime" name="booking_time" required>
                <option value="" disabled selected>Pilih Jam</option>
                <option value="08:00">08:00</option>
                <option value="09:00">09:00</option>
                <option value="10:00">10:00</option>
                <option value="11:00">11:00</option>
                <option value="12:00">12:00</option>
                <option value="13:00">13:00</option>
                <option value="14:00">14:00</option>
                <option value="15:00">15:00</option>
                <option value="16:00">16:00</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Booking</button>
    </form>
</section>

  <!-- Riwayat Booking Section -->
<section id="history">
  <h2>Riwayat Booking</h2>

  <!-- Filter Form -->
  <form method="POST" class="mb-4">
    <div class="row">
      <div class="col-md-4">
        <label for="month" class="form-label">Bulan</label>
        <select name="month" id="month" class="form-select">
          <option value="1" <?php if ($month == '1') echo 'selected'; ?>>Januari</option>
          <option value="2" <?php if ($month == '2') echo 'selected'; ?>>Februari</option>
          <option value="3" <?php if ($month == '3') echo 'selected'; ?>>Maret</option>
          <option value="4" <?php if ($month == '4') echo 'selected'; ?>>April</option>
          <option value="5" <?php if ($month == '5') echo 'selected'; ?>>Mei</option>
          <option value="6" <?php if ($month == '6') echo 'selected'; ?>>Juni</option>
          <option value="7" <?php if ($month == '7') echo 'selected'; ?>>Juli</option>
          <option value="8" <?php if ($month == '8') echo 'selected'; ?>>Agustus</option>
          <option value="9" <?php if ($month == '9') echo 'selected'; ?>>September</option>
          <option value="10" <?php if ($month == '10') echo 'selected'; ?>>Oktober</option>
          <option value="11" <?php if ($month == '11') echo 'selected'; ?>>November</option>
          <option value="12" <?php if ($month == '12') echo 'selected'; ?>>Desember</option>
        </select>
      </div>

      <div class="col-md-4">
        <label for="year" class="form-label">Tahun</label>
        <select name="year" id="year" class="form-select">
          <option value="2024" <?php if ($year == '2024') echo 'selected'; ?>>2024</option>
          <option value="2023" <?php if ($year == '2023') echo 'selected'; ?>>2023</option>
          <option value="2022" <?php if ($year == '2022') echo 'selected'; ?>>2022</option>
        </select>
      </div>

      <div class="col-md-4">
        <button type="submit" class="btn btn-primary mt-4">Tampilkan</button>
      </div>
    </div>
  </form>

  <!-- Tampilkan Riwayat Booking -->
  <?php if ($result && $result->num_rows > 0): ?>
  <table class="table table-bordered table-hover">
      <thead class="table-dark">
          <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Jam</th>
              <th>Motor</th>
              <th>Paket Servis</th>
              <th>Status</th>
              <th>Aksi</th>
          </tr>
      </thead>
      <tbody>
          <?php
          $no = 1;
          while ($booking = $result->fetch_assoc()): ?>
              <tr>
                  <td><?php echo $no++; ?></td>
                  <td><?php echo date('d M Y', strtotime($booking['booking_date'])); ?></td>
                  <td><?php echo date('H:i', strtotime($booking['booking_time'])); ?></td>
                  <td><?php echo htmlspecialchars($booking['motor_brand'] . ' ' . $booking['motor_type']); ?></td>
                  <td><?php echo htmlspecialchars($booking['service_package']); ?></td>
                  <td>
                      <?php 
                      if ($booking['status'] === 'Pending') {
                          echo 'Pending';
                      } elseif ($booking['status'] === 'Selesai') {
                          echo 'Selesai';
                      } elseif ($booking['status'] === 'Dibatalkan') {
                          echo 'Dibatalkan';
                      }
                      ?>
                  </td>
                  <td>
                      <?php if ($booking['status'] === 'Pending'): ?>
                          <!-- Tombol Batalkan untuk status Pending -->
                          <form action="cancel_booking.php" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan booking ini?');">
                              <input type="hidden" name="booking_id" value="<?php echo htmlspecialchars($booking['id']); ?>">
                              <button type="submit" class="btn btn-danger btn-sm">Batalkan</button>
                          </form>
                      <?php else: ?>
                          <span class="text-muted">Done </span>
                      <?php endif; ?>

                      <!-- Tombol Lihat Nota -->
                      <?php if ($booking['status'] === 'Selesai'): ?>
                          <a href="pembayaran.php?booking_id=<?php echo $booking['id']; ?>" class="btn btn-info btn-sm">Lihat Nota</a>
                      <?php endif; ?>
                  </td>
              </tr>
          <?php endwhile; ?>
      </tbody>
  </table>
  <?php else: ?>
      <p class="text-muted">Tidak ada riwayat booking pada periode ini.</p>
  <?php endif; ?>
</section>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
