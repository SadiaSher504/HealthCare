<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hospital Management System</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <!-- Owl Carousel CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" rel="stylesheet"/>

  <style>
  .top-bar {
    background-color: #00cfff;
    color: white;
    font-size: 14px;
    height: 40px;
    padding: 0 15px;
  }

  .custom-navbar {
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }

  .hero-section {
    background: url('img/1.jpg') center center/cover no-repeat;
    min-height: 70vh;
    display: flex;
    align-items: center;
    color: white;
    text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
    padding: 60px 20px; /* Added padding for better mobile view */
  }

  .hero-section h1 {
    font-size: 2.5rem;
  }

  @media (min-width: 768px) {
    .hero-section h1 {
      font-size: 3.5rem;
    }
  }

  .about-us-section {
    background-color: #f8f9fa;
    padding: 60px 0;
  }

  .section-title {
    text-align: center;
    margin-bottom: 40px;
    color: #17a2b8;
    font-weight: bold;
  }

  .owl-carousel .item img {
    width: 180px;
    height: 180px;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid white;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transition: 0.3s;
  }

  .owl-carousel .item img:hover {
    transform: scale(1.05);
  }

  footer {
    background-color: #212529;
    color: white;
    padding-top: 40px;
    padding-bottom: 20px;
  }

  footer a {
    color: #17a2b8;
  }

  @media (max-width: 767.98px) {
    .top-bar {
      font-size: 12px;
      height: auto;
      padding: 10px;
      text-align: center;
    }

    footer .row {
      text-align: center;
    }

    footer form {
      flex-direction: column;
      gap: 10px;
    }

    .hero-section {
      min-height: 60vh;
    }
  }
</style>

</head>

<body>

<!-- Top Contact Bar -->
<div class="top-bar d-flex justify-content-between align-items-center px-3">
  <div>
    <i class="bi bi-telephone"></i> +12345665465 |
    <i class="bi bi-envelope"></i> arifmin4554@gmail.com
  </div>
  
</div>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container">
    <a class="navbar-brand text-info fw-bold fs-3" href="#">RSDKH</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="mainNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link fw-bold text-info" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link fw-bold" href="#about-us">About</a></li>
        <li class="nav-item"><a class="nav-link fw-bold" href="login/login.php">Login Panel</a></li>
        <li class="nav-item"><a class="nav-link fw-bold text-success" href="apply.php">Job Is Open Now <i class="bi bi-envelope-fill text-warning"></i></a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero Section -->
<section class="hero-section">
  <div class="container">
    <div class="text-start">
      <h5 class="text-light mb-3">Welcome To RSDKH</h5>
      <h1 class="display-4 fw-bold">Super Specialized<br> Hospital In Your City</h1>
      <div class="mt-4">
        <a href="#about-us" class="btn btn-info btn-lg">Learn More</a> <!-- Example button -->
      </div>
    </div>
  </div>
</section>



<!-- Appointment Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="appointmentModalLabel">Book Your Appointment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Your Appointment form will go here -->
        <p>Appointment form will be loaded here...</p>
      </div>
    </div>
  </div>
</div>

<!-- About Us Section -->
<section id="about-us" class="about-us-section">
  <div class="container">
    <h2 class="section-title">About Us</h2>
    <div class="row g-4">
      
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">Our Mission</h5>
          </div>
          <div class="card-body">
            <p>At RSDKH, we are dedicated to enhancing the health and well-being of our community by delivering high-quality, compassionate healthcare services. We strive to set the standard for excellence through innovation, education, and patient-centered care.</p>
            <p>Our mission is to build a healthier tomorrow by nurturing trust, providing personalized treatments, and embracing the latest medical advancements for every patient we serve.</p>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">Our Services</h5>
          </div>
          <div class="card-body">
            <p>We offer a comprehensive range of medical services including 24/7 emergency care, specialized surgeries, diagnostic imaging, laboratory services, maternity care, and outpatient consultations. Our multidisciplinary team ensures that every aspect of your health is cared for with professionalism and empathy.</p>
            <p>Whether you require preventive care, chronic disease management, or advanced surgical procedures, RSDKH is equipped to meet your needs with precision and care.</p>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">Our Vision</h5>
          </div>
          <div class="card-body">
            <p>Our vision is to become a leading healthcare institution recognized nationally and internationally for excellence in clinical care, research, and education. We aim to be the first choice for patients seeking trustworthy, advanced, and compassionate healthcare solutions.</p>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card h-100">
          <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">Why Choose Us?</h5>
          </div>
          <div class="card-body">
            <p>At RSDKH, patients come first. Our expert doctors, advanced technology, patient-focused approach, and welcoming environment make us the preferred choice for families. We believe healthcare is not just about treating illnesses but about enriching lives and building lasting relationships with our patients.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- Our Team Section -->
<section class="py-5 ">
  <h2 class="section-title">Our Team</h2>
  <div class="container">
    <div class="owl-carousel owl-theme">
      <div class="item">
        <img src="img/team-2.jpg" alt="Doctor 1">
        <p class="mt-2">Dr. Ahmed Ali</p>
      </div>
      <div class="item">
        <img src="img/team-3.jpg" alt="Doctor 2">
        <p class="mt-2">Dr. Faryal Khan</p>
      </div>
      <div class="item">
        <img src="img/team-11.JPG" alt="Doctor 3">
        <p class="mt-2">Dr. Ayesha Malik</p>
      </div>
      <div class="item">
        <img src="img/testimonial-1.jpg" alt="Doctor 4">
        <p class="mt-2">Dr. Sana Raza</p>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<!-- Footer -->
<footer>
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <h5 class="text-info">HMSC</h5>
        <p><i class="bi bi-geo-alt"></i> Wapda Town, Lahore</p>
        <p><i class="bi bi-envelope"></i> healthcarehospital@gmail.com</p>
        <p><i class="bi bi-telephone"></i> +9205456455</p>
      </div>
      <div class="col-md-4">
        <h5 class="text-info">Quick Links</h5>
        <ul class="list-unstyled">
          <li><a href="#" class="text-white text-decoration-none">Home</a></li>
          <li><a href="#" class="text-white text-decoration-none">Services</a></li>
          <li><a href="../hospital/login/login.php" class="text-white text-decoration-none">Appointment</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h5 class="text-info">Follow Us</h5>
        <ul class="list-unstyled">
          <li><a href="https://facebook.com" class="text-white text-decoration-none"><i class="bi bi-facebook"></i> Facebook</a></li>
          <li><a href="https://twitter.com" class="text-white text-decoration-none"><i class="bi bi-twitter"></i> Twitter</a></li>
          <li><a href="https://instagram.com" class="text-white text-decoration-none"><i class="bi bi-instagram"></i> Instagram</a></li>
        </ul>
      </div>
    </div>
    <hr class="border-light my-4">
    <div class="text-center small">&copy; 2025 HMSC. All Rights Reserved. Designed by <a href="mailto:healthcare778@gmail.com" class="text-info">healthcare778@gmail.com</a></div>
  </div>
</footer>


<!-- JS Scripts -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
  $(document).ready(function(){
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 20,
      nav: false,
      dots: true,
      autoplay: true,
      autoplayTimeout: 3000,
      responsive: {
        0: { items: 1 },
        600: { items: 2 },
        1000: { items: 3 }
      }
    });
  });
</script>

</body>
</html>