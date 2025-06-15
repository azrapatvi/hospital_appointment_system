<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$db = "hospital";

$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor = mysqli_real_escape_string($conn, $_POST['doctor']);
    $appointment_date = mysqli_real_escape_string($conn, $_POST['appointment_date']);

    // Get the count of existing appointments
    $sql = "SELECT COUNT(*) AS total FROM appointments2 WHERE doctor = ? AND appointment_date = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $doctor, $appointment_date);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $booked = (int)$row['total'];
        $available = max(0, 10 - $booked); // Doctor max 10 slots per day
        echo json_encode(["success" => true, "slots" => $available]);
    } else {
        echo json_encode(["success" => false, "message" => "Doctor not found or no records."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}

mysqli_close($conn);
?>
