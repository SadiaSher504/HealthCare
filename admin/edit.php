<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
    <!-- Bootstrap CSS added for responsiveness -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- SweetAlert2 CDN -->
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
            background-color: rgba(255, 255, 255, 0.4); /* Active link highlight */
        }

        /* Dark Overlay */
        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1040;
            display: none;
        }

        /* Mobile Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                height: 100%;
                background: #17a2b8;
                z-index: 1050;
                overflow-y: auto;
                padding-top: 60px;
            }

            .sidebar.show {
                left: 0;
            }
        }

        #sidebarToggle {
            margin: 10px;
        }

        table th,
        table td {
            white-space: nowrap;
        }

        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <?php 
    include("header.php");
    include("../include/connection.php");
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM doctors WHERE id='$id'";
        $res = mysqli_query($connect, $query);
        $row = mysqli_fetch_array($res);
    }
    
    if (isset($_POST['update'])) {
        $salary = $_POST['salary'];
        $q = "UPDATE doctors SET salary='$salary' WHERE id='$id'";
        $result = mysqli_query($connect, $q);
        
        if ($result) {
            echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Salary Updated!",
                    text: "Doctor salary updated successfully!",
                    confirmButtonColor: "#28a745"
                });
            </script>';
            // Re-fetch updated doctor details
            $query = "SELECT * FROM doctors WHERE id='$id'";
            $res = mysqli_query($connect, $query);
            $row = mysqli_fetch_array($res);
        } else {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong. Please try again!",
                    confirmButtonColor: "#dc3545"
                });
            </script>';
        }
    }
    ?>

    <div id="overlay"></div>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidenav -->
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

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Edit Doctor</h3>
                        <div class="row">
                            <div class="col-lg-7 mb-4">
                                <div class="card card-custom">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0">Doctor Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>ID:</strong> <?php echo $row['id'] ?></p>
                                        <p><strong>Full Name:</strong> <?php echo $row['full_name'] ?></p>
                                        <p><strong>Username:</strong> <?php echo $row['username'] ?></p>
                                        <p><strong>Salary:</strong> RS <?php echo number_format($row['salary']) ?></p>
                                        <p><strong>Department:</strong> <?php echo $row['department'] ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="card card-custom">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">Update Salary</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label for="salary">Enter Doctor's Salary</label>
                                                <input type="number" name="salary" id="salary" class="form-control" required autocomplete="off" placeholder="Enter doctor's salary" value="<?php echo $row['salary'] ?>">
                                            </div>
                                            <button type="submit" name="update" class="btn btn-success btn-block">Update Salary</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");
        const sidebarToggle = document.getElementById("sidebarToggle");

        sidebarToggle.addEventListener("click", function (e) {
            e.stopPropagation();
            sidebar.classList.toggle("show");
            overlay.style.display = sidebar.classList.contains("show") ? "block" : "none";
        });

        overlay.addEventListener("click", function () {
            sidebar.classList.remove("show");
            overlay.style.display = "none";
        });

        document.addEventListener("click", function (event) {
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
    </script>
</body>

</html>
