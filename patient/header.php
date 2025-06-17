<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Hospital Management System - Patient</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons (optional) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-info bg-info">
    <div class="container-fluid">
    <button class="btn btn-info d-md-none" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>

        <a class="navbar-brand text-white" href="#">HealthCare</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent" 
            aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="fas fa-user text-white"></i></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav ml-auto">
                <?php
                if (isset($_SESSION['patient'])) {
                    $patientUsername = $_SESSION['patient'];
                    echo '
                        <li class="nav-item">
                            <a class="nav-link text-white" href="profile.php">
                                <i class="fas fa-user-circle"></i> Welcome, ' . htmlspecialchars($patientUsername) . '
                            </a>
                        </li>';
                } else {
                    // If no patient is logged in, send to login
                    header("Location: ../login.php");
                    exit();
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap Bundle (for navbar toggle and collapse) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>
