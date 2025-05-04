<?php
include "db.php";
$sql = "SELECT full_name, COUNT(*) AS visit_count FROM doctor_details GROUP BY full_name";
$result = $conn->query($sql);

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