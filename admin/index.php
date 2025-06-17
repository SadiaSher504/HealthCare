<?php
session_start();
include("../include/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Hospital Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <style>
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
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

        .sidebar {
            height: 100%;
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

        .dashboard-card {
            height: 130px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            color: white;
            margin-bottom: 15px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .dashboard-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .icon-container {
            font-size: 2rem;
        }

        #sidebarToggle {
            margin-top: -10px;
            margin-left: 10px;
        }

        #dashboardChart {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }




        .icon-container {
            font-size: 2.5rem;
        }

        /* Graph/Chart Styling */
        #dashboardChart {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        canvas {
            max-width: 100% !important;
            max-height: 100% !important;
        }

        /* Chart Container */
        .chart-container {
            width: 80%;
            /* Default width for larger screens */
            margin: 0 auto;
        }

        /* Make the chart container responsive on smaller screens */
        @media (max-width: 768px) {
            .chart-container {
                width: 100%;
                /* Full width on smaller screens */
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-info bg-info">
        <button class="btn btn-info d-md-none" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h5 class="text-white ml-3">HealthCare</h5>
        <div class="mr-auto"></div>
        <ul class="navbar-nav">
            <?php
            if (isset($_SESSION['admin'])) {
                $user = $_SESSION['admin'];
                echo '
                <li class="nav-item"><a href="admin.php" class="nav-link text-white">' . htmlspecialchars($user) . ' (Admin)</a></li>';
            } else {
                echo '<li class="nav-item"><a href="../index.php" class="nav-link text-white">Home</a></li>';
            }
            ?>
        </ul>
    </nav>
    <div id="overlay"></div>
    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
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

            <!-- MAIN CONTENT -->
            <div class="col-12 col-md-10">
                <h4 class="my-3 text-center mt-5 mb-5" style="color: #17a2b8;">Admin Dashboard</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="dashboard-card bg-success">
                            <div>
                                <h4><?php $ad = mysqli_query($connect, "SELECT * FROM admin");
                                    $adminCount = mysqli_num_rows($ad);
                                    echo $adminCount; ?></h4>
                                <p>Total Admins</p>
                            </div>
                            <div class="icon-container">
                                <a href="admin.php" class="text-white"><i class="fas fa-users-cog"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dashboard-card bg-info">
                            <div>
                                <h4><?php $doctor = mysqli_query($connect, "SELECT * FROM doctors WHERE status='approved'");
                                    $doctorCount = mysqli_num_rows($doctor);
                                    echo $doctorCount; ?></h4>
                                <p>Total Doctors</p>
                            </div>
                            <div class="icon-container">
                                <a href="doctor.php" class="text-white"><i class="fas fa-user-md"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dashboard-card bg-warning">
                            <div>
                                <h4><?php $patients = mysqli_query($connect, "SELECT * FROM patient");
                                    $patientCount = mysqli_num_rows($patients);
                                    echo $patientCount; ?></h4>
                                <p>Total Patients</p>
                            </div>
                            <div class="icon-container">
                                <a href="patient.php" class="text-white"><i class="fas fa-procedures"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row -->
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="dashboard-card bg-danger">
                            <div>
                                <h4><?php $complaints = mysqli_query($connect, "SELECT * FROM report");
                                    $complaintCount = mysqli_num_rows($complaints);
                                    echo $complaintCount; ?></h4>
                                <p>Total Complaints</p>
                            </div>
                            <div class="icon-container">
                                <a href="report.php" class="text-white"><i class="fas fa-stethoscope"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dashboard-card bg-dark">
                            <div>
                                <h4><?php
                                    // Fetch pending job requests from employees, doctors, and account branch
                                    $employeeRequests = mysqli_query($connect, "SELECT * FROM employee WHERE status='pending'");
                                    $doctorRequests = mysqli_query($connect, "SELECT * FROM doctors WHERE status='pending'");
                                    $accountBranchRequests = mysqli_query($connect, "SELECT * FROM account_branch WHERE status='pending'");

                                    $employeeCount = mysqli_num_rows($employeeRequests);
                                    $doctorCount = mysqli_num_rows($doctorRequests);
                                    $accountBranchCount = mysqli_num_rows($accountBranchRequests);

                                    $totalPendingRequests = $employeeCount + $doctorCount + $accountBranchCount;
                                    echo $totalPendingRequests;
                                    ?></h4>
                                <p>Job Requests</p>
                            </div>
                            <div class="icon-container">
                                <a href="job_request.php" class="text-white"><i class="fas fa-clipboard-list"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="dashboard-card bg-success">
                            <div>
                                <h4>$
                                    <?php
                                    $income = mysqli_query($connect, "SELECT SUM(amount_paid) AS profit FROM income");
                                    $row = mysqli_fetch_array($income);
                                    echo $row['profit'] ?? '0';
                                    ?>
                                </h4>
                                <p>Total Income</p>
                            </div>
                            <div class="icon-container">
                                <a href="income.php" class="text-white"><i class="fas fa-money-bill-wave"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-center mt-4">
                        <h5 class="text-center mb-4">Overview Chart</h5>
                        <div class="chart-container">
                            <canvas id="overviewChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>

        </div>




    </div>
    </div>
    </div>



    <!-- Sidebar Toggle Script -->
    <script>
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");
        const sidebarToggle = document.getElementById("sidebarToggle");

        sidebarToggle.addEventListener("click", function(e) {
            e.stopPropagation();
            sidebar.classList.toggle("show");
            overlay.style.display = sidebar.classList.contains("show") ? "block" : "none";
        });

        overlay.addEventListener("click", function() {
            sidebar.classList.remove("show");
            overlay.style.display = "none";
        });

        document.addEventListener("click", function(event) {
            if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove("show");
                overlay.style.display = "none";
            }
        });

        // Highlight the active link based on the current page
        const links = document.querySelectorAll('.sidebar a');
        links.forEach(link => {
            if (window.location.href.includes(link.href)) {
                link.classList.add('active');
            }
        });




        // Chart Data from PHP (now properly passed as JSON)
        const doctors = <?= mysqli_num_rows($doctor); ?>;
        const patients = <?= mysqli_num_rows($patients); ?>;
        const admins = <?= mysqli_num_rows($ad); ?>;
        const complaints = <?= mysqli_num_rows($complaints); ?>;
        const jobRequests = <?= $totalPendingRequests ?? 0; ?>; // Ensure this is safely fetched

        new Chart(document.getElementById('overviewChart'), {
            type: 'pie',
            data: {
                labels: ['Admins', 'Doctors', 'Patients', 'Complaints', 'Job Requests'],
                datasets: [{
                    backgroundColor: ['#4BC0C0', '#36A2EB', '#FFCE56', '#FF6384', '#9966FF'],
                    data: [admins, doctors, patients, complaints, jobRequests]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>

</body>

</html>