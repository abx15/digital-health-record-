<?php
include "db.php";

$filter = isset($_GET['doctor']) && $_GET['doctor'] != '' ? $_GET['doctor'] : null;

if ($filter) {
    $stmt = $conn->prepare("SELECT full_name, COUNT(*) AS visit_count FROM doctor_details WHERE consultant_doctor = ? GROUP BY full_name");
    $stmt->bind_param("s", $filter);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT full_name, COUNT(*) AS visit_count FROM doctor_details GROUP BY full_name");
}

$new = $returning = 0;
while ($row = $result->fetch_assoc()) {
    if ($row['visit_count'] == 1) {
        $new++;
    } else {
        $returning++;
    }
}

echo json_encode([
    ["type" => "New", "count" => $new],
    ["type" => "Returning", "count" => $returning]
]);
?>