<?php
session_start();
require_once 'config.php';

// Fetch Doctor's Details
$doctor_id = $_SESSION['doctor_id'] ?? 1;
$stmt = $conn->prepare("SELECT * FROM doctors WHERE id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dr. <?= htmlspecialchars($doctor['fullname']) ?> - Profile | HealthSync</title>
    <link rel="icon" href="img/HealthSync.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #e0e7ff;
            --primary-dark: #3a56d4;
            --secondary: #3f37c9;
            --accent: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --success: #4cc9f0;
            --warning: #f8961e;
            --danger: #ef233c;
            --white: #ffffff;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9fafc;
            color: var(--dark);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        /* Profile Header */
        .profile-header {
            display: flex;
            flex-wrap: wrap;
            background: var(--white);
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 40px;
            position: relative;
            border: 1px solid rgba(67, 97, 238, 0.1);
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 120px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            z-index: 0;
        }

        .profile-photo {
            flex: 0 0 280px;
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .profile-img {
            width: 220px;
            height: 220px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--white);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            transition: var(--transition);
        }

        .profile-img:hover {
            transform: scale(1.03);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .profile-details {
            flex: 1;
            padding: 40px;
            position: relative;
            z-index: 1;
        }

        .profile-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .profile-title h1 {
            font-size: 32px;
            color: var(--white);
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-title .badge {
            background: var(--white);
            color: var(--primary);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .profile-content {
            background: var(--white);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .profile-meta {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            background: var(--light);
            border-radius: 8px;
            transition: var(--transition);
        }

        .meta-item:hover {
            background: var(--primary-light);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.1);
        }

        .meta-item i {
            width: 36px;
            height: 36px;
            background: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--primary);
            font-size: 16px;
            box-shadow: 0 4px 10px rgba(67, 97, 238, 0.15);
        }

        .meta-item span {
            font-weight: 500;
            color: var(--dark);
        }

        .meta-item .value {
            color: var(--gray);
            margin-left: 8px;
            font-weight: 400;
        }

        .action-btns {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 25px;
            border-radius: 10px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            border: none;
            font-size: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background: var(--primary);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary-light);
            transform: translateY(-3px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .profile-photo {
                flex: 0 0 100%;
                text-align: center;
                padding-bottom: 0;
            }
            
            .profile-details {
                padding: 30px;
            }
            
            .profile-meta {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            }
            
            .profile-img {
                width: 180px;
                height: 180px;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 768px) {
            .profile-title {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .profile-title h1 {
                font-size: 28px;
            }
            
            .action-btns {
                flex-direction: column;
                gap: 12px;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .profile-content {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .profile-meta {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 20px 15px;
            }
            
            .profile-header::before {
                height: 80px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Doctor Profile Header -->
        <div class="profile-header">
            <div class="profile-photo">
                <img src="<?= htmlspecialchars($doctor['photo'] ?? 'img/default-doctor.jpg') ?>" alt="Doctor Photo" class="profile-img">
            </div>
            
            <div class="profile-details">
                <div class="profile-title">
                    <h1>Dr. <?= htmlspecialchars($doctor['fullname']) ?></h1>
                    <span class="badge"><?= htmlspecialchars($doctor['specialty']) ?></span>
                </div>
                
                <div class="profile-content">
                    <div class="profile-meta">
                        <div class="meta-item">
                            <i class="fas fa-briefcase-medical"></i>
                            <span>Experience:</span>
                            <span class="value"><?= htmlspecialchars($doctor['experience']) ?> years</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Availability:</span>
                            <span class="value"><?= htmlspecialchars($doctor['availability_days']) ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>Timings:</span>
                            <span class="value"><?= htmlspecialchars($doctor['availability_time']) ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-id-card"></i>
                            <span>License:</span>
                            <span class="value"><?= htmlspecialchars($doctor['license']) ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-envelope"></i>
                            <span>Email:</span>
                            <span class="value"><?= htmlspecialchars($doctor['email']) ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-phone"></i>
                            <span>Phone:</span>
                            <span class="value"><?= htmlspecialchars($doctor['phone']) ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-venus-mars"></i>
                            <span>Gender:</span>
                            <span class="value"><?= htmlspecialchars($doctor['gender']) ?></span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Address:</span>
                            <span class="value"><?= htmlspecialchars($doctor['address']) ?></span>
                        </div>
                    </div>
                    
                    <div class="action-btns">
                        <a href="view_patients.php?doctor_id=<?= urlencode($doctor['id']) ?>" class="btn btn-primary">
                            <i class="fas fa-user-injured"></i> View Patients
                        </a>

                        <a href="logout.php" class="btn btn-light">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include 'chatbot.php'; ?>

</body>
</html>