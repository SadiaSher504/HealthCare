<?php
include("index/service.php");
include("include/connection.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Appointment Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Favicon -->
    <link href="img/favicon.png" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet">

    <!-- Custom Stylesheets -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <style>
        @media (max-width: 992px) {
            .container {
                position: relative;
                margin: 20px auto;
                width: 90%;
            }
        }

        @media (max-width: 576px) {
            .table {
                font-size: 12px;
            }

            .search-form {
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="search-form mx-auto p-4 shadow-lg rounded bg-light" style="max-width: 500px;">
            <h5 class="mb-4 text-center">Check Appointment Status</h5>
            <form method="post">
                <div class="mb-3">
                    <label for="searchPhone" class="form-label">Enter Phone Number</label>
                    <input type="text" class="form-control" name="searchPhone" id="searchPhone" required>
                </div>
                <button type="submit" name="searchSubmit" class="btn btn-primary w-100">Check Status</button>
            </form>

            <?php
            if (isset($_POST["searchSubmit"])) {
                $searchPhone = trim($_POST["searchPhone"]);
                $searchPhone = mysqli_real_escape_string($connect, $searchPhone);

                $searchQuery = "SELECT * FROM general_appointment WHERE phone='$searchPhone'";
                $searchResult = mysqli_query($connect, $searchQuery);

                if (!$searchResult) {
                    echo "<div class='alert alert-danger mt-3'>Query Failed: " . mysqli_error($connect) . "</div>";
                } elseif (mysqli_num_rows($searchResult) > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-bordered mt-3'>
                            <thead class='table-primary'>
                                <tr>
                                    <th>Name</th>
                                    <th>District</th>
                                    <th>Department</th>
                                    <th>Doctor</th>
                                    <th>Consultation Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>";

                    while ($row = mysqli_fetch_array($searchResult)) {
                        $statusClass = ($row['status'] == 'approved') ? 'table-success' :
                                       (($row['status'] == 'denied') ? 'table-danger' : '');

                        echo "<tr class='$statusClass'>";
                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['district']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['department']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['doctor']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                        echo "<td class='text-white' style='background-color: " . ($row['status'] == 'approved' ? '#28a745' : ($row['status'] == 'denied' ? '#dc3545' : '#ffc107')) . ";'>" . ucfirst(htmlspecialchars($row['status'])) . "</td>";
                        echo "</tr>";
                    }

                    echo "</tbody></table></div>";
                } else {
                    echo "<div class='alert alert-warning mt-3'>No Result Found</div>";
                }

                mysqli_close($connect);
            }
            ?>
        </div>
    </div>

    <footer class="mt-5">
        <?php include("include/footer.php"); ?>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
