<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "healthsyec";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

$sql = "
SELECT sa.id, sa.timestamp, sa.status,
       p.full_name, p.phone, p.email
FROM sos_alerts sa
JOIN patients p ON sa.patient_id = p.id
ORDER BY sa.timestamp DESC
";

$result = $conn->query($sql);
?>

<h2>SOS Alerts</h2>
<table border="1" cellpadding="10">
  <tr>
    <th>Alert ID</th>
    <th>Patient Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Timestamp</th>
    <th>Status</th>
  </tr>
  <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['full_name']) ?></td>
      <td><?= htmlspecialchars($row['phone']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= $row['timestamp'] ?></td>
      <td><?= $row['status'] ?></td>
    </tr>
  <?php endwhile; ?>
</table>

<?php $conn->close(); ?>