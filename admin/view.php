<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
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

       
    </style>

<style>
    .card {
        background: #fff;
        transition: 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        
    }

    .card-title {
        font-weight: bold;
    }

    .card-text i {
        color: #17a2b8;
    }
</style>


</head>
<body>

<div> 
    <?php 
        include("header.php");
        include("../include/connection.php");
    ?>
</div>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Section -->
        <div class="col-md-2 p-0">
                <div class="sidebar" id="sidebar">
                    <a href="index.php" id="dashboardLink"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="admin.php" id="adminLink"><i class="fas fa-user-shield"></i> Administration</a>
                    <a href="doctor.php" id="doctorLink"><i class="fas fa-user-md"></i> Doctors</a>
                    <a href="patient.php" id="patientLink"><i class="fas fa-hospital-user"></i> Patients</a>
                    <a href="job_request.php" id="staffLink"><i class="fas fa-address-card"></i> Add Staff</a>
                    <a href="report.php"><i class="fas fa-file-medical-alt"></i> Reports</a>
                    <a href="staff.php"><i class="fas fa-address-card"></i> Staff</a>
                    <a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>
    <!-- Main Content Section (Right Side) -->
<!-- Main Content Section (Right Side) -->
<div class="col-md-10">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3 class="text-center my-4 " style="color: #17a2b8;">Patients List</h3>

            <?php
            $query = "SELECT * FROM patient"; // Fetch all patients
            $res = mysqli_query($connect, $query);

            if (mysqli_num_rows($res) > 0) {
                echo '<div class="row">';
                while ($row = mysqli_fetch_array($res)) {
                    ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card shadow-sm border-0 rounded-3 h-100">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="fas fa-user-circle" style="font-size: 3.5rem; color: #17a2b8;"></i>
                                </div>
                                <h5 class="card-title mb-2"><?php echo htmlspecialchars($row['full_name']); ?></h5>
                                <p class="card-text small text-muted mb-1"><i class="fas fa-id-badge"></i> ID: <?php echo htmlspecialchars($row['id']); ?></p>
                                <p class="card-text small text-muted mb-1"><i class="fas fa-user"></i> Username: <?php echo htmlspecialchars($row['username']); ?></p>
                                <p class="card-text small text-muted"><i class="fas fa-phone"></i> Phone: <?php echo htmlspecialchars($row['phone']); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                echo '</div>';
            } else {
                echo "<h6 class='text-center text-danger'>No Patients Found</h6>";
            }
            ?>
        </div>
    </div>
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
