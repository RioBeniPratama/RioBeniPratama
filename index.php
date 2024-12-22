<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rajawali Motor Sport</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Raleway:wght@700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">
</head>
<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container">
      <!-- Logo di sebelah kiri -->
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="image/Logo.png" alt="Logo" class="me-2"> <!-- Ganti dengan logo Anda -->
        Rajawali Motor Sport
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="#Home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#services">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#register">Register</a>
          </li>
        </ul>
        <a href="login.php" class="btn btn-outline-light ms-3">Login</a>
      </div>
    </div>
  </nav>
  
  <!-- Hero Section -->
  <section id="Home" class="hero d-flex align-items-center">
    <div class="container text-center text-white">
      <h1 class="hero-title animate__animated animate__zoomIn">Selamat Datang di <br> Rajawali Motor Sport</h1>
      <p class="hero-subtitle animate__animated animate__fadeIn animate__delay-1s">Solusi servis motor cepat dan profesional untuk Anda</p>
      <a href="#services" class="btn btn-warning btn-book animate__animated animate__bounceInUp animate__delay-2s">Lihat Layanan Kami</a>
    </div>
  </section>

  <!-- Service Section -->
  <section id="services" class="services py-5">
    <div class="container">
      <h2 class="text-center mb-4 section-title animate__animated animate__fadeIn">Service</h2>
      <div class="row text-center d-flex justify-content-center">
        <div class="col-md-2 col-sm-4">
          <div class="service-item p-4 shadow rounded animate__animated animate__fadeInUp animate__delay-1s">
            <img src="image/img-12.png" alt="Servis Berkala" class="mb-3 img-fluid rounded-circle">
            <h3>Servis Berkala</h3>
            <p>Perawatan rutin agar motor Anda selalu dalam kondisi prima.</p>
          </div>
        </div>
        <div class="col-md-2 col-sm-4">
          <div class="service-item p-4 shadow rounded animate__animated animate__fadeInUp animate__delay-2s">
            <img src="image/img-13.png" alt="Penggantian Suku Cadang" class="mb-3 img-fluid rounded-circle">
            <h3>Penggantian Suku Cadang</h3>
            <p>Suku cadang asli dan berkualitas untuk performa terbaik.</p>
          </div>
        </div>
        <div class="col-md-2 col-sm-4">
          <div class="service-item p-4 shadow rounded animate__animated animate__fadeInUp animate__delay-3s">
            <img src="image/img-14.png" alt="Perbaikan Mesin" class="mb-3 img-fluid rounded-circle">
            <h3>Perbaikan Mesin</h3>
            <p>Perbaikan mesin untuk semua jenis motor.</p>
          </div>
        </div>
        <div class="col-md-2 col-sm-4">
          <div class="service-item p-4 shadow rounded animate__animated animate__fadeInUp animate__delay-4s">
            <img src="image/img-11.png" alt="Ganti Oli" class="mb-3 img-fluid rounded-circle">
            <h3>Ganti Oli</h3>
            <p>Ganti oli untuk menjaga kinerja mesin motor Anda tetap optimal.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimoni Section -->
  <section id="testimonials" class="testimonials bg-light py-5">
    <div class="container text-center">
      <h2 class="section-title mb-4 animate__animated animate__fadeIn">Kenapa Harus Disini?</h2>
      <div class="row">
        <div class="col-md-4">
          <div class="testimonial-item shadow-lg p-4 mb-4 rounded animate__animated animate__fadeInUp animate__delay-1s">
            <img src="image/img-15.jpg" alt="Andi" class="img-fluid mb-3 rounded-circle">
            <p>"Layanan yang sangat memuaskan, mekanik yang handal dan profesional!"</p>
            <p><strong>- Andi, Palembang</strong></p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="testimonial-item shadow-lg p-4 mb-4 rounded animate__animated animate__fadeInUp animate__delay-2s">
            <img src="image/img-17.jpg" alt="Rina" class="img-fluid mb-3 rounded-circle">
            <p>"Motor saya selalu dalam kondisi prima setelah servis di sini."</p>
            <p><strong>- Rina, Palembang</strong></p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="testimonial-item shadow-lg p-4 mb-4 rounded animate__animated animate__fadeInUp animate__delay-3s">
            <img src="image/img-16.jpg" alt="Budi" class="img-fluid mb-3 rounded-circle">
            <p>"Tempat servis motor terbaik yang pernah saya kunjungi!"</p>
            <p><strong>- Budi, Palembang</strong></p>
          </div>
        </div>
      </div>
    </div>
  </section>


 <!-- About Section -->
