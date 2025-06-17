<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hospital";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    switch ($role) {
        case 'admin':
            $query = $conn->prepare("SELECT * FROM admin WHERE username=? AND password=?");
            $query->bind_param("ss", $username, $password);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows == 1) {
                $_SESSION['admin'] = $username;
                header("location: ../admin/index.php");
                exit();
            } else {
                $error = "Invalid Admin Login Details";
            }
            break;

        case 'doctor':
            $query = $conn->prepare("SELECT * FROM doctors WHERE username=? AND password=?");
            $query->bind_param("ss", $username, $password);
            $query->execute();
            $result = $query->get_result();
            $row = $result->fetch_assoc();

            if ($result->num_rows == 1) {
                if ($row['status'] == "pending") {
                    $error = "Please wait for admin approval";
                } elseif ($row['status'] == "Rejected") {
                    $error = "Application rejected by Admin";
                } else {
                    $_SESSION['doctor_username'] = $username; // ✅ fixed here!
                    header("location:../doctor/index.php");
                    exit();
                }
            } else {
                $error = "Invalid Doctor Login";
            }
            break;


            // Start the session at the beginning of the file
            session_start();


        case 'patient':
            $query = $conn->prepare("SELECT * FROM patient WHERE username=?");
            $query->bind_param("s", $username);
            $query->execute();
            $result = $query->get_result();
            $row = $result->fetch_assoc();

            if ($result->num_rows == 1 && password_verify($password, $row['password'])) {
                if ($row['status'] == "pending") {
                    $error = "Please wait for admin approval";
                } elseif ($row['status'] == "Rejected") {
                    $error = "Application rejected by Admin";
                } else {
                    // Store session data
                    $_SESSION['patient'] = $username;
                    $_SESSION['patient_id'] = $row['id'];
                    $_SESSION['patient_status'] = $row['status'];  // You can track the patient status too
                    header("location:../patient/index.php");
                    exit();
                }
            } else {
                $error = "Invalid Patient Login";
            }
            break;

        case 'account_branch':
            $query = $conn->prepare("SELECT * FROM account_branch WHERE username=? AND password=?");
            $query->bind_param("ss", $username, $password);
            $query->execute();
            $result = $query->get_result();
            $row = $result->fetch_assoc();

            if ($row['status'] == "pending") {
                $error = "Please wait for admin approval";
            } elseif ($row['status'] == "Rejected") {
                $error = "Application rejected";
            } elseif ($result->num_rows == 1) {
                $_SESSION['account_branch'] = $username;
                header("location:../");
                exit();
            } else {
                $error = "Invalid Account Branch Login";
            }
            break;

        case 'employee':
            $query = $conn->prepare("SELECT * FROM employee WHERE username=? AND password=?");
            $query->bind_param("ss", $username, $password);
            $query->execute();
            $result = $query->get_result();

            if ($result->num_rows == 1) {
                $_SESSION['employee'] = $username;
                header("location: ../");
                exit();
            } else {
                $error = "Invalid Employee Login";
            }
            break;

        default:
            $error = "Invalid Role Selected";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Hospital Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .registration-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
            padding: 40px 30px;
            border-radius: 20px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .registration-container:hover {
            transform: scale(1.02);
        }

        .registration-container h2 {
            margin-bottom: 25px;
            color: #333;
            font-size: 30px;
            font-weight: 700;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="number"],
        input[type="date"],
        select {
            width: 100%;
            padding: 15px;
            border-radius: 12px;
            border: 1px solid #ccc;
            background: #f9f9f9;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus,
        input[type="number"]:focus,
        input[type="date"]:focus,
        select:focus {
            border-color: #4facfe;
            background: #fff;
            outline: none;
            box-shadow: 0 0 5px rgba(79, 172, 254, 0.5);
        }

        button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            background: #4facfe;
            color: white;
            font-weight: 600;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #00c6ff;
        }

        .error {
            background: #ffe0e0;
            color: #e60000;
            padding: 12px;
            margin-bottom: 20px;
            text-align: center;
            border-radius: 10px;
            font-weight: bold;
        }

        .success {
            background: #e0ffe0;
            color: #4caf50;
            padding: 12px;
            margin-bottom: 20px;
            text-align: center;
            border-radius: 10px;
            font-weight: bold;
        }

        .login-link {
            margin-top: 20px;
        }

        .login-link a {
            color: #4facfe;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .registration-container {
                padding: 30px 20px;
                width: 90%;
            }

            button {
                font-size: 16px;
            }
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="card p-4">
                    <h3 class="text-center mb-4">Login</h3>

                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger text-center"><?php echo $error; ?></div>
                    <?php } ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="role" class="form-label">Select Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="">Select Role</option>
                                <option value="admin">Admin</option>
                                <option value="doctor">Doctor</option>
                                <option value="patient">Patient</option>
                                <option value="employee">Employee</option>
                                <option value="account_branch">Account Branch</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                        </div>

                        <div class="mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                    <div class="text-center">
                        <p>New Patient? <a href="register_patient.php">Sign up here</a></p>
                        <p><a href="/hospital/">← Go Back to Home</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>