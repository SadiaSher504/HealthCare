<?php
session_start();
include("../include/connection.php");

// Get the doctor's username from session
$doctor_username = $_SESSION['doctor_username'];

// Fetch pending appointments with status 'Pending'
$query = "SELECT * FROM appointment WHERE doctor_username = ? AND status = 'Pending'";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, 's', $doctor_username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$appointments = [];
while ($row = mysqli_fetch_assoc($result)) {
    // Format the appointment date and add it to the array
    $appointments[] = [
        'title' => 'Appointment with ' . htmlspecialchars($row['full_name']),
        'start' => $row['appointment_date'],
        'backgroundColor' => '#17a2b8', // Custom color for the event
        'borderColor' => '#17a2b8' // Same color for border
    ];
}

// Return appointments as a JSON response
echo json_encode($appointments);
?>
