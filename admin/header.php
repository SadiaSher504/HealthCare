<?php
session_start();
include("../include/connection.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Header</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            <span><i class="fas fa-user text-white"></i></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
            <ul class="navbar-nav ml-auto">
                <?php
                if (isset($_SESSION['admin'])) {
                    $adminUser = $_SESSION['admin'];
                    echo '
                        <li class="nav-item">
                            <a class="nav-link text-white" href="admin.php">
                                <i class="fas fa-user-shield"></i> ' . htmlspecialchars($adminUser) . '
                            </a>
                        </li>';
                } else {
                    echo '
                        <li class="nav-item">
                            <a class="nav-link text-white" href="../index.php">
                                Home
                            </a>
                        </li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Bootstrap JS Bundle (for toggle and collapse functionality) -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>

</body>
</html>
