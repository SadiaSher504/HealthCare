<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Income Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart-container {
            position: relative;
            width: 100%;
            height: 400px;
            margin-top: 30px;
        }
        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php 
    include("header.php");
    include("../include/connection.php");
?>

<div class="container-fluid">
    <div class="row">
        <?php include("sidenav.php"); ?>

        <div class="col-md-10">
            <h4 class="text-center my-4">Total Income Summary</h4>

            <?php
            $query = "SELECT * FROM income";
            $res = mysqli_query($connect, $query);

            if (!$res) {
                die("Query failed: " . mysqli_error($connect));
            }

            $monthlyIncome = [];

            while ($row = mysqli_fetch_array($res)) {
                $month = date('F', strtotime($row['date_discharge']));
                if (!isset($monthlyIncome[$month])) {
                    $monthlyIncome[$month] = 0;
                }
                $monthlyIncome[$month] += floatval($row['amount_paid']);
            }

            echo "<div class='table-responsive'>
                    <table class='table table-striped table-bordered'>
                        <thead class='thead-dark'>
                            <tr>
                                <th>ID</th>
                                <th>Doctor</th>
                                <th>Patient</th>
                                <th>Date Discharge</th>
                                <th>Amount Paid (PKR)</th>
                            </tr>
                        </thead>
                        <tbody>";

            if (mysqli_num_rows($res) < 1) {
                echo "<tr><td colspan='5' class='text-center'>No Patient Discharge Yet</td></tr>";
            } else {
                mysqli_data_seek($res, 0); // Reset pointer
                while ($row = mysqli_fetch_array($res)) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['id']) . "</td>
                            <td>" . htmlspecialchars($row['doctor']) . "</td>
                            <td>" . htmlspecialchars($row['patient']) . "</td>
                            <td>" . htmlspecialchars($row['date_discharge']) . "</td>
                            <td>" . htmlspecialchars(number_format($row['amount_paid'], 2)) . "</td>
                        </tr>";
                }
            }

            echo "</tbody></table></div>";
            ?>

            <!-- Chart Section -->
            <div class="chart-container">
                <canvas id="monthlyIncomeChart"></canvas>
            </div>

            <script>
                const ctx = document.getElementById('monthlyIncomeChart').getContext('2d');
                const monthlyIncomeChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode(array_keys($monthlyIncome)); ?>,
                        datasets: [{
                            label: 'Total Income by Month (PKR)',
                            data: <?php echo json_encode(array_values($monthlyIncome)); ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'PKR ' + value;
                                    }
                                }
                            }
                        }
                    }
                });
            </script>

        </div> 
    </div>
</div>

</body>
</html>
