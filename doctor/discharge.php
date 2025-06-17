<?php
session_start();
error_reporting(0);
include("../include/connection.php");

$alertMessage = ''; // Variable to store alert message

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM appointment WHERE id = '$id'";
    $res = mysqli_query($connect, $query);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
    } else {
        echo "<script>Swal.fire('Error', 'Appointment not found!', 'error').then(() => { window.location.href='report.php'; });</script>";
        exit();
    }
}

// Handle Invoice Submission
if (isset($_POST['send'])) {
    $fee = mysqli_real_escape_string($connect, $_POST['fee']);
    $description = mysqli_real_escape_string($connect, $_POST['description']);

    if (empty($fee) || empty($description)) {
        $alertMessage = "All fields are required!";
    } else {
        $doc = isset($_SESSION['doctor']) ? $_SESSION['doctor'] : '';
        $fname = isset($row['full_name']) ? $row['full_name'] : '';

        $query = "INSERT INTO income (doctor, patient, date_discharge, amount_paid, description) 
                  VALUES ('$doc', '$fname', NOW(), '$fee', '$description')";
        $res = mysqli_query($connect, $query);
        mysqli_query($connect, "UPDATE appointment SET status='Discharge' WHERE id='$id' AND doctor_username='{$_SESSION['doctor_username']}'");

        if ($res) {
            $alertMessage = "Invoice sent successfully!";
            // We set a flag for success here and handle the redirect via JavaScript
        } else {
            $alertMessage = "Failed to send invoice!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Patient Appointment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        html,
        body {
            max-height: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            height: 100vh;
            background: #17a2b8;
            padding-top: 20px;
            transition: 0.3s;
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

        .sidebar a {
            display: block;
            padding: 12px;
            color: white;
            text-decoration: none;
            text-align: center;
            font-weight: bold;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                width: 250px;
                left: -250px;
                top: 0;
                z-index: 1050;
                overflow-y: auto;
            }

            .sidebar.show {
                left: 0;
            }

            #overlay {
                display: block;
            }
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.5);
            width: 100%;
            height: 100%;
            display: none;
            z-index: 1040;
        }
    </style>
</head>

<body>

    <?php include("header.php"); ?>

    <!-- Sidebar Toggle Button -->

    <!-- Overlay -->
    <div id="overlay"></div>

    <div class="container-fluid">
        <div class="row" style="height:100%;">


            <!-- Sidebar -->
            <div class="col-12 col-md-2 p-0">
                <div class="sidebar bg-info" id="sidebar">
                    <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="profile.php"><i class="fas fa-user-md"></i> My Profile</a>
                    <a href="appointment.php"><i class="fas fa-calendar-check"></i> Appointments</a>
                    <a href="patient.php"><i class="fas fa-procedures"></i> Patients</a>
                    <a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <div class="card card-custom mb-4">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Patient Appointment Details</h3>

                        <div class="row">
                            <!-- Appointment Details -->
                            <div class="col-md-6">
                                <div class="card card-custom">
                                    <div class="card-header bg-info text-white text-center">
                                        <h5>Appointment Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Full Name</th>
                                                <td><?php echo $row['full_name']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Phone Number</th>
                                                <td><?php echo $row['phone']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Appointment Date</th>
                                                <td><?php echo $row['appointment_date']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Symptoms</th>
                                                <td><?php echo $row['symptoms']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Invoice Form -->
                            <div class="col-md-6">
                                <div class="card card-custom">
                                    <div class="card-header bg-success text-white text-center">
                                        <h5>Create Invoice</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <label>Fee</label>
                                                <input type="number" name="fee" class="form-control" placeholder="Enter Patient Fee" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input type="text" name="description" class="form-control" placeholder="Enter Description" required>
                                            </div>
                                            <button type="submit" name="send" class="btn btn-info btn-block">Send Invoice</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- Row End -->

                    </div> <!-- Card Body End -->
                </div>
            </div>

        </div>
    </div>

    <!-- Sidebar Script -->
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

        // Show SweetAlert and Redirect if message is set
        <?php if ($alertMessage): ?>
            Swal.fire({
                title: '<?php echo ($alertMessage == "Invoice sent successfully!") ? "Success" : "Error"; ?>',
                text: '<?php echo $alertMessage; ?>',
                icon: '<?php echo ($alertMessage == "Invoice sent successfully!") ? "success" : "error"; ?>',
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                window.location.href = 'appointment.php';
            });
        <?php endif; ?>

        // Highlight active sidebar link
        const links = document.querySelectorAll('.sidebar a');
        links.forEach(link => {
            if (window.location.href.includes(link.getAttribute('href'))) {
                link.classList.add('active');
            }
        });
    </script>

</body>

</html>