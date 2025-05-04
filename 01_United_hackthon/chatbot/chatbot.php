<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "healthsync"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

$sql = "SELECT id, fullname, specilaty, availability_days, availability_time FROM doctors WHERE verified = 1";
$result = $conn->query($sql);

$doctors = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $doctors[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($doctors);

$conn->close();
?>