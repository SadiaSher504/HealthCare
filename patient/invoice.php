<?php
session_start();
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Invoice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @media (max-width: 768px) {
            .content-container {
                width: 100% !important;

            }
        }
    </style>
    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- jQuery -->
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
        <?php include("header.php");
        include('../include/connection.php');
        ?>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0">
                <div class="sidebar bg-info" id="sidebar">
                    <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="profile.php"><i class="fa fa-user-circle"></i> Profile</a>
                    <a href="appointment.php"><i class="fa-solid fa-calendar-check"></i> Book Appointment</a>
                    <a href="invoice.php"><i class="fa-solid fa-file-invoice"></i> Invoices</a>
                    <a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>

                </div>
            </div>
            <div class="col-md-10 content-container">

                <h5 class="text-center my-2">My Invoice</h5>

                <?php
                $pat = $_SESSION['patient'];
                $query = "SELECT * FROM patient WHERE username='$pat'";
                $res = mysqli_query($connect, $query);
                $row = mysqli_fetch_array($res);
                $fname = $row['full_name'];

                $query = mysqli_query($connect, "SELECT * FROM income WHERE patient='$fname'");

                $output = "<div class='table-responsive'>
                    <table class='table table-bordered'>
                        <tr>
                            <th>ID</th>
                            <th>Doctor</th>
                            <th>Patient</th>
                            <th>Discharge Date</th>
                            <th>Amount Paid</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>";

                if (mysqli_num_rows($query) < 1) {
                    $output .= "<tr><td colspan='7' class='text-center'>No Invoice Yet</td></tr>";
                }
                while ($row = mysqli_fetch_array($query)) {
                    $output .= "  
                        <tr>
                            <td>" . $row['id'] . "</td>
                            <td>" . $row['doctor'] . "</td>
                            <td>" . $row['patient'] . "</td>
                            <td>" . $row['date_discharge'] . "</td>
                            <td>" . $row['amount_paid'] . "</td>
                            <td>" . $row['description'] . "</td>
                            <td>
                                <a href='view.php?id=" . $row['id'] . "'>
                                     <button class='btn btn-info btn-sm mb-1'>View</button>
                                </a>
                                <a href='download_invoice.php?id=" . $row['id'] . "' target='_blank'>
                                       <button class='btn btn-success btn-sm'>Download</button>
                                </a>
                            </td>
                        </tr>";
                }
                $output .= "</table></div>";
                echo $output;
                ?>
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