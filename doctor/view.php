<?php
session_start();
include("../include/connection.php");

if (!isset($_SESSION['doctor_username'])) {
    header("Location: ../doctor_login.php");
    exit();
}

$doctor_username = $_SESSION['doctor_username'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .card-custom {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .sidebar {
            height: 100vh;
            background: #17a2b8;
            padding-top: 20px;
            transition: 0.3s;
        }

        .sidebar a {
            display: block;
            padding: 12px;
            color: white;
            text-decoration: none;
            transition: 0.3s;
            font-weight: bold;
            text-align: center;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
        }

        .sidebar a.active {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
        }

        /* Center main content and set width to 50% */
        .main-content {
            width: 80%;
            margin: 0 auto;
            padding-top: 50px;
        }

        table th, table td {
            text-align: center;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                width: 250px;
                left: -250px;
                top: 0;
                z-index: 1050;
                padding-top: 50px;
            }

            .sidebar.show {
                left: 0;
            }

            /* Adjust for mobile view */
            .main-content {
                width: 90%;
            }
        }
    </style>
</head>

<body>
    <?php include("header.php"); ?>

    <!-- Main Content Section (Right Side) -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Section (Left Side) -->
            <div class="col-md-2 p-0">
                <div class="sidebar bg-info" id="sidebar">
                    <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="profile.php"><i class="fas fa-user-md"></i> My Profile</a>
                    <a href="appointment.php"><i class="fas fa-calendar-check"></i> Appointments</a>
                    <a href="patient.php"><i class="fas fa-procedures"></i> Patients</a>
                    <a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <!-- Main Content Section (Right Side) -->
            <div class="col-md-10">
                <div class="main-content">
                    <h3 class="text-center mb-4" style="color: #17a2b8; font-size: 32px; font-weight: 600;">Patient Appointments</h3>

                    <!-- Print Button -->
                    <div class="text-center mb-3">
                        <button class="btn btn-info" onclick="printTable()">Print Appointments</button>
                    </div>

                    <?php
                    $patient_name = mysqli_real_escape_string($connect, $_GET['id']);
                    // Query to fetch all appointments for the selected patient
                    $query = "SELECT a.id AS appointment_id, a.full_name AS patient_name, a.phone AS patient_phone, 
                    a.symptoms AS patient_symptoms, a.appointment_date, a.status AS appointment_status, p.email AS patient_email, p.username AS patient_username
                    FROM appointment a
                    LEFT JOIN patient p ON a.full_name = p.full_name  
                    WHERE a.full_name = '$patient_name' AND a.doctor_username = '$doctor_username' 
                    ORDER BY a.appointment_date DESC";

                    $res = mysqli_query($connect, $query);

                    // Check for query errors
                    if (!$res) {
                        echo "<p class='text-danger'>Error executing query: " . mysqli_error($connect) . "</p>";
                    } else {
                        if (mysqli_num_rows($res) > 0) {
                            // Fetch the patient's username
                            $patient_data = mysqli_fetch_assoc($res);
                            $patient_username = $patient_data['patient_username'];

                            // Display patient's username above the table
                            echo "<h4 class='text-center mb-4'>Username: " . htmlspecialchars($patient_username) . "</h4>";

                            // Reset the result pointer to the start
                            mysqli_data_seek($res, 0);

                            echo "<div class='table-responsive' id='appointmentTable'>";
                            echo "<table class='table table-bordered table-striped'>
                                    <thead>
                                        <tr>
                                            <th>Appointment ID</th>
                                            <th>Symptoms</th>
                                            <th>Appointment Date</th>
                                            <th>Status</th>
                                            <th>Username</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

                            while ($row = mysqli_fetch_assoc($res)) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['appointment_id']) . "</td>
                                        <td>" . htmlspecialchars($row['patient_symptoms']) . "</td>
                                        <td>" . htmlspecialchars($row['appointment_date']) . "</td>
                                        <td>" . htmlspecialchars($row['appointment_status']) . "</td>
                                        <td>" . htmlspecialchars($row['patient_username']) . "</td>
                                    </tr>";
                            }
                            echo "</tbody></table>";
                            echo "</div>";
                        } else {
                            echo "<h6 class='text-center text-danger'>No appointments found for this patient.</h6>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Print function
        function printTable() {
            var printContent = document.getElementById('appointmentTable').innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
        }

        document.getElementById("sidebarToggle").addEventListener("click", function(event) {
            document.getElementById("sidebar").classList.toggle("show");
            event.stopPropagation();
        });

        document.addEventListener("click", function(event) {
            let sidebar = document.getElementById("sidebar");
            let toggleButton = document.getElementById("sidebarToggle");
            if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
                sidebar.classList.remove("show");
            }
        });

        // Add Active class to current link
        const currentLocation = window.location.href;
        const menuItems = document.querySelectorAll('.sidebar a');

        menuItems.forEach(item => {
            if (item.href === currentLocation) {
                item.classList.add('active');
            }
        });
    </script>

</body>

</html>
