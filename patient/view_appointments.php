<?php
session_start();
error_reporting(0);
include("../include/connection.php"); // Include the database connection

// Ensure the patient is logged in
if (!isset($_SESSION['patient'])) {
    header("Location: ../patient_login.php"); // Redirect if not logged in
    exit();
}

$patient_username = $_SESSION['patient']; // Now using 'patient' for the session

// Get the patient's full name
$query_patient = "SELECT full_name FROM patient WHERE username = ?";
$stmt_patient = mysqli_prepare($connect, $query_patient);
mysqli_stmt_bind_param($stmt_patient, "s", $patient_username);
mysqli_stmt_execute($stmt_patient);
$result_patient = mysqli_stmt_get_result($stmt_patient);
$row_patient = mysqli_fetch_assoc($result_patient);
$patient_full_name = $row_patient['full_name'];

// Handle cancel appointment
if (isset($_GET['cancel_appointment_id'])) {
    $appointment_id = $_GET['cancel_appointment_id'];
    $query_cancel = "UPDATE appointment SET status = 'canceled' WHERE id = ? AND full_name = ?";
    $stmt_cancel = mysqli_prepare($connect, $query_cancel);
    mysqli_stmt_bind_param($stmt_cancel, "is", $appointment_id, $patient_full_name);
    $execute_cancel = mysqli_stmt_execute($stmt_cancel);

    if ($execute_cancel) {
        echo "<div class='alert alert-success'>Your appointment has been successfully canceled.</div>";
    } else {
        echo "<div class='alert alert-danger'>Failed to cancel the appointment. Please try again later.</div>";
    }
}

// Fetch the appointments
$query = "SELECT a.id, a.appointment_date, a.status, a.symptoms, d.full_name AS doctor_name, d.department
          FROM appointment a
          LEFT JOIN doctors d ON a.doctor_username = d.username
          WHERE a.full_name = ?
          ORDER BY a.appointment_date DESC"; 

$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "s", $patient_full_name);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View My Appointments</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        @media (max-width: 768px) {
            .col-md-2 {
                width: 100% !important;
                margin-left: 0 !important;
            }

            .col-md-10 {
                width: 100% !important;
            }
        }

        /* Adjust table cell text to prevent overflow */
        table th,
        table td {
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div>
        <?php include("header.php"); ?>
    </div>
    <div class="container-fluid">
        <div class="row">
            <?php include("sidenav.php"); ?>
            <div class="col-md-10">
                <h5 class="text-center mt-3">My Appointments</h5>
                
                <?php
                if (mysqli_num_rows($res) < 1) {
                    echo "<div class='alert alert-warning'>You have no appointments.</div>";
                } else {
                    echo "
                    <div class='table-responsive'>
                        <table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>Appointment Date</th>
                                    <th>Symptoms</th>
                                    <th>Status</th>
                                    <th>Doctor Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>";

                    while ($row = mysqli_fetch_assoc($res)) {
                        $cancel_button = '';
                        if ($row['status'] == 'pending') {
                            $cancel_button = "<a href='view_appointments.php?cancel_appointment_id=" . htmlspecialchars($row['id']) . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to cancel this appointment?\");'>Cancel</a>";
                        }

                        echo "<tr>
                                <td>" . htmlspecialchars($row['appointment_date']) . "</td>
                                <td>" . htmlspecialchars($row['symptoms']) . "</td>
                                <td>" . htmlspecialchars($row['status']) . "</td>
                                <td>" . htmlspecialchars($row['doctor_name']) . "</td>
                                <td>" . $cancel_button . "</td>
                              </tr>";
                    }

                    echo "</tbody>
                          </table>
                    </div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>
