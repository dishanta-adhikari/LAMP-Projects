<?php
include 'includes/header.php';
$unsplashImageUrl = "https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>TravelBook - Discover Your Journey</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f9fbfd;
            color: #343a40;
        }

        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
                url('<?= $unsplashImageUrl ?>') center/cover no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            border-radius: 0 0 40px 40px;
        }

        .hero-title {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 700;
        }

        .hero-subtitle {
            font-size: clamp(1rem, 2vw, 1.25rem);
            margin-top: 15px;
        }

        .hero-buttons .btn {
            padding: 12px 30px;
            font-size: 1.1rem;
            margin: 10px 10px 0;
            border-radius: 8px;
        }

        .btn-register {
            background-color: #ffffff;
            color: #2f80ed;
            font-weight: 600;
            border: none;
        }

        .btn-register:hover {
            background-color: #e3eefe;
        }

        .btn-login {
            background-color: #2f80ed;
            color: white;
            font-weight: 600;
        }

        .btn-login:hover {
            background-color: #1c60c2;
        }

        .features {
            padding: 80px 0;
        }

        .feature-icon {
            font-size: 3rem;
            color: #2f80ed;
            margin-bottom: 15px;
        }

        .feature-box {
            padding: 30px 20px;
            border-radius: 15px;
            background-color: #fff;
            transition: all 0.3s ease-in-out;
        }

        .feature-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .feature-box h5 {
            font-weight: 600;
            margin-top: 10px;
        }

        .btn-outline-primary,
        .btn-outline-dark {
            margin-top: 20px;
            margin-right: 10px;
        }

        @media (max-width: 576px) {
            .hero-buttons .btn {
                display: block;
                width: 100%;
                margin-bottom: 10px;
            }

            .btn-outline-primary,
            .btn-outline-dark {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container" data-aos="fade-up">
            <h1 class="hero-title">Start Your Adventure Today</h1>
            <p class="hero-subtitle">Discover the best places, packages, and hotels curated just for you.</p>
            <div class="hero-buttons">
                <a href="register" class="btn btn-register">Register</a>
                <a href="login" class="btn btn-login">Login</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features text-center container">
        <h2 class="mb-5" data-aos="fade-down">Why Choose TravelBook?</h2>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-box shadow-sm">
                    <div class="feature-icon">&#9989;</div>
                    <h5>Seamless Booking</h5>
                    <p>Book your trips with ease in a few clicks. Fast and secure.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-box shadow-sm">
                    <div class="feature-icon">&#127758;</div>
                    <h5>Global Destinations</h5>
                    <p>We bring you handpicked places and exciting locations around the globe.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-box shadow-sm">
                    <div class="feature-icon">&#127976;</div>
                    <h5>Hotel Integration</h5>
                    <p>Find hotels associated with every location, all in one click.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>

<?php include 'includes/footer.php'; ?>