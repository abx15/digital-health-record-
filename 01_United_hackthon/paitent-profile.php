<?php 
session_start();

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "healthsync";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current page number
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 5; // Appointments per page
$offset = ($page - 1) * $limit;

// Fetch patient profile
$patient_sql = "SELECT * FROM patients WHERE email = ?";
$patient_stmt = $conn->prepare($patient_sql);
if (!$patient_stmt) {
    die("Prepare failed: " . $conn->error);
}
$patient_stmt->bind_param("s", $_SESSION['email']);
$patient_stmt->execute();
$patient_result = $patient_stmt->get_result();
$patient_data = $patient_result->fetch_assoc();

// Get total number of appointments
$count_sql = "SELECT COUNT(*) as total FROM appointments WHERE email = ?";
$count_stmt = $conn->prepare($count_sql);
$count_stmt->bind_param("s", $_SESSION['email']);
$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_appointments = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_appointments / $limit);

// Fetch paginated appointments
$appointment_sql = "SELECT a.*, d.fullname as doctor_name 
                   FROM appointments a
                   JOIN doctors d ON a.doctor_id = d.id
                   WHERE a.email = ?
                   ORDER BY a.appointment_date DESC, a.appointment_time DESC
                   LIMIT ? OFFSET ?";
$appointment_stmt = $conn->prepare($appointment_sql);
$appointment_stmt->bind_param("sii", $_SESSION['email'], $limit, $offset);
$appointment_stmt->execute();
$appointment_result = $appointment_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patient Profile | HealthSync</title>
    <link rel="icon" href="img/HealthSync.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #1cc88a;
            --accent-color: #f6c23e;
            --dark-color: #5a5c69;
            --light-color: #f8f9fc;
        }
        body {
            background-color: #f8f9fa;
            font-family: 'Nunito', sans-serif;
        }
        .container { max-width: 1200px; }
        .header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            border-radius: 0.35rem;
            margin-bottom: 2rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .profile-card, .table-container, .no-appointments {
            background-color: white;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .profile-img {
            width: 120px; height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .table thead {
            background-color: var(--primary-color);
            color: white;
        }
        .btn-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }
        .btn-custom:hover {
            background-color: rgb(86, 122, 230);
            border-color: #2653d4;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-user-circle me-2"></i>Welcome, <?= htmlspecialchars($patient_data['name'] ?? 'User') ?></h1>
            <p class="mb-0">Manage your health information and appointments</p>
        </div>
        <div>
            <a href="doctors.php" class="btn btn-light me-2"><i class="fas fa-plus me-1"></i> New Appointment</a>
            <a href="logout.php" class="btn btn-light"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
        </div>
    </div>

    <!-- Profile Section -->
    <div class="profile-card row">
        <div class="col-md-3 text-center">
            <img src="<?= isset($patient_data['profile_pic']) ? 'uploads/' . $patient_data['profile_pic'] : 'img/default-profile.png' ?>"
                 class="profile-img mb-3" alt="Profile Picture">
            <h4><?= htmlspecialchars($patient_data['name'] ?? '') ?></h4>
            <p class="text-muted">Patient ID: #<?= htmlspecialchars($patient_data['id'] ?? '') ?></p>
        </div>
        <div class="col-md-9 row">
            <div class="col-md-6">
                <p><strong>Email:</strong> <?= htmlspecialchars($patient_data['email'] ?? '') ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($patient_data['phone'] ?? '') ?></p>
                <p><strong>Age:</strong> <?= htmlspecialchars($patient_data['age'] ?? '') ?> years</p>
            </div>
            <div class="col-md-6">
                <p><strong>Gender:</strong> <?= htmlspecialchars($patient_data['gender'] ?? '') ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($patient_data['address'] ?? '') ?></p>
                <p><strong>Blood Group:</strong> <?= htmlspecialchars($patient_data['blood_group'] ?? '') ?></p>
            </div>
        </div>
    </div>

    <!-- Appointments Section -->
    <h2 class="h4 mb-3"><i class="fas fa-calendar-check me-2"></i>Your Appointments</h2>

    <?php if ($appointment_result->num_rows > 0): ?>
        <div class="table-container">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Doctor</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Symptoms</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $appointment_result->fetch_assoc()): ?>
                    <?php
                    $badgeClass = match (strtolower($row['status'])) {
                        'pending' => 'bg-warning',
                        'approved' => 'bg-success',
                        'completed' => 'bg-primary',
                        'cancelled' => 'bg-secondary',
                        default => 'bg-dark'
                    };
                    ?>
                    <tr>
                        <td>#<?= htmlspecialchars($row['id']) ?></td>
                        <td>Dr. <?= htmlspecialchars($row['doctor_name']) ?></td>
                        <td><?= date('M j, Y', strtotime($row['appointment_date'])) ?></td>
                        <td><?= date('h:i A', strtotime($row['appointment_time'])) ?></td>
                        <td><?= htmlspecialchars($row['symptoms']) ?></td>
                        <td><span class="badge <?= $badgeClass ?>"><?= ucfirst($row['status']) ?></span></td>
                        <td>
                            <?php if (in_array($row['status'], ['pending', 'approved'])): ?>
                                <a href="cancel_appointment.php?id=<?= $row['id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   aria-label="Cancel appointment with Dr. <?= htmlspecialchars($row['doctor_name']) ?>"
                                   onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            <?php endif; ?>
                            <a href="view_appointment.php?id=<?= $row['id'] ?>" 
                               class="btn btn-sm btn-info"
                               aria-label="View details of appointment with Dr. <?= htmlspecialchars($row['doctor_name']) ?>">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    <?php else: ?>
        <div class="no-appointments text-center">
            <i class="fas fa-calendar-times fa-3x mb-3" style="color: var(--dark-color);"></i>
            <h3>No Appointments Found</h3>
            <p class="text-muted">You don't have any appointments scheduled yet.</p>
            <a href="doctors.php" class="btn btn-custom">
                <i class="fas fa-plus me-1"></i> Book an Appointment
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include 'chatbot.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$patient_stmt->close();
$appointment_stmt->close();
$count_stmt->close();
$conn->close();
?>
