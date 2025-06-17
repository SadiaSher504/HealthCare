<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient List</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    
    <!-- Custom Styles -->
    <style>
        body { background-color: #f8f9fa; padding: 20px; }
        .table-container { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .table-hover tbody tr:hover { background-color: #e9ecef; }
        .page-title { color: #1d2a4d; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="table-container">
            <h2 class="text-center page-title mb-4">Patient List</h2>
            <table id="patientTable" class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Contact</th>
                        <th>Condition</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>John Doe</td><td>45</td><td>Male</td><td>123-456-7890</td><td>Diabetes</td></tr>
                    <tr><td>2</td><td>Jane Smith</td><td>32</td><td>Female</td><td>987-654-3210</td><td>Hypertension</td></tr>
                    <tr><td>3</td><td>Mike Johnson</td><td>60</td><td>Male</td><td>555-123-4567</td><td>Heart Disease</td></tr>
                    <tr><td>4</td><td>Emily Brown</td><td>29</td><td>Female</td><td>444-987-6543</td><td>Asthma</td></tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#patientTable').DataTable();
        });
    </script>
     <?php
    include("footer.php");
    ?>
</body>
</html>
