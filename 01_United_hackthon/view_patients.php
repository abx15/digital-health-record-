<?php
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbName = "healthsync";

$conn = mysqli_connect($servername, $username, $dbpassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor's Patient List</title>
    <link rel="icon" href="img/HealthSync.png" type="image/png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f8ff;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e6f7ff;
        }

        .status-pending {
            color: #e67e22;
            font-weight: bold;
        }

        .status-confirmed {
            color: #27ae60;
            font-weight: bold;
        }

        .action-form {
            display: flex;
            gap: 5px;
        }

        input[type="submit"] {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: background-color 0.3s;
        }

        input[name="accept"] {
            background-color: #2ecc71;
            color: white;
        }

        input[name="accept"]:hover {
            background-color: #27ae60;
        }

        input[name="pending"] {
            background-color: #f39c12;
            color: white;
        }

        input[name="pending"]:hover {
            background-color: #e67e22;
        }

        .no-patients {
            text-align: center;
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            margin: 20px 0;
        }

        .error-message {
            text-align: center;
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border-radius: 5px;
            margin: 20px 0;
        }

        .success-message {
            text-align: center;
            padding: 20px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        if (isset($_GET['doctor_id'])) {
            $doctor_id = mysqli_real_escape_string($conn, $_GET['doctor_id']);

            // Status update
            if (isset($_POST['accept'])) {
                $appointment_id = $_POST['appointment_id'];
                $update_sql = "UPDATE appointments SET status = 'confirmed' WHERE id = '$appointment_id'";
                if (mysqli_query($conn, $update_sql)) {
                    echo '<div class="success-message">Appointment confirmed successfully!</div>';
                    // After update, reload the page with doctor_id in URL
                    header("Refresh:2; url=" . $_SERVER['PHP_SELF'] . "?doctor_id=" . $_POST['doctor_id']);
                } else {
                    echo '<div class="error-message">Error updating appointment: ' . mysqli_error($conn) . '</div>';
                }
            }

            if (isset($_POST['pending'])) {
                $appointment_id = $_POST['appointment_id'];
                $update_sql = "UPDATE appointments SET status = 'pending' WHERE id = '$appointment_id'";
                if (mysqli_query($conn, $update_sql)) {
                    echo '<div class="success-message">Appointment marked as pending!</div>';
                    // After update, reload the page with doctor_id in URL
                    header("Refresh:2; url=" . $_SERVER['PHP_SELF'] . "?doctor_id=" . $_POST['doctor_id']);
                } else {
                    echo '<div class="error-message">Error updating appointment: ' . mysqli_error($conn) . '</div>';
                }
            }

            $sql = "SELECT * FROM appointments WHERE doctor_id = '$doctor_id' ORDER BY appointment_date, appointment_time";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<h2>Patient Appointments</h2>";
                    echo "<table>
                            <tr>
                                <th>Patient Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Symptoms</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>";

                    while ($row = mysqli_fetch_assoc($result)) {
                        $status_class = 'status-' . strtolower($row['status']);
                        echo "<tr>
                                <td>" . htmlspecialchars($row['patient_name']) . "</td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['appointment_date']) . "</td>
                                <td>" . htmlspecialchars($row['appointment_time']) . "</td>
                                <td>" . htmlspecialchars($row['symptoms']) . "</td>
                                <td><span class='$status_class'>" . htmlspecialchars($row['status']) . "</span></td>
                                <td>
                                    <form method='post' class='action-form'>
                                        <input type='hidden' name='appointment_id' value='" . $row['id'] . "'>
                                        <input type='hidden' name='doctor_id' value='" . $doctor_id . "'>
                                        <input type='submit' name='accept' value='Accept'>
                                        <input type='submit' name='pending' value='Pending'>
                                    </form>
                                </td>
                            </tr>";
                    }
                    echo "</table>";
                } else {
                    echo '<div class="no-patients">No appointments found for this doctor.</div>';
                }
            } else {
                echo '<div class="error-message">Error: ' . mysqli_error($conn) . '</div>';
            }
        } else {
            echo '<div class="error-message">No doctor specified.</div>';
        }

        mysqli_close($conn);
        ?>
<a href="profile.php">back to profile</a>
      
    </div>
</body>

</html>