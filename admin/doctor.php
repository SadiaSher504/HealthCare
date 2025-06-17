<?php
//session_start();
include("../include/connection.php"); // Include the database connection
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Doctors</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
            background-color: rgba(255, 255, 255, 0.4);
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
    <style>
    /* --- main content enhancements --- */

    .main-content {
        padding: 20px;
    }

    .main-content h5 {
        font-weight: 700;
        margin-bottom: 30px;
        color: #333;
    }

    .card-table {
        background: #fff;
        border-radius: 15px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .table th {
        background-color: #17a2b8;
        color: #fff;
        text-align: center;
        vertical-align: middle;
    }

    .table td {
        text-align: center;
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(23, 162, 184, 0.1);
    }

    .btn-info {
        background-color: #17a2b8;
        border: none;
        transition: 0.3s;
    }

    .btn-info:hover {
        background-color: #138496;
    }

    /* Responsive for small devices */
    @media (max-width: 768px) {
        .main-content {
            padding: 10px;
        }

        .card-table {
            padding: 15px;
        }

        .table th, .table td {
            font-size: 14px;
        }
    }
  
    #searchInput {
        border-radius: 20px;
        padding-left: 20px;
        border: 2px solid #17a2b8;
    }
    #noResults {
        border-radius: 15px;
        font-weight: bold;
        font-size: 18px;
    }
</style>

</head>

<body>
    <?php include("header.php"); ?>


    <!-- DARK BACKDROP -->
    <div id="overlay"></div>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0">
                <div class="sidebar" id="sidebar">
                    <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="admin.php"><i class="fas fa-user-shield"></i> Administration</a>
                    <a href="doctor.php"><i class="fas fa-user-md"></i> Doctors</a>
                    <a href="patient.php"><i class="fas fa-hospital-user"></i> Patients</a>
                    <a href="job_request.php"><i class="fas fa-address-card"></i> Add Staff</a>
                    <a href="report.php" id="reportLink"><i class="fas fa-file-medical-alt"></i> Reports</a>
                    <a href="staff.php"><i class="fas fa-address-card"></i> Staff</a>
                    <a href="../login/logout.php " id="logoutLink"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <!-- Main Content -->
           <!-- Main Content -->
<!-- Main Content -->
<div class="col-md-10 col-12 main-content">
    <h5 class="text-center">Total Doctors</h5>

    <!-- Search Bar -->
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search doctors...">
    </div>

    <!-- Doctors Table -->
    <div class="card-table table-responsive">
        <table class="table table-bordered table-hover" id="doctorsTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Salary</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="doctorData">
                <?php
                if (!$connect) {
                    die("<div class='alert alert-danger'>Database Connection Failed: " . mysqli_connect_error() . "</div>");
                }

                $query = "SELECT * FROM doctors WHERE status='approved'";
                $res = mysqli_query($connect, $query);

                if (!$res) {
                    die("<div class='alert alert-danger'>Query Failed: " . mysqli_error($connect) . "</div>");
                }

                if (mysqli_num_rows($res) < 1) {
                    echo "<tr><td colspan='7' class='text-center'>No Approved Doctors Yet</td></tr>";
                } else {
                    while ($row = mysqli_fetch_array($res)) {
                        echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['full_name']) . "</td>
                            <td>" . htmlspecialchars($row['username']) . "</td>
                            <td>" . htmlspecialchars($row['email']) . "</td>
                            <td>" . htmlspecialchars($row['department']) . "</td>
                            <td>" . htmlspecialchars($row['salary']) . "</td>
                            <td>
                                <a href='edit.php?id=" . htmlspecialchars($row['id']) . "' class='btn btn-info btn-sm'>Edit</a>
                            </td>
                        </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="noResults" class="alert alert-warning text-center" style="display: none;">
    No Doctors Found!
</div>

    <!-- Pagination -->
    <div class="mt-3 text-center">
        <button id="prevBtn" class="btn btn-outline-info btn-sm">Previous</button>
        <span id="pageInfo" class="mx-2"></span>
        <button id="nextBtn" class="btn btn-outline-info btn-sm">Next</button>
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
    </script>

<script>
    const table = document.getElementById("doctorsTable");
    const rows = table.querySelectorAll("#doctorData tr");
    const searchInput = document.getElementById("searchInput");

    let currentPage = 1;
    const rowsPerPage = 5;

    function displayRows() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;

        rows.forEach((row, index) => {
            if (index >= start && index < end) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });

        document.getElementById("pageInfo").textContent = `Page ${currentPage}`;
    }

    function nextPage() {
        if (currentPage * rowsPerPage < rows.length) {
            currentPage++;
            displayRows();
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            currentPage--;
            displayRows();
        }
    }

    document.getElementById("nextBtn").addEventListener("click", nextPage);
    document.getElementById("prevBtn").addEventListener("click", prevPage);

    // Search Function
    // Search Function
searchInput.addEventListener("keyup", function () {
    const filter = searchInput.value.toLowerCase();
    let visibleCount = 0;

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(filter)) {
            row.style.display = "";
            visibleCount++;
        } else {
            row.style.display = "none";
        }
    });

    if (visibleCount === 0) {
        document.getElementById("noResults").style.display = "block";
    } else {
        document.getElementById("noResults").style.display = "none";
    }
});

    // Initialize
    displayRows();
</script>

</body>

</html>