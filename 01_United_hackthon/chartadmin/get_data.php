<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "healthsync");

$doctor = $_GET['doctor'] ?? 'all';
$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;

$where = [];

if ($doctor !== 'all') {
    $where[] = "consultant_doctor = '" . $conn->real_escape_string($doctor) . "'";
}
if ($start && $end) {
    $where[] = "dob BETWEEN '$start' AND '$end'";
}

$whereSQL = $where ? "WHERE " . implode(" AND ", $where) : "";

$query = "SELECT * FROM admin_main $whereSQL";
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
?>
