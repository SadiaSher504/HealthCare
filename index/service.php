<?php  
include($_SERVER['DOCUMENT_ROOT'] . '/hospital/include/connection.php');
$sql = "SELECT visible FROM link_visibility WHERE id = 1";
$result = mysqli_query($connect, $sql);

$currentVisibility = null;

if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $currentVisibility = $row['visible'];
    }
} else {
    echo "Error " . mysqli_error($connect);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Navbar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
        .nav-item1 {
            animation: blink 2s step-start infinite;
        }
    </style>
</head>
<body>

<div class="container-fluid sticky-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0">
            <a href="index.html" class="navbar-brand">
                <h1 class="m-0 text-uppercase text-primary">
                    <a href="index.php">
                        <i class="fa-solid fa-staff-snake me-2"></i>
                    </a> HC

                </h1>
            </a>
            <!-- Navbar Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto py-0">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link active">Home</a>
                    </li>
                    <li class="nav-item">
                        <!-- <a href="../index/about.php" class="nav-link">About</a> -->
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" id="serviceDropdown" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Service</a>
                        <ul class="dropdown-menu">
                            <!-- <li><a href="new/onlinereport.php" class="dropdown-item">Online Report</a></li> -->
                            <li><a href="check_status.php" class="dropdown-item">Appointment Status</a></li>
                            <li><a href="new/team.php" class="dropdown-item">The Team</a></li>
                            <!-- <li><a href="new/testimonial.php" class="dropdown-item">Testimonial</a></li> -->
                            <li><a href="new/appointment.php" class="dropdown-item">Appointment</a></li>
                            <!-- <li><a href="new/search.php" class="dropdown-item">Search</a></li> -->
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="new/contact.php" class="nav-link">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a href="login/login.php" class="nav-link" style="color: black;">Login Panel</a>
                    </li>
                    <?php if ($currentVisibility): ?> 
                        <li class="nav-item">
                            <a id="joblink" href="apply.php" class="nav-item1 nav-link text-success">Job Is Open Now <i class="fa-solid fa-envelope" style="color:orange;"></i></a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</div>

<!-- Bootstrap JS Bundle (including Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("click", function (event) {
    var navbarCollapse = document.getElementById("navbarCollapse");
    var toggleButton = document.querySelector(".navbar-toggler");

    // Check if the clicked area is NOT inside the navbar or the toggle button
    if (!navbarCollapse.contains(event.target) && !toggleButton.contains(event.target)) {
        var bsCollapse = new bootstrap.Collapse(navbarCollapse, { toggle: false });
        bsCollapse.hide(); // Collapse the navbar
    }
});
</script>


</body>
</html>
