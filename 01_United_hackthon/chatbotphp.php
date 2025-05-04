<?php 
header('Content-Type: application/json');

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "healthsync";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Database connection failed"]);
    exit;
}

// Get input
$input = json_decode(file_get_contents('php://input'), true);
$userMessage = strtolower(trim($input['message'] ?? ''));

if (!$userMessage) {
    echo json_encode(["success" => false, "error" => "No input received"]);
    exit;
}

// Symptom to specialty map
$symptom_map = [
    "headache" => "neurology",
    "migraine" => "neurology",
    "seizure" => "neurology",
    
    "chest pain" => "cardiology",
    "heart pain" => "cardiology",
    "breathing" => "cardiology",
    
    "diabetes" => "endocrinology",
    "hormone" => "endocrinology",
    "thyroid" => "endocrinology",

    "tumor" => "oncologist",
    "cancer" => "oncologist",
    "lump" => "oncologist",

    "fever" => "pediatrician",
    "cough" => "pediatrician",
    "cold" => "pediatrician",
    "child" => "pediatrician"
];

// Try to match any symptom keyword inside the user message
$matched_specialty = null;
foreach ($symptom_map as $keyword => $mapped_specialty) {
    if (strpos($userMessage, $keyword) !== false) {
        $matched_specialty = $mapped_specialty;
        break;
    }
}

// If matched specialty from symptom map, search using that
$specialty = $matched_specialty ?? $userMessage;

$stmt = $conn->prepare("SELECT id, fullname, specialty, availability_days, availability_time FROM doctors WHERE LOWER(specialty) = ?");
$stmt->bind_param("s", $specialty);
$stmt->execute();
$result = $stmt->get_result();

$doctors = [];
while ($row = $result->fetch_assoc()) {
    $doctors[] = [
        "id" => $row['id'],
        "name" => $row['fullname'],
        "specialty" => $row['specialty'],
        "days" => $row['availability_days'],
        "time" => $row['availability_time']
    ];
}

// Response logic
if (!empty($doctors)) {
    echo json_encode([
        "success" => true,
        "doctors" => $doctors
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Sorry, I couldn’t find any doctor for your symptoms. You can try asking about: headache, chest pain, diabetes, cancer, fever, etc."
    ]);
}

$conn->close();
?>
