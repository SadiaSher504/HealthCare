<?php
include("../include/connection.php"); // Include the database connection
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Employees and Account Branch</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

        /* Sidebar */
        .sidebar {
            height: 100%;
            background: #17a2b8;
            padding-top: 20px;
            transition: all 0.3s ease-in-out;
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

        .sidebar .active {
            background-color: rgba(255, 255, 255, 0.4);
            
        }

        /* Table Styling */
        .card-table {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .table th {
            background-color: #17a2b8;
            color: #fff;
            text-align: center;
            vertical-align: middle;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(23, 162, 184, 0.1);
        }

        .btn-info {
            background-color: #17a2b8;
            border: none;
            transition: 0.3s;
        }

        .btn-info:hover {
            background-color: #138496;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .main-content {
                padding: 10px;
            }

            .card-table {
                padding: 15px;
            }

            .table th,
            .table td {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>
    <?php include("header.php"); ?>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0">
                <div class="sidebar" id="sidebar">
                    <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="admin.php"><i class="fas fa-user-shield"></i> Administration</a>
                    <a href="doctor.php"><i class="fas fa-user-md"></i> Doctors</a>
                    <a href="patient.php"><i class="fas fa-hospital-user"></i> Patients</a>
                    <a href="job_request.php"><i class="fas fa-address-card"></i> Add Staff</a>
                    <a href="report.php"><i class="fas fa-file-medical-alt"></i> Reports</a>
                    <a href="staff.php"><i class="fas fa-address-card"></i> Staff</a>
                    <a href="../login/logout.php "><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 col-12 main-content">
                <h5 class="text-center">Employee and Account Branch Data</h5>

                <!-- Employee Table -->
                <div class="card-table table-responsive">
                    <h5>Employee Data</h5>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Salary</th>
                                <!-- <th>Action</th><td>
                                            <a href='edit_employee.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-info btn-sm'>Edit</a>
                                        </td> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM employee WHERE status='approved'";
                            $res = mysqli_query($connect, $query);
                            if (!$res) {
                                die("<div class='alert alert-danger'>Query Failed: " . mysqli_error($connect) . "</div>");
                            }

                            if (mysqli_num_rows($res) < 1) {
                                echo "<tr><td colspan='7' class='text-center'>No Approved Employees Yet</td></tr>";
                            } else {
                                while ($row = mysqli_fetch_array($res)) {
                                    echo "<tr>
                                        <td>" . htmlspecialchars($row['id']) . "</td>
                                        <td>" . htmlspecialchars($row['full_name']) . "</td>
                                        <td>" . htmlspecialchars($row['username']) . "</td>
                                        <td>" . htmlspecialchars($row['email']) . "</td>
                                        <td>" . htmlspecialchars($row['department']) . "</td>
                                        <td>" . htmlspecialchars($row['salary']) . "</td>
                                        
                                    </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Account Branch Table -->
                <div class="card-table table-responsive mt-4">
                    <h5>Account Branch Data</h5>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Status</th>
                                <!-- <th>Salary</th> -->
                                <!-- <th>Action</th> <td>
                                        //     <a href='edit_account_branch.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-info btn-sm'>Edit</a>
                                        // </td> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM account_branch WHERE status='approved'";
                            $res = mysqli_query($connect, $query);
                            if (!$res) {
                                die("<div class='alert alert-danger'>Query Failed: " . mysqli_error($connect) . "</div>");
                            }

                            if (mysqli_num_rows($res) < 1) {
                                echo "<tr><td colspan='7' class='text-center'>No Approved Account Branch Members Yet</td></tr>";
                            } else {
                                while ($row = mysqli_fetch_array($res)) {
                                    echo "<tr>
                                        <td>" . htmlspecialchars($row['id']) . "</td>
                                        <td>" . htmlspecialchars($row['full_name']) . "</td>
                                        <td>" . htmlspecialchars($row['username']) . "</td>
                                        <td>" . htmlspecialchars($row['email']) . "</td>
                                        <td>" . htmlspecialchars($row['status']) . "</td>
                                        
                                        
                                    </tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
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
