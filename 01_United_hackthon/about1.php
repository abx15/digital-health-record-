<?php
session_start(); // Required on every page using session

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Digital Health Smart Records System</title>
    <link rel="stylesheet" href="css/about.css">
    <link rel="icon" href="img/HealthSync.png" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css">
</head>
<body>
    <!-- Header Section -->
  <!-- Header/Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top digital-health-header">
    <div class="container">
        <a class="navbar-brand" href="#">
            <i class="fas fa-heartbeat me-2"></i>HealthSync
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link active" href="main.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about1.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="dashbord.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="doctors.php">Doctors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact1.php">Contact</a>
                </li>
                
                <li class="nav-item dropdown">
                    <button class="btn btn-outline-light ms-2" id="profileToggle" onclick="toggleProfileMenu()">
                        <i class="fas fa-user-circle"></i>
                    </button>
                    <div id="profileMenu" class="dropdown-menu dropdown-menu-end mt-2" style="display: none;">
                        <a class="dropdown-item" href="paitent-profile.php">Profile</a>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>



    <!-- Hero Section -->
    <section class="hero-section position-relative">
        <div class="hero-overlay">
            <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef" class="w-100" alt="Healthcare Team">
            <div class="container position-absolute top-50 start-50 translate-middle text-center text-white">
                <h1 class="display-4 fw-bold">About Digital Health</h1>
                <p class="lead">Empowering better healthcare through innovative digital solutions</p>
            </div>
        </div>
    </section>

    <!-- Our Story -->
    <section class="our-story py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>Our Story</h2>
                    <p>Founded in 2020, Digital Health was born from a vision to transform healthcare by making medical records accessible, secure, and seamless for both patients and providers. Our team of healthcare professionals and technologists came together to address the challenges of fragmented health data and outdated systems.</p>
                    <p>Today, we serve over 250,000 patients and 5,000 healthcare providers across the globe, delivering a platform that enhances care coordination, improves patient outcomes, and prioritizes data security.</p>
                    <a href="#" class="button">Learn More About Our Journey</a>
                </div>
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1581094271901-8022df4466f9" class="img-fluid rounded" alt="Healthcare Team">
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="mission-vision py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-heartbeat"></i></div>
                        <h4>Our Mission</h4>
                        <p>To empower patients and healthcare providers with secure, accessible, and integrated health records that drive better care and outcomes.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-eye"></i></div>
                        <h4>Our Vision</h4>
                        <p>To create a connected healthcare ecosystem where data flows seamlessly, enabling personalized care and healthier communities worldwide.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Team -->
    <section class="our-team py-5">
        <div class="container">
            <div class="section-header text-center">
                <h2>Meet Our Leadership Team</h2>
                <p>Our dedicated team brings together expertise in healthcare, technology, and innovation</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="doctor-card text-center">
                        <img src="https://i.pinimg.com/736x/0f/68/94/0f6894e539589a50809e45833c8bb6c4.jpg" alt="Dr. Anil Sharma" class="rounded-circle">
                        <div class="card-content">
                            <h4>Dr. Anil Sharma</h4>
                            <p class="specialty">Chief Executive Officer</p>
                            <p>With 20 years in healthcare leadership, Dr. Sharma drives our mission to revolutionize medical records management.</p>
                            <a href="#" class="button secondary">Connect on LinkedIn</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="doctor-card text-center">
                        <img src="https://i.pinimg.com/736x/0f/68/94/0f6894e539589a50809e45833c8bb6c4.jpg" alt="Priya Patel" class="rounded-circle">
                        <div class="card-content">
                            <h4>Priya Patel</h4>
                            <p class="specialty">Chief Technology Officer</p>
                            <p>An expert in health tech, Priya leads our engineering team to build secure and scalable solutions.</p>
                            <a href="#" class="button secondary">Connect on LinkedIn</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="doctor-card text-center">
                        <img src="https://i.pinimg.com/736x/0f/68/94/0f6894e539589a50809e45833c8bb6c4.jpg" alt="Dr. Neha Gupta" class="rounded-circle">
                        <div class="card-content">
                            <h4>Dr. Neha Gupta</h4>
                            <p class="specialty">Chief Medical Officer</p>
                            <p>Dr. Gupta ensures our platform meets the needs of providers and patients with her clinical expertise.</p>
                            <a href="#" class="button secondary">Connect on LinkedIn</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="our-values py-5 bg-light">
        <div class="container">
            <div class="section-header text-center">
                <h2>Our Core Values</h2>
                <p>The principles that guide everything we do</p>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-lock"></i></div>
                        <h4>Security First</h4>
                        <p>We prioritize the protection of your health data with military-grade encryption and HIPAA compliance.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-users"></i></div>
                        <h4>Patient-Centric</h4>
                        <p>Our solutions are designed with patients at the heart, ensuring ease of use and accessibility.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon"><i class="fas fa-lightbulb"></i></div>
                        <h4>Innovation Driven</h4>
                        <p>We continuously innovate to stay ahead in delivering cutting-edge healthcare solutions.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Indicators -->
    <section class="trust-indicators py-4">
        <div class="scroll-container">
            <div class="scroll-track">
                <div class="trust-item">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <div>HIPAA Compliant</div>
                        <small>100% Secure</small>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-hospital"></i>
                    <div>
                        <div>500+ Hospitals</div>
                        <small>Trusted Partner</small>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-headset"></i>
                    <div>
                        <div>24/7 Support</div>
                        <small>Always Available</small>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-plug"></i>
                    <div>
                        <div>EHR Integration</div>
                        <small>Seamless Connection</small>
                    </div>
                </div>
                <!-- Duplicate for smooth loop -->
                <div class="trust-item">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <div>HIPAA Compliant</div>
                        <small>100% Secure</small>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-hospital"></i>
                    <div>
                        <div>500+ Hospitals</div>
                        <small>Trusted Partner</small>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-headset"></i>
                    <div>
                        <div>24/7 Support</div>
                        <small>Always Available</small>
                    </div>
                </div>
                <div class="trust-item">
                    <i class="fas fa-plug"></i>
                    <div>
                        <div>EHR Integration</div>
                        <small>Seamless Connection</small>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer Section -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.scroll-track').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                arrows: false,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });


        function toggleProfileMenu() {
            var menu = document.getElementById("profileMenu");
            if (menu.style.display === "none" || menu.style.display === "") {
                menu.style.display = "block";
            } else {
                menu.style.display = "none";
            }
        }
    </script>

<?php include 'chatbot.php'; ?>
</body>
</html>