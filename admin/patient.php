<?php
//session_start();
include("../include/connection.php"); // Include the database connection
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Patients</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .card-custom {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .table th,
        .table td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .btn-custom {
            background-color: #17a2b8;
            color: white;
            border-radius: 5px;
        }

        .btn-custom:hover {
            background-color: #138496;
            color: white;
        }

        .alert-custom {
            background-color: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .table th,
            .table td {
                padding: 8px;
            }

            .btn-custom {
                font-size: 12px;
            }
        }
    </style>
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

        /* Mobile Sidebar */
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

        /* Dashboard Cards */
        .dashboard-card {
            height: 130px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            color: white;
            margin-bottom: 15px;
        }

        .icon-container {
            font-size: 2rem;
        }

        /* Header Navbar
        nav.navbar {
            /* margin-bottom: 20px; 
        } 

        /* Toggle Button */
        #sidebarToggle {
            margin-top: -10px;
            margin-left: 10px;
        }

        .sidebar a.active {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>

<body>
    <div>
        <?php include("header.php"); ?>
    </div>
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

            <div class="col-md-10 p-4">
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h5 class="text-center mt-3 font-weight-bold text-info">Total Patients</h5>

                        <?php
                        // Check if the connection is valid
                        if (!$connect) {
                            die("<div class='alert alert-custom p-3'>Database Connection Failed: " . mysqli_connect_error() . "</div>");
                        }

                        $query = "SELECT * FROM patient";
                        $res = mysqli_query($connect, $query);

                        if (!$res) {
                            die("<div class='alert alert-custom p-3'>Query Failed: " . mysqli_error($connect) . "</div>");
                        }

                        echo "<div class='table-responsive'>
                            <table class='table table-bordered'>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>";

                        if (mysqli_num_rows($res) < 1) {
                            echo "<tr><td colspan='5' class='text-center'>No Patient Yet</td></tr>";
                        } else {
                            while ($row = mysqli_fetch_array($res)) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($row['id']) . "</td>
                                    <td>" . htmlspecialchars($row['full_name']) . "</td>
                                    <td>" . htmlspecialchars($row['username']) . "</td>
                                    <td>" . htmlspecialchars($row['email']) . "</td>
                                    <td>
                                        <a href='view.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-info btn-custom'>View</a>
                                    </td>
                                </tr>";
                            }
                        }

                        echo "</tbody>
                            </table>
                        </div>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
