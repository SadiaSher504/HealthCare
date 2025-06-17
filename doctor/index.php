<?php
session_start();
include("../include/connection.php");

// Get today's date
$date_today = date('Y-m-d');

// Fetch today's appointments and other data with prepared statements for security
$doctor_username = $_SESSION['doctor_username'];

// Fetch today's appointments
$query_today_appointments = mysqli_prepare($connect, "SELECT * FROM appointment WHERE appointment_date = ? AND doctor_username = ?");
mysqli_stmt_bind_param($query_today_appointments, 'ss', $date_today, $doctor_username);
mysqli_stmt_execute($query_today_appointments);
$result_today_appointments = mysqli_stmt_get_result($query_today_appointments);
$today_appointments_count = mysqli_num_rows($result_today_appointments);

// Fetch total patients
// Fetch total distinct patients by their names from appointments (based on doctor's username)
// Get total distinct patients for the doctor
$query_patients = mysqli_prepare($connect, "
    SELECT DISTINCT full_name 
    FROM appointment 
    WHERE doctor_username = ?");
mysqli_stmt_bind_param($query_patients, 's', $doctor_username);
mysqli_stmt_execute($query_patients);
$result_patients = mysqli_stmt_get_result($query_patients);
$patientCount = mysqli_num_rows($result_patients);


$query_appointments = mysqli_prepare($connect, "
    SELECT COUNT(*) 
    FROM appointment 
    WHERE doctor_username = ?");
mysqli_stmt_bind_param($query_appointments, 's', $doctor_username);
mysqli_stmt_execute($query_appointments);
$result_appointments = mysqli_stmt_get_result($query_appointments);
$appointmentCount = mysqli_fetch_row($result_appointments)[0];

// Fetch pending appointments
$query_pending_appointments = mysqli_prepare($connect, "SELECT * FROM appointment WHERE status = 'Pending' AND doctor_username = ?");
mysqli_stmt_bind_param($query_pending_appointments, 's', $doctor_username);
mysqli_stmt_execute($query_pending_appointments);
$result_pending_appointments = mysqli_stmt_get_result($query_pending_appointments);
$appointmentCount = mysqli_num_rows($result_pending_appointments);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Doctor Dashboard - Hospital Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <style>
        html, body {
            max-height: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0;
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
            font-size: 2.5rem;
        }

        #sidebarToggle {
            margin-top: -10px;
            margin-left: 10px;
        }

        #dashboardChart {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        .chart-container {
            width: 80%;
            margin: 0 auto;
        }

        .calendar-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
            margin-bottom: 40px;
        }

        @media (max-width: 768px) {
            .chart-container {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-info bg-info">
        <div class="container-fluid">
            <!-- Sidebar toggle button (left) -->
            <button class="btn btn-info d-md-none mr-2" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Brand Title -->
            <div class="d-block d-lg-none mx-auto">
                <h5 class="text-white mb-0">HealthCare</h5>
            </div>
            <div class="d-none d-lg-block">
                <h5 class="text-white mb-0">HealthCare</h5>
            </div>

            <!-- Navbar items (right) -->
            <div class="ml-auto">
                <ul class="navbar-nav">
                    <?php
                    if (isset($_SESSION['doctor_username'])) {
                        $user = $_SESSION['doctor_username'];
                        echo '
                    <li class="nav-item">
                        <a href="profile.php" class="nav-link text-white">' . htmlspecialchars($user) . '</a>
                    </li>';
                    } else {
                        echo '
                    <li class="nav-item">
                        <a href="../index.php" class="nav-link text-white">Home</a>
                    </li>';
                    }
                    ?>
                </ul>
            </div>

        </div>
    </nav>

    <div id="overlay"></div>
    <div class="container-fluid">
        <div class="row">

            <!-- SIDEBAR -->
            <div class="col-12 col-md-2 p-0">
                <div class="sidebar bg-info" id="sidebar">
                    <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="profile.php"><i class="fas fa-user-md"></i> My Profile</a>
                    <a href="appointment.php"><i class="fas fa-calendar-check"></i> Appointments</a>
                    <a href="patient.php"><i class="fas fa-procedures"></i> Patients</a>
                    <a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-12 col-md-10" style="height:100%;">
                <h4 class="my-3 text-center mt-5 mb-5" style="color: #17a2b8;">Doctor's Dashboard</h4>

                <div class="row">
                    <!-- Cards Section -->
                    <div class="col-md-4">
                        <div class="dashboard-card bg-info">
                            <div>
                                <h5>My Profile</h5>
                            </div>
                            <div class="icon-container">
                                <a href="profile.php" class="text-white"><i class="fas fa-user-circle"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="dashboard-card bg-warning">
                            <div>
                                <h4><?php echo $patientCount; ?></h4>
                                <p>Total Patients</p>
                            </div>
                            <div class="icon-container">
                                <a href="patient.php" class="text-white"><i class="fas fa-procedures"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="dashboard-card bg-success">
                            <div>
                                <h4><?php echo $appointmentCount; ?></h4>
                                <p>Pending Appointments</p>
                            </div>
                            <div class="icon-container">
                                <a href="appointment.php" class="text-white"><i class="fas fa-calendar"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Overview Chart -->
                    <div class="col-md-6 text-center mt-4">
                        <h5 class="text-center mb-4">Overview Chart</h5>
                        <div class="chart-container">
                            <canvas id="overviewChart" height="300"></canvas>
                        </div>
                    </div>

                    <!-- Appointment Calendar -->
                    <div class="col-md-6 text-center mt-4">
                        <h5 class="text-center mb-4">Appointment Calendar</h5>
                        <div id="calendar" style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin: 0 auto; max-width: 100%; height:30%;"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts -->
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

        const patients = <?= $patientCount; ?>;
        const appointments = <?= $appointmentCount; ?>;

        new Chart(document.getElementById('overviewChart'), {
            type: 'pie',
            data: {
                labels: ['Patients', 'Pending Appointments'],
                datasets: [{
                    backgroundColor: ['#36A2EB', '#FFCE56'],
                    data: [patients, appointments]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>

    <!-- FullCalendar JS -->
    <!-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 300,
                aspectRatio: 1.5,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: [
                    <?php
                    $appointments_query = mysqli_query($connect, "SELECT * FROM appointment WHERE doctor_username = '{$_SESSION['doctor_username']}'");
                    while ($row = mysqli_fetch_array($appointments_query)) {
                        $title = "Appointment with " . htmlspecialchars($row['full_name']);
                        $date = $row['appointment_date'];

                        echo "{";
                        echo "title: '" . $title . "',";
                        echo "start: '" . $date . "',";
                        echo "backgroundColor: '#17a2b8',";
                        echo "borderColor: '#17a2b8'";
                        echo "},";
                    }
                    ?>
                ],
                eventTextColor: 'white',
            });

            calendar.render();
        });
    </script> -->
  
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    
    // Get the doctor's username from the PHP session
    var doctorUsername = '<?php echo $_SESSION['doctor_username']; ?>';

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 300,
        aspectRatio: 1.5,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: function(info, successCallback, failureCallback) {
            $.ajax({
                url: 'fetch_appointments.php', // PHP script to fetch events
                dataType: 'json',
                data: {
                    doctor_username: doctorUsername // Pass the doctor's username to the backend
                },
                success: function(data) {
                    successCallback(data); // Pass events to the calendar
                },
                error: function() {
                    failureCallback('Error fetching events!');
                }
            });
        }
    });

    calendar.render();
});

</script>
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
