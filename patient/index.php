<?php
session_start();
error_reporting(0);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
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

        /* Dashboard Box */
        .dashboard-box {
            height: 150px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            color: white;
            margin-bottom: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .dashboard-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .dashboard-box {
                height: 120px;
            }
        }

        /* Toggle Button */
        #sidebarToggle {
            margin-top: -10px;
            margin-left: 10px;
        }
    </style>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
                    <a href="invoice.php"><i class="fas fa-file-invoice-dollar"></i> Invoices</a>
                    <a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <div class="col-md-10 content-container">
                <h5 class="text-center my-3">Patient Dashboard</h5>

                <div class="row justify-content-center">

                    <div class="col-md-3 bg-info mx-2 dashboard-box">
                        <div>
                            <h5>My Profile</h5>
                        </div>
                        <div class="text-right">
                            <a href="profile.php">
                                <i class="fa fa-user-circle fa-3x" style="color: white;"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3 bg-warning mx-2 dashboard-box">
                        <div>
                            <h5>Book Appointment</h5>
                        </div>
                        <div class="text-right">
                            <a href="appointment.php">
                                <i class="fas fa-calendar-check fa-3x" style="color: white;"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3 bg-success mx-2 dashboard-box">
                        <div>
                            <h5>My Invoice</h5>
                        </div>
                        <div class="text-right">
                            <a href="invoice.php">
                                <i class="fas fa-file-invoice-dollar fa-3x" style="color: white;"></i>
                            </a>
                        </div>
                    </div>

                </div>

                <?php
                if (isset($_POST['send'])) {
                    $data_send = $_POST['data_send'];
                    $fullname = $_POST['fullname'];

                    if (empty($data_send)) {
                        echo "<script>
        Swal.fire({
            icon: 'warning',
            title: 'Missing!',
            text: 'Report message is required',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
        </script>";
                    } else if (empty($fullname)) {
                        echo "<script>
        Swal.fire({
            icon: 'warning',
            title: 'Missing!',
            text: 'Full name is required',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
        </script>";
                    } else {
                        $user = $_SESSION['patient'];
                        $query = "INSERT INTO report (username, data_send, fullname, created_at) 
                  VALUES ('$user', '$data_send', '$fullname', NOW())";
                        $res = mysqli_query($connect, $query);

                        if ($res) {
                            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Report sent successfully',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
            </script>";
                        } else {
                            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Failed to send report',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Try Again'
            });
            </script>";
                        }
                    }
                }
                ?>



                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="jumbotron bg-info mt-4">
                            <h5 class="text-center text-white">Send A Report</h5>
                            <form method="post">
                                <label for="fullname" class="text-white">Title</label>
                                <input type="text" name="fullname" autocomplete="off" class="form-control" placeholder="Enter your full name">

                                <label for="data_send" class="text-white mt-2">Message</label>
                                <input type="text" name="data_send" autocomplete="off" class="form-control" placeholder="Enter your message">

                                <input type="submit" name="send" value="Send Report" class="btn btn-success my-3">
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        document.getElementById("sidebarToggle")?.addEventListener("click", function(event) {
            document.getElementById("sidebar").classList.toggle("show");
            event.stopPropagation();
        });

        document.addEventListener("click", function(event) {
            let sidebar = document.getElementById("sidebar");
            let toggleButton = document.getElementById("sidebarToggle");
            if (sidebar && toggleButton && !sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
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