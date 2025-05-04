<?php
$conn = new mysqli("localhost", "root", "", "healthsync"); // Adjust as per your DB config
$result = $conn->query("SELECT DISTINCT consultant_doctor FROM admin_main WHERE consultant_doctor IS NOT NULL AND consultant_doctor != ''");

$doctors = [];
while ($row = $result->fetch_assoc()) {
    $doctors[] = $row['consultant_doctor'];
}
echo json_encode($doctors);
?>
