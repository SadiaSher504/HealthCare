<?php
session_start();
include("../include/connection.php");

// Check if doctor is logged in
if (!isset($_SESSION['doctor_username'])) {
    echo "You must be logged in to view appointments.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointments</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            color: white;
            text-decoration: none;
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
                    <a href="profile.php"><i class="fas fa-user-md"></i> My Profile</a>
                    <a href="appointment.php"><i class="fas fa-calendar-check"></i> Appointments</a>
                    <a href="patient.php"><i class="fas fa-procedures"></i> Patients</a>
                    <a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <div class="col-md-10 p-4">
                <h5 class="text-center my-2">My Pending Appointments</h5>

                <div class="table-responsive">
                    <?php
                    $doctor_username = $_SESSION['doctor_username'];

                    $query = "SELECT * FROM appointment WHERE doctor_username = '$doctor_username' AND status = 'Pending'";
                    $res = mysqli_query($connect, $query);

                    $output = "<div class='card card-custom'>
                        <div class='card-body'>
                        <table class='table table-bordered'>
                        <thead class='thead-light'>
                            <tr>
                                <th>ID</th>
                                <th>Fullname</th>
                                <th>Phone</th>
                                <th>Appointment Date</th>
                                <th>Symptoms</th>
                                <th>Date Booked</th>
                                <th>Action</th>
                            </tr>
                        </thead><tbody>";

                    if (mysqli_num_rows($res) < 1) {
                        $output .= "<tr><td class='text-center' colspan='7'>No Appointments Yet</td></tr>";
                    } else {
                        while ($row = mysqli_fetch_array($res)) {
                            $output .= "<tr>
                                <td>" . htmlspecialchars($row['id']) . "</td>
                                <td>" . htmlspecialchars($row['full_name']) . "</td>
                                <td>" . htmlspecialchars($row['phone']) . "</td>
                                <td>" . htmlspecialchars($row['appointment_date']) . "</td>
                                <td>" . htmlspecialchars($row['symptoms']) . "</td>
                                <td>" . htmlspecialchars($row['date_booked']) . "</td>
                                <td>
                                    <a href='discharge.php?id=" . $row['id'] . "'>
                                        <button class='btn btn-info btn-sm'>Check</button>
                                    </a>
                                </td>
                            </tr>";
                        }
                    }

                    $output .= "</tbody></table>
                        </div>
                    </div>";
                    echo $output;
                    ?>
                </div>

            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- <script>
        document.getElementById("sidebarToggle")?.addEventListener("click", function(event) {
            document.getElementById("sidebar").classList.toggle("show");
            event.stopPropagation();
        });

        document.addEventListener("click", function(event) {
            let sidebar = document.getElementById("sidebar");
            let toggleButton = document.getElementById("sidebarToggle");
            if (!sidebar.contains(event.target) && (!toggleButton || !toggleButton.contains(event.target))) {
                sidebar.classList.remove("show");
            }
        });

        const currentLocation = window.location.href;
        const menuItems = document.querySelectorAll('.sidebar a');

        menuItems.forEach(item => {
            if (item.href === currentLocation) {
                item.classList.add('active');
            }
        });
    </script> -->

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