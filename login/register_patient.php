<?php
// Database connection setup
$servername = "localhost"; // Database server
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "hospital"; // Database name

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $emergency_contact = $_POST['emergency_contact'];
    $refNumber = $_POST['refNumber'];
    $age = $_POST['age'];
    $dob = $_POST['dob'];
    $religion = $_POST['religion'];
    $marital_status = $_POST['marital_status'];
    $blood_group = $_POST['blood_group'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $division = $_POST['division'];
    $district = $_POST['district'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password for security

    // Prepare SQL query to insert data into the database
    $sql = "INSERT INTO patient (full_name, phone, email, emergency_contact, refNumber, age, dob, religion, marital_status, blood_group, username, gender, division, district, password) 
            VALUES ('$full_name', '$phone', '$email', '$emergency_contact', '$refNumber', '$age', '$dob', '$religion', '$marital_status', '$blood_group', '$username', '$gender', '$division', '$district', '$password')";

    if ($conn->query($sql) === TRUE) {
        // Success, show SweetAlert success message
        echo "<script>
            Swal.fire({
                title: 'Registration Successful!',
                text: 'You have been successfully registered.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
          </script>";
    } else {
        // Failure, show SweetAlert error message
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'There was an issue with the registration.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
          </script>";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- SweetAlert2 CSS -->
     <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            background-color:rgb(214, 240, 244);
            font-family: 'Arial', sans-serif;
        }

        .container {
            margin-top: 50px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 900px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #495057;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px;
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            background-color: #007bff;
            border: none;
            font-size: 16px;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .row {
            margin-bottom: 20px;
        }

        .alert {
            padding: 10px;
            border-radius: 8px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Patient Registration Form</h2>
        <form action="register_patient.php" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="emergency_contact">Emergency Contact</label>
                        <input type="tel" class="form-control" id="emergency_contact" name="emergency_contact" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="refNumber">Reference Number</label>
                        <input type="text" class="form-control" id="refNumber" name="refNumber" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="age">Age</label>
                        <input type="number" class="form-control" id="age" name="age" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="religion">Religion</label>
                        <input type="text" class="form-control" id="religion" name="religion" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="marital_status">Marital Status</label>
                        <select class="form-control" id="marital_status" name="marital_status" required>
                            <option value="single">Single</option>
                            <option value="married">Married</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="blood_group">Blood Group</label>
                        <select class="form-control" id="blood_group" name="blood_group" required>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="division">Division</label>
                        <input type="text" class="form-control" id="division" name="division" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="district">District</label>
                        <input type="text" class="form-control" id="district" name="district" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

</body>

</html>