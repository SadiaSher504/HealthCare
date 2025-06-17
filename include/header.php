<?php
session_start();
?>
<html>

<head>
    <title>Hospital Management System</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-DrT5NfxfbHVMHux31Lkhxg42LY60f8TaYyK50jnxRnM=" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-info bg-info" style="margin-top: -30px;">
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
                <li class="nav-item"><a href="admin.php" class="nav-link text-white">' . htmlspecialchars($user) . ' </a></li>';
                
            } elseif (isset($_SESSION['doctor'])) {
                $user = $_SESSION['doctor'];
                echo '
                <li class="nav-item"><a href="doctor/index.php" class="nav-link text-white">' . htmlspecialchars($user) . ' </a></li>';
            } elseif (isset($_SESSION['patient'])) {
                $user = $_SESSION['patient'];
                echo '
                <li class="nav-item"><a href="patient/profile.php" class="nav-link text-white">' . htmlspecialchars($user) . ' </a></li>';
            } else {
                echo '<li class="nav-item"><a href="index.php" class="nav-link text-white">Home</a></li>';
                // echo '<li class="nav-item"><a href="onlinereport.php" class="nav-link text-white">Back</a></li>';
            }
            ?>
        </ul>
    </nav>

</body>

</html>