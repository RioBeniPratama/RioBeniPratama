<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Halaman Konsumen - Rajawali Motor Sport</title>
  <link rel="stylesheet" href="style.css"> <!-- Ganti dengan file CSS halaman awal untuk desain konsisten -->
</head>
<body>
  <header>
    <h1>Rajawali Motor Sport</h1>
    <nav>
      <ul>
        <li><a href="#" onclick="showSection('dashboard')">Dashboard</a></li>
        <li><a href="#" onclick="showSection('booking')">Booking</a></li>
        <li><a href="#" onclick="showSection('riwayat')">Riwayat Booking</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <!-- Dashboard Section -->
    <section id="dashboard" class="content-section">
      <h2>Profil Konsumen</h2>
      <div id="profilKonsumen">
        <?php
          // Mengambil data konsumen dari database berdasarkan session ID konsumen
          include 'db.php';
          session_start();
          $user_id = $_SESSION['user_id']; // Menggunakan session ID setelah login
          $query = "SELECT username, email, phone FROM konsumen WHERE id = '$user_id'";
          $result = mysqli_query($conn, $query);
          if ($row = mysqli_fetch_assoc($result)) {
            echo "<p><strong>Username:</strong> " . $row['username'] . "</p>";
            echo "<p><strong>Email:</strong> " . $row['email'] . "</p>";
            echo "<p><strong>No. HP:</strong> " . $row['phone'] . "</p>";
          }
        ?>
      </div>
    </section>

    <!-- Booking Section -->
    <section id="booking" class="content-section" style="display: none;">
      <h2>Form Booking Servis</h2>
      <form action="prosesBooking.php" method="post">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" required>

        <label for="merkMotor">Merk Motor:</label>
        <input type="text" id="merkMotor" name="merkMotor" required>

        <label for="tipeMotor">Tipe Motor:</label>
        <input type="text" id="tipeMotor" name="tipeMotor" required>

        <label for="tahunMotor">Tahun Motor:</label>
        <input type="text" id="tahunMotor" name="tahunMotor" required>

        <label for="paketServis">Paket Servis:</label>
        <select id="paketServis" name="paketServis">
          <option value="service1">Service 1</option>
          <option value="service2">Service 2</option>
          <option value="service3">Service 3</option>
        </select>

        <label for="tanggal">Tanggal:</label>
        <input type="date" id="tanggal" name="tanggal" required>

        <label for="jam">Jam:</label>
        <input type="time" id="jam" name="jam" required>

        <button type="submit">Kirim</button>
      </form>
    </section>

    <!-- Riwayat Booking Section -->
    <section id="riwayat" class="content-section" style="display: none;">
      <h2>Riwayat Booking</h2>
      <table>
        <thead>
          <tr>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Merk Motor</th>
            <th>Tipe Motor</th>
            <th>Tahun Motor</th>
            <th>Paket Servis</th>
            <th>Jam</th>
          </tr>
        </thead>
        <tbody>
          <?php
            // Mengambil data riwayat booking dari database
            $query = "SELECT tanggal, nama, merkMotor, tipeMotor, tahunMotor, paketServis, jam FROM booking WHERE user_id = '$user_id' ORDER BY tanggal DESC";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $row['tanggal'] . "</td>";
              echo "<td>" . $row['nama'] . "</td>";
              echo "<td>" . $row['merkMotor'] . "</td>";
              echo "<td>" . $row['tipeMotor'] . "</td>";
              echo "<td>" . $row['tahunMotor'] . "</td>";
              echo "<td>" . $row['paketServis'] . "</td>";
              echo "<td>" . $row['jam'] . "</td>";
              echo "</tr>";
            }
          ?>
        </tbody>
      </table>
    </section>
  </main>

  <script>
    // JavaScript untuk navigasi antar section
    function showSection(sectionId) {
      document.querySelectorAll(".content-section").forEach(section => {
        section.style.display = section.id === sectionId ? "block" : "none";
      });
    }
  </script>
</body>
</html>
