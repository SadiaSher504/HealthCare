<?php
// session_start();
include("../include/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Header</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-info bg-info">
        <div class="container-fluid d-flex align-items-center">

            <!-- Sidebar toggle button (left) -->
            <button class="btn btn-info d-md-none mr-2" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Title (centered on small screens only) -->
            <div class="flex-grow-1 text-center d-block d-lg-none">
                <h5 class="text-white mb-0">HealthCare</h5>
            </div>

            <!-- Title (left-aligned on large screens) -->
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

    <!-- Bootstrap Bundle JS (includes Popper) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>

</body>

</html>
