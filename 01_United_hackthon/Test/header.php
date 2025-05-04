<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthSync - Smart Records System</title>
    <link rel="icon" href="img/HealthSync.png" type="image/png">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/header-footer.css">
</head>
<body>
    <!-- Header/Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top digital-health-header">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="fas fa-heartbeat me-2"></i>HealthSync
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="dashbord.php">Dashbord</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="doctors.php">Doctors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <!-- Conditional Login/Profile Section -->
                    <?php if(isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i>
                            <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'Profile'); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user me-2"></i>My Profile</a></li>
                            <li><a class="dropdown-item" href="settings.php"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-light" href="login.php">Login</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>