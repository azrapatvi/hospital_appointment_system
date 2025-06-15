<?php
$conn = mysqli_connect("localhost", "root", "", "hospital");
if (!$conn) {
    die(json_encode(['success' => false, 'error' => 'Connection failed']));
}

$doctor = $_POST['doctor'];
$appointment_date = $_POST['appointment_date'];

$sql = "SELECT COUNT(*) AS total FROM appointmentss WHERE doctor = ? AND appointment_date = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $doctor, $appointment_date);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

$booked = $row['total'];
$slotsLeft = 10 - $booked;

echo json_encode([
    'success' => true,
    'slots' => $slotsLeft
]);

mysqli_close($conn);
?>
