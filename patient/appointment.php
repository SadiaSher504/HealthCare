<?php
include("header.php");
include('../include/connection.php');

// Patient session handling
$pat = $_SESSION['patient'] ?? '';
if ($pat == '') {
    // Redirect or show an error if the session is not set.
    header("Location: login.php");
    exit();
}

$sel = mysqli_query($connect, "SELECT * FROM patient WHERE username='$pat'");
$row = mysqli_fetch_array($sel);

$name = $row['full_name'];
$phone = $row['phone'];

$alert = ""; // Variable to store alerts

// Check if the form is submitted
if (isset($_POST['book'])) {
    $date = $_POST['date'];
    $sym = $_POST['symptoms'];
    $doctor_username = $_POST['doctor'];

    // Check if all fields are filled
    if (empty($sym) || empty($doctor_username) || empty($date)) {
        $alert = "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please fill all fields properly.',
                            confirmButtonText: 'OK'
                        });
                    });
                  </script>";
    } else {
        // Sanitize input data
        $date = mysqli_real_escape_string($connect, $date);
        $sym = mysqli_real_escape_string($connect, $sym);
        $doctor_username = mysqli_real_escape_string($connect, $doctor_username);

        // Insert the appointment into the database
        $query = "INSERT INTO appointment (full_name, phone, appointment_date, symptoms, doctor_username, status, date_booked) 
                  VALUES ('$name', '$phone', '$date', '$sym', '$doctor_username', 'Pending', NOW())";

        $res = mysqli_query($connect, $query);

        // Set alert message based on the result
        if ($res) {
            $alert = "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'success',
                                title: 'Appointment Booked',
                                text: 'Your appointment has been booked successfully!',
                                confirmButtonText: 'OK'
                            });
                        });
                      </script>";
        } else {
            $alert = "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There was an issue booking your appointment. Please try again.',
                                confirmButtonText: 'OK'
                            });
                        });
                      </script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Book Appointment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- SweetAlert -->
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

    <div class="container-fluid">
        <div class="row">
       
            <!-- Sidebar -->
            <div class="col-md-2 p-0">
                <div class="sidebar bg-info" id="sidebar">
                    <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="profile.php"><i class="fa fa-user-circle"></i> Profile</a>
                    <a href="appointment.php" class="active"><i class="fa-solid fa-calendar-check"></i> Book Appointment</a>
                    <a href="invoice.php"><i class="fa-solid fa-file-invoice"></i> Invoices</a>
                    <a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-10">
                <h3 class="text-center my-4 font-weight-bold text-info">Book Your Appointment</h3>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow-lg rounded-lg border-0">
                            <div class="card-header bg-info text-white text-center">
                                <h5 class="mb-0">Appointment Details</h5>
                            </div>
                            <div class="card-body p-4">
                                <form method="post">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Select Department</label>
                                        <select name="department" id="department" class="form-control" required>
                                            <option value="">-- Select Department --</option>
                                            <?php
                                            $dept_query = mysqli_query($connect, "SELECT DISTINCT department FROM doctors WHERE status='Approved'");
                                            while ($dept = mysqli_fetch_array($dept_query)) {
                                                echo '<option value="' . $dept['department'] . '">' . $dept['department'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Select Doctor</label>
                                        <select name="doctor" id="doctor" class="form-control" required>
                                            <option value="">-- Select Doctor --</option>
                                        </select>
                                    </div>

                                    <div id="doctorAvailability" class="mt-3" style="display:none;">
                                        <div class="alert alert-info">
                                            <h6 class="mb-1"><strong>Doctor Availability:</strong></h6>
                                            <p id="availabilityDays" class="mb-0"></p>
                                            <p id="availabilityTime" class="mb-0"></p>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Appointment Date</label>
                                        <input type="date" name="date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="font-weight-bold">Symptoms</label>
                                        <input type="text" name="symptoms" class="form-control" autocomplete="off" placeholder="Enter Symptoms" required>
                                    </div>

                                    <button type="submit" name="book" class="btn btn-info btn-block font-weight-bold">Book Appointment</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- JS for Sidebar & Doctor Loading -->
    <script>
        $(document).ready(function() {
            $('#department').change(function() {
                var department = $(this).val();
                if (department != '') {
                    $.ajax({
                        url: "fetch_doctors.php",
                        method: "POST",
                        data: {
                            department: department
                        },
                        success: function(data) {
                            $('#doctor').html(data);
                        }
                    });
                }
            });

            $('#doctor').change(function() {
                var selected = $(this).find('option:selected');
                var days = selected.data('days');
                var from = selected.data('from');
                var to = selected.data('to');

                if (days && from && to) {
                    $('#doctorAvailability').show();
                    $('#availabilityDays').html("<b>Days:</b> " + days);
                    $('#availabilityTime').html("<b>Time:</b> " + from + " - " + to);
                } else {
                    $('#doctorAvailability').hide();
                }
            });
        });
    </script>
    <?php
    if (!empty($alert)) {
        echo $alert;
    }
    ?>
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
