<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HealthSync</title>
    <link rel="icon" href="img/HealthSync.png" type="image/png">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/dashboard.css">
    <style>
        :root {
            --primary-blue: #4A90E2;
            --secondary-green: #50C878;
            --text-dark: #2D3748;
            --bg-light: #F7F9FC;
            --shadow-sm: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--bg-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .dashboard-section {
            padding: 2rem 0;
        }

        .sidebar {
            background-color: #fff;
            border-radius: 10px;
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .sidebar .card-title {
            color: var(--text-dark);
            font-weight: 600;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 10px;
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            color: var(--text-dark);
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover,
        .sidebar ul li a.active {
            background-color: var(--primary-blue);
            color: #fff;
        }

        .stat-card {
            background-color: #fff;
            border-radius: 10px;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h5 {
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .stat-card .display-6 {
            font-size: 2rem;
            font-weight: bold;
            color: var(--primary-blue);
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: var(--shadow-sm);
        }

        .card-body {
            padding: 1.5rem;
        }

        h2.mb-4 {
            color: var(--text-dark);
            font-weight: 600;
        }

        canvas {
            max-height: 300px;
        }

        @media (max-width: 992px) {
            .sidebar {
                position: static;
                margin-bottom: 20px;
            }

            .dashboard-section {
                padding: 1.5rem 0;
            }
        }
    </style>
</head>

<body>
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
                        <a class="nav-link active" href="Main.php">Home</a>
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
                            <a class="dropdown-item" href="profile.php">Profile</a>
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Dashboard Content -->
    <section class="dashboard-section py-5">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4">
                    <div class="sidebar card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-user-circle me-2"></i>Admin Panel</h5>
                            <ul class="list-unstyled">
                                <li class="mb-3"><a href="admin_login.php" class="active"><i
                                            class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                <!-- <li class="mb-3"><a href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a> -->
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 mb-4">
                    <div class="sidebar card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-user-circle me-2"></i>Pricing</h5>
                            <ul class="list-unstyled">
                                <li class="mb-3"><a href="Pricing.php" class="active"><i
                                            class="fas fa-tachometer-alt me-2"></i>Price</a></li>
                                <!-- <li class="mb-3"><a href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a> -->
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <h2 class="mb-4">My Healthcare Dashboard</h2>

                    <!-- Stats Cards - User Specific -->
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div class="card stat-card shadow-sm">
                                <div class="card-body">
                                    <h5><i class="fas fa-calendar-check me-2"></i>My Appointments</h5>
                                    <p class="display-6">5</p>
                                    <small class="text-success">+1 from last month</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card stat-card shadow-sm">
                                <div class="card-body">
                                    <h5><i class="fas fa-prescription me-2"></i>Active Prescriptions</h5>
                                    <p class="display-6">3</p>
                                    <small class="text-success">All up to date</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card stat-card shadow-sm">
                                <div class="card-body">
                                    <h5><i class="fas fa-heartbeat me-2"></i>Health Score</h5>
                                    <p class="display-6">82%</p>
                                    <small class="text-success">Good</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row 1 -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5>My Health Visits (Monthly)</h5>
                                    <canvas id="patientVisitsChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5>Appointment Status</h5>
                                    <canvas id="appointmentStatusChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row 2 -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5>My Health Conditions</h5>
                                    <canvas id="diseaseDistributionChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5>Medication Schedule</h5>
                                    <canvas id="medicationChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upcoming Appointments -->
                    <div class="row mb-4">
                        <div class="col-md-12 mb-3">
                            <div class="card shadow-sm">
                                <div class="card-body">
                                    <h5>Upcoming Appointments</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Doctor</th>
                                                    <th>Department</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>2023-07-15</td>
                                                    <td>10:30 AM</td>
                                                    <td>Dr. Smith</td>
                                                    <td>Cardiology</td>
                                                    <td><span class="badge bg-warning">Confirmed</span></td>
                                                </tr>
                                                <tr>
                                                    <td>2023-07-22</td>
                                                    <td>02:15 PM</td>
                                                    <td>Dr. Johnson</td>
                                                    <td>Dermatology</td>
                                                    <td><span class="badge bg-info">Pending</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
    <?php include 'chatbot.php'; ?>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Chart.js Scripts -->
    <script>
        // Patient Visits Chart (Line Chart)
        const patientVisitsChart = document.getElementById('patientVisitsChart').getContext('2d');
        new Chart(patientVisitsChart, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'My Visits',
                    data: [1, 0, 2, 1, 1, 0],
                    borderColor: '#4A90E2',
                    backgroundColor: 'rgba(74, 144, 226, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Appointment Status Chart (Doughnut Chart)
        const appointmentStatusChart = document.getElementById('appointmentStatusChart').getContext('2d');
        new Chart(appointmentStatusChart, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Upcoming', 'Cancelled'],
                datasets: [{
                    data: [4, 1, 0],
                    backgroundColor: ['#50C878', '#FFD700', '#FF6F61']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Health Conditions Chart (Bar Chart)
        const diseaseDistributionChart = document.getElementById('diseaseDistributionChart').getContext('2d');
        new Chart(diseaseDistributionChart, {
            type: 'bar',
            data: {
                labels: ['Blood Pressure', 'Cholesterol', 'Allergies', 'Diabetes'],
                datasets: [{
                    label: 'Severity (1-10)',
                    data: [6, 4, 3, 2],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10
                    }
                }
            }
        });

        // Medication Chart (Horizontal Bar Chart)
        const medicationChart = document.getElementById('medicationChart').getContext('2d');
        new Chart(medicationChart, {
            type: 'bar',
            data: {
                labels: ['Morning', 'Afternoon', 'Evening', 'Night'],
                datasets: [{
                    label: 'Medication Schedule',
                    data: [2, 1, 1, 1],
                    backgroundColor: 'rgba(153, 102, 255, 0.7)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
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
</body>
</html>