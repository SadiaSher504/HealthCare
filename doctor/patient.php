<?php
session_start();
include("../include/connection.php"); // Include the database connection

// Check if doctor is logged in
if (!isset($_SESSION['doctor_username'])) {
    header("Location: ../doctor_login.php");
    exit();
}

// Get the logged-in doctor's username
$doctor_username = $_SESSION['doctor_username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Patients</title>
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
                <h5 class="text-center mt-3">My Patients</h5>

                <?php
                if (!$connect) {
                    die("<div class='alert alert-danger'>Database Connection Failed: " . mysqli_connect_error() . "</div>");
                }

                // Fetch unique patients (based on patient name) assigned to this doctor, excluding those with status "pending"
                $query = "SELECT a.full_name AS patient_name, a.phone AS patient_phone, a.status AS appointment_status, a.symptoms AS patient_symptoms, p.email AS patient_email, a.appointment_date
                          FROM appointment a
                          LEFT JOIN patient p ON a.full_name = p.full_name
                          WHERE a.doctor_username = ? AND a.status != 'pending' 
                          GROUP BY a.full_name  /* Ensure only unique patients based on their full name */
                          ORDER BY a.appointment_date DESC";  /* Sorting by appointment date in descending order */

                // Prepare the statement
                $stmt = mysqli_prepare($connect, $query);

                if ($stmt === false) {
                    // Error preparing the query
                    die("<div class='alert alert-danger'>Error preparing query: " . mysqli_error($connect) . "</div>");
                }

                // Bind the doctor username to the statement
                mysqli_stmt_bind_param($stmt, "s", $doctor_username);

                // Execute the statement
                $execute = mysqli_stmt_execute($stmt);

                if (!$execute) {
                    // Error executing the query
                    die("<div class='alert alert-danger'>Error executing query: " . mysqli_stmt_error($stmt) . "</div>");
                }

                // Get the result of the query
                $res = mysqli_stmt_get_result($stmt);

                if (!$res) {
                    die("<div class='alert alert-danger'>Query Failed: " . mysqli_error($connect) . "</div>");
                }

                // Check if there are no rows
                if (mysqli_num_rows($res) < 1) {
                    echo "<div class='alert alert-warning'>No appointments found for this doctor.</div>";
                }

                echo "
                <div class='table-responsive'>
                    <table class='table table-bordered'>
                        <tr>
                            <th>Full Name</th>
                            <th>Phone</th>
                           
                            <th>Email</th>
                            <th>First Appointment Date</th>
                            <th>Action</th>
                        </tr>";

                while ($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['patient_name']) . "</td>
                        <td>" . htmlspecialchars($row['patient_phone']) . "</td>
                       
                        <td>" . htmlspecialchars($row['patient_email']) . "</td>
                        <td>" . htmlspecialchars($row['appointment_date']) . "</td>
                        <td>
                            <a href='view.php?id=" . htmlspecialchars($row['patient_name']) . "' class='btn btn-info'>View</a>
                        </td>
                    </tr>";
                }

                echo "</table>
                </div>";
                ?>

            </div>
        </div>
    </div>
</body>

</html>
