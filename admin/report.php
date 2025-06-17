<?php
include("header.php");
include("../include/connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Reports</title>

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        /* Sidebar */
        .sidebar {
            height: 100vh;
            background: #17a2b8;
            padding-top: 20px;
            transition: all 0.3s;
        }
        .sidebar a {
            display: block;
            padding: 12px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            transition: background 0.3s;
        }
        .sidebar a:hover, .sidebar a.active {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
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
        }
        /* Dashboard */
        .card-custom {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }
        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

<!-- Sidebar -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-md-2 p-0">
            <div class="sidebar bg-info" id="sidebar">
                <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="admin.php"><i class="fas fa-user-shield"></i> Administration</a>
                <a href="doctor.php"><i class="fas fa-user-md"></i> Doctors</a>
                <a href="patient.php"><i class="fas fa-hospital-user"></i> Patients</a>
                <a href="job_request.php"><i class="fas fa-address-card"></i> Add Staff</a>
                <a href="report.php"><i class="fas fa-file-medical-alt"></i> Reports</a>
                <a href="staff.php"><i class="fas fa-address-card"></i> Staff</a>
                <a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                <h5 class="text-center w-100">Patient Reports</h5>
            </div>

            <div class="card card-custom mb-4">
                <div class="card-header bg-primary text-white text-center">
                    <h6 class="mb-0">Reports Overview</h6>
                </div>
                <div class="card-body">
                    <?php
                    // Query to fetch reports and associated patient names
                    $query = "SELECT r.id AS report_id, p.full_name AS patient_name, r.fullname AS report_title, r.data_send, r.created_at 
                              FROM report r
                              JOIN patient p ON r.username = p.username";

                    $res = mysqli_query($connect, $query);

                    if (!$res) {
                        echo "<div class='alert alert-danger'>Error fetching reports: " . htmlspecialchars(mysqli_error($connect)) . "</div>";
                    } else {
                        if (mysqli_num_rows($res) > 0) {
                            echo "<div class='table-responsive'>
                                    <table class='table table-bordered table-hover'>
                                        <thead class='thead-light'>
                                            <tr>
                                                <th>ID</th>
                                                <th>Patient Name</th>
                                                <th>Report Title</th>
                                                <th>Report Date</th>
                                                <th>Date Sent</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
                            while ($row = mysqli_fetch_assoc($res)) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['report_id']) . "</td>
                                        <td>" . htmlspecialchars($row['patient_name']) . "</td>
                                        <td>" . htmlspecialchars($row['report_title']) . "</td>
                                        <td>" . htmlspecialchars($row['data_send']) . "</td>
                                        <td>" . htmlspecialchars($row['created_at']) . "</td>
                                    </tr>";
                            }
                            echo "</tbody></table></div>";
                        } else {
                            echo "<div class='text-center text-muted'>No Reports Available</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sidebar Toggle Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const sidebar = document.getElementById("sidebar");

        // Toggle sidebar on small screens
        document.getElementById("sidebarToggle")?.addEventListener("click", function(e) {
            sidebar.classList.toggle("show");
            e.stopPropagation();
        });

        document.addEventListener("click", function(e) {
            if (!sidebar.contains(e.target) && !e.target.closest("#sidebarToggle")) {
                sidebar.classList.remove("show");
            }
        });

        // Add Active Class
        const currentLocation = window.location.href;
        const menuItems = document.querySelectorAll('.sidebar a');

        menuItems.forEach(item => {
            if (item.href === currentLocation) {
                item.classList.add('active');
            }
        });
    });
</script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
