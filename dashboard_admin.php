<?php
session_start();
include 'db.php';

// Cek apakah user adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login_admin.php");
    exit();
}

// Ambil data total konsumen
$sql_konsumen = "SELECT COUNT(*) AS total_konsumen FROM users WHERE role = 'user'";
$result_konsumen = $conn->query($sql_konsumen);
$row_konsumen = $result_konsumen->fetch_assoc();
$total_konsumen = $row_konsumen['total_konsumen'];

// Ambil data total booking
$sql_booking = "SELECT COUNT(*) AS total_booking, SUM(CASE WHEN status = 'Selesai' THEN 1 ELSE 0 END) AS total_selesai FROM bookings";
$result_booking = $conn->query($sql_booking);
$row_booking = $result_booking->fetch_assoc();
$total_booking = $row_booking['total_booking'];
$total_selesai = $row_booking['total_selesai'];

// Ambil data laporan booking berdasarkan periode yang dipilih
$periode = isset($_POST['periode']) ? $_POST['periode'] : date('Y-m');
$periode_array = explode('-', $periode);
$tahun = $periode_array[0];
$bulan = $periode_array[1];

// Query untuk laporan booking berdasarkan periode
$sql_laporan = "SELECT COUNT(id) AS total_bookings FROM bookings WHERE YEAR(booking_date) = '$tahun' AND MONTH(booking_date) = '$bulan'";
$result_laporan = $conn->query($sql_laporan);
$laporan = $result_laporan->fetch_assoc();

// Query untuk rincian booking dalam periode yang dipilih
$sql_rincian = "
    SELECT bookings.*, users.name AS customer_name 
    FROM bookings 
    JOIN users ON bookings.user_id = users.id
    WHERE YEAR(booking_date) = '$tahun' AND MONTH(booking_date) = '$bulan'
    ORDER BY booking_date DESC
";
$result_rincian = $conn->query($sql_rincian);

// Tentukan jumlah data per halaman
$limit = 10;  // Menampilkan 10 data per halaman

// Ambil halaman saat ini (jika tidak ada, default ke halaman 1)
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Hitung offset untuk query SQL berdasarkan halaman
$offset = ($page - 1) * $limit;

// Query untuk mengambil total data bookings
$sql_count = "SELECT COUNT(*) AS total FROM bookings";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$total_rows = $row_count['total'];

// Hitung total halaman
$total_pages = ceil($total_rows / $limit);

// Query untuk mengambil data booking sesuai halaman
$sql_booking_detail = "SELECT bookings.*, users.name AS customer_name 
                       FROM bookings 
                       JOIN users ON bookings.user_id = users.id 
                       ORDER BY booking_date DESC 
                       LIMIT $limit OFFSET $offset";
$result_booking_detail = $conn->query($sql_booking_detail);

// Tentukan jumlah data per halaman
$limit = 10;

// Halaman yang sedang aktif (jika tidak ada, set default ke halaman 1)
$page_users = isset($_GET['page_users']) ? (int)$_GET['page_users'] : 1;

// Hitung offset untuk query SQL berdasarkan halaman
$offset = ($page_users - 1) * $limit;

// Query untuk mengambil data user berdasarkan limit dan offset
$sql_users = "SELECT * FROM users LIMIT $limit OFFSET $offset";
$result_users = $conn->query($sql_users);

if ($result_users === false) {
    // Menangani kesalahan query
    echo "Error: " . $conn->error;
}

// Query untuk menghitung jumlah total users
$sql_count_users = "SELECT COUNT(*) AS total FROM users";
$result_count_users = $conn->query($sql_count_users);
if ($result_count_users === false) {
    // Menangani kesalahan query
    echo "Error: " . $conn->error;
    exit;
}

$row_count_users = $result_count_users->fetch_assoc();
$total_users = $row_count_users['total'];