<section class="about py-5" id="about">
  <div class="container">
    <div class="row">
      <div class="col-lg-6">
        <h2 class="text-center mb-4 section-title animate__animated animate__fadeInUp">About us</h2>
        <p class="text-center mb-4 animate__animated animate__fadeInUp animate__delay-1s">
          Rajawali Motor Sport adalah bengkel motor yang berkomitmen untuk memberikan layanan terbaik bagi motor Anda. Kami memiliki mekanik yang ahli dan berpengalaman, siap memberikan perawatan motor dengan kualitas terbaik.
        </p>
        <p class="text-center mb-4 animate__animated animate__fadeInUp animate__delay-2s">
          Kami menyediakan berbagai layanan mulai dari servis berkala hingga penggantian suku cadang dengan harga yang terjangkau.
        </p>
        <div class="text-center">
          <a href="#services" class="btn btn-warning btn-book animate__animated animate__bounceInUp animate__delay-3s">Lihat Layanan Kami</a>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="about-image animate__animated animate__zoomIn animate__delay-1s">
          <img src="image/img-10.jpeg" alt="Team Rajawali Motor Sport" class="img-fluid rounded shadow-lg">
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-12 text-center">
        <h4 class="mb-4 animate__animated animate__fadeInUp animate__delay-2s">Working Team</h4>
      </div>
      <!-- Tim kami -->
      <div class="col-md-4">
        <div class="team-member text-center animate__animated animate__fadeInUp animate__delay-3s">
          <img src="image/img-19.jpeg" alt="Mekaniku" class="img-fluid rounded-circle mb-3">
          <h5>Julian, Kepala Mekanik</h5>
          <p>Ahli dalam perawatan dan perbaikan mesin motor. Pengalaman lebih dari 10 tahun.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="team-member text-center animate__animated animate__fadeInUp animate__delay-4s">
          <img src="image/img-20.jpeg" alt="Mekaniku" class="img-fluid rounded-circle mb-3">
          <h5>Weri, Mekanik</h5>
          <p>Spesialis dalam servis berkala dan penggantian oli motor.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="team-member text-center animate__animated animate__fadeInUp animate__delay-5s">
          <img src="image/img-18.jpeg" alt="Mekaniku" class="img-fluid rounded-circle mb-3">
          <h5>Rian, Mekanik</h5>
          <p>Berpengalaman dalam mengganti suku cadang motor dan perbaikan mesin.</p>
        </div>
      </div>
    </div>
    <!-- Social Media -->
    <div class="row mt-5 text-center">
      <div class="col-12">
        <h4 class="mb-4 animate__animated animate__fadeInUp animate__delay-6s">Hubungi Kami</h4>
        <div class="social-icons animate__animated animate__zoomIn animate__delay-7s">
          <a href="https://wa.me/1234567890" class="mx-3 social-icon" target="_blank" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
          <a href="https://www.instagram.com/rajawalimotorsport" class="mx-3 social-icon" target="_blank" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="https://www.facebook.com/rajawalimotorsport" class="mx-3 social-icon" target="_blank" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- register.php -->
<section id="register" class="register py-5">
  <div class="container">
    <h2 class="text-center mb-4 section-title animate__animated animate__fadeIn">Register</h2>
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <form action="submit_register.php" method="POST" class="shadow p-4 rounded bg-light">
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="name" class="form-label">Username</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="col-md-6">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="phone" name="phone" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
      </div>
    </div>
  </div>
</section>

  <!-- Footer -->
  <footer class="bg-dark text-white py-4 text-center">
    <p>&copy; 2024 Rajawali Motor Sport. All rights reserved.</p>
  </footer>

  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
