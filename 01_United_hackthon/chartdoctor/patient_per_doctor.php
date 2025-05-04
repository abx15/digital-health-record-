<?php
include "db.php";
$sql = "SELECT consultant_doctor AS doctor, COUNT(DISTINCT id) AS total FROM doctor_details GROUP BY consultant_doctor";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
?>