// Menghitung total halaman
$total_pages_users = ceil($total_users / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Rajawali Motor Sport</title>
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

    .sidebar {
      width: 250px;
      background: #58574f;
      padding: 20px;
      height: 100vh;
      position: fixed;
      top: 60px;
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

    .content {
      margin-left: 270px;
      margin-top: 80px;
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

    .pagination {
      justify-content: center;
    }

    /* Styling Tabel */
    .table th, .table td {
      vertical-align: middle;
    }

    .table-striped tbody tr:nth-child(odd) {
      background-color: #f9f9f9;
    }

    .table th {
      background-color: #4d4747;
      color: #fff;
    }

    .table td {
      background-color: #fff;
      color: #333;
    }

    .pagination li.active .page-link {
      background-color: #FFD700;
      border-color: #FFD700;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Rajawali Motor Sport</a>
      <a href="logout_admin.php" class="btn btn-outline-light">Logout</a>
    </div>
  </nav>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2><b>Dashboard</b></h2>
    <a href="#overview"><i class="fas fa-tachometer-alt"></i> Overview</a>
    <a href="#manage-bookings"><i class="fas fa-calendar-check"></i> Manage Bookings</a>
    <a href="#manage-users"><i class="fas fa-users"></i> Manage Users</a>
  </div>

  <!-- Content -->
  <div class="content">
    <!-- Overview Section -->
    <section id="overview">
      <h1>Selamat Datang, Admin</h1>
      <p>Berikut adalah ringkasan aktivitas sistem:</p>
      <div class="card p-3 mb-4">
        <h5><strong>Total Konsumen:</strong> <?php echo $total_konsumen; ?></h5>
        <h5><strong>Total Booking:</strong> <?php echo $total_booking; ?></h5>
        <h5><strong>Booking Selesai:</strong> <?php echo $total_selesai; ?></h5>
      </div>
    </section>

    <!-- Laporan Booking Per Periode -->
    <section id="laporan-booking">
      <h2>Laporan Booking</h2>
      <form method="POST" class="mb-4">
        <div class="row">
          <div class="col-md-6">
            <label for="periode" class="form-label">Pilih Periode</label>
            <input type="month" class="form-control" id="periode" name="periode" value="<?php echo $periode; ?>" required>
          </div>
          <div class="col-md-6">
            <button type="submit" class="btn btn-primary mt-4">Lihat Laporan</button>
          </div>
        </div>
      </form>

     <!-- Rincian booking -->
      <h5><b>Rincian</b></h5>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Konsumen</th>
            <th>Tanggal Booking</th>
            <th>Status</th>
            <th>Biaya</th> <!-- Tambahkan header untuk kolom Biaya -->
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($booking = $result_rincian->fetch_assoc()) {
            // Query untuk mengambil biaya dari tabel nota berdasarkan booking_id
            $sql_biaya = "SELECT harga FROM nota WHERE booking_id = ?";
            $stmt_biaya = $conn->prepare($sql_biaya);
            $stmt_biaya->bind_param('i', $booking['id']);
            $stmt_biaya->execute();
            $result_biaya = $stmt_biaya->get_result();

            // Ambil biaya jika ada
            $biaya = 0; // Default biaya jika nota belum ada
            if ($result_biaya->num_rows > 0) {
                $nota = $result_biaya->fetch_assoc();
                $biaya = $nota['harga'];
            }

            echo "<tr>
                    <td>" . $no++ . "</td>
                    <td>" . $booking['customer_name'] . "</td>
                    <td>" . $booking['booking_date'] . "</td>
                    <td>" . $booking['status'] . "</td>
                    <td>Rp " . number_format($biaya, 2, ',', '.') . "</td> <!-- Tambahkan data Biaya -->
                  </tr>";
          }
          ?>
        </tbody>
      </table>
    </section>

    <!-- Manage Bookings Section -->
    <section id="manage-bookings">
      <h2>Manage Bookings</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Konsumen</th>
            <th>Tanggal Booking</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = $offset + 1;
          while ($booking = $result_booking_detail->fetch_assoc()) {
              echo "
                <tr>
                  <td>" . $no++ . "</td>
                  <td>" . $booking['customer_name'] . "</td>
                  <td>" . $booking['booking_date'] . "</td>
                  <td>" . $booking['status'] . "</td>
                  <td>
                    <a href='update_booking.php?id={$booking['id']}' class='btn btn-primary btn-sm'>Edit</a>
                    <a href='kelola_nota.php?id={$booking['id']}' class='btn btn-secondary btn-sm'>Kelola Nota</a>
                  </td>
                </tr>
              ";
          }
          ?>
        </tbody>
      </table>

      <!-- Pagination -->
      <nav>
        <ul class="pagination">
          <?php
          // Paginate links
          for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li class='page-item " . ($page == $i ? 'active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
          }
          ?>
        </ul>
      </nav>
    </section>


      <!-- Manage Users Section -->
      <section id="manage-users">
        <h2>Manage Users</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama User</th>
              <th>Email</th>
              <th>Role</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = $offset + 1; // Menyesuaikan nomor urut
            while ($user = $result_users->fetch_assoc()) {
                echo "
                  <tr>
                    <td>" . $no++ . "</td>
                    <td>" . $user['name'] . "</td>
                    <td>" . $user['email'] . "</td>
                    <td>" . $user['role'] . "</td>
                    <td><a href='edit_user.php?id={$user['id']}' class='btn btn-primary btn-sm'>Edit</a> 
                        <a href='delete_user.php?id={$user['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
                  </tr>
                ";
            }
            ?>
          </tbody>
        </table>

        <!-- Pagination -->
        <nav>
          <ul class="pagination justify-content-center">
            <?php
            // Menampilkan paginasi
            for ($i = 1; $i <= $total_pages_users; $i++) {
              echo "<li class='page-item " . ($page_users == $i ? 'active' : '') . "'><a class='page-link' href='?page_users=$i'>$i</a></li>";
            }
            ?>
          </ul>
        </nav>
      </section>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
