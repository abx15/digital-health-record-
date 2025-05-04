<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";     // change as per your config
$pass = "";         // change if password is set
$dbname = "healthsync";  // ensure this is correct

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["error" => "Connection failed: " . $conn->connect_error]);
    exit;
}

$query = "SELECT * FROM visits_data";
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
$conn->close();
?>


