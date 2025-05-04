<?php
header('Content-Type: application/json');

// Replace with your actual database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'your_database_name'; // ✅ Replace this with your DB name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

$sql = "SELECT id, fullname, specialty, availability_date, availability_time FROM doctors";
$result = $conn->query($sql);

$doctors = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}

echo json_encode($doctors);

$conn->close();
?>
