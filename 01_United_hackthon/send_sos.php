<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: text/plain");

$data = json_decode(file_get_contents("php://input"), true);

// DB connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "healthsync";

if (!isset($data['patient_id']) || !isset($data['timestamp'])) {
    echo "❌ Missing required data.";
    exit;
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo "❌ Connection error: " . $conn->connect_error;
    exit;
}

$patient_id = (int)$data['patient_id'];
$timestamp = $conn->real_escape_string($data['timestamp']);
$latitude = isset($data['latitude']) ? (float)$data['latitude'] : null;
$longitude = isset($data['longitude']) ? (float)$data['longitude'] : null;

$sql = "INSERT INTO sos_alerts (patient_id, timestamp, status, latitude, longitude)
        VALUES ($patient_id, '$timestamp', 'pending', ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("dd", $latitude, $longitude);

if ($stmt->execute()) {
    echo "✅ SOS alert with location saved.";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>