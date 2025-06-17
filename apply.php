<?php
include($_SERVER['DOCUMENT_ROOT'] . '/hospital/include/connection.php');

// File upload helper function
function uploadFile($file, $target_dir)
{
    $target_file = $target_dir . basename($file["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowedTypes = ["pdf", "jpg", "jpeg", "png"];

    if (!in_array($fileType, $allowedTypes)) {
        return false;
    }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    } else {
        return false;
    }
}

// Process form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];

    // Check for existing email or username
    $table = ($role == "doctor") ? "doctors" : (($role == "employee") ? "employee" : "account_branch");
    $checkQuery = "SELECT * FROM $table WHERE email='$email' OR username='$username'";
    $result = mysqli_query($connect, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>
            Swal.fire('Error', 'Email or Username already registered.', 'error');
        </script>";
        exit;
    }

    // Handle file uploads (resume and profile)
    $resume = uploadFile($_FILES['resume'], "uploads/resumes/");
    if ($resume === false) {
        echo "<script>
            Swal.fire('Error', 'Error uploading resume.', 'error');
        </script>";
        exit;
    }

    $profile = isset($_FILES['profile']) && $_FILES['profile']['size'] > 0 ? uploadFile($_FILES['profile'], "uploads/profiles/") : null;
    if ($profile === false && isset($_FILES['profile'])) {
        echo "<script>
            Swal.fire('Error', 'Error uploading profile.', 'error');
        </script>";
        exit;
    }

    // Ensure department is set for the doctor or employee roles
    $department = null;
    if ($role == "doctor" || $role == "employee") {
        if (isset($_POST['department']) && !empty($_POST['department'])) {
            $department = $_POST['department'];
        } else {
            echo "<script>
                Swal.fire('Error', 'Please select a department.', 'error');
            </script>";
            exit;
        }
    }

    // Insert data into the database based on the role
    if ($role == "doctor") {
        $query = "INSERT INTO doctors (full_name, email, department, role, username, password, status, gender, resume)
                  VALUES ('$full_name', '$email', '$department', '$role', '$username', '$password', 'pending', '$gender', '$resume')";
    } elseif ($role == "employee") {
        $date_join = date("Y-m-d"); // Set the date_join to current date if needed

        $query = "INSERT INTO employee 
                  (full_name, department, email, username, password, date_reg, profile, role, gender, date_join, status, salary, resume)
                  VALUES 
                  ('$full_name', '$department', '$email', '$username', '$password', NOW(), '$profile', '$role', '$gender', '$date_join', 'pending', 0, '$resume')";
    } elseif ($role == "account_branch") {
        $query = "INSERT INTO account_branch (full_name, username, password, status, profile, gender, email, date_reg, role, resume, salary)
                  VALUES ('$full_name', '$username', '$password', 'pending', '$profile', '$gender', '$email', NOW(), '$role', '$resume', 0)";
    } else {
        echo "<script>
            Swal.fire('Error', 'Invalid role selected.', 'error');
        </script>";
        exit;
    }

    // Execute the query and display success message
    if (mysqli_query($connect, $query)) {
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Employee application submitted successfully!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location.href = 'apply.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire('Error', 'Something went wrong.', 'error');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Apply for Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Add this in the <head> section of your HTML file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>


    <style>
        body {
            min-height: 100vh;
            background-color: #17a2b8;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .form-container {
            background: #ffffff;
            padding: 40px 50px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            margin: 0 15px;
        }

        .form-title {
            text-align: center;
            color: #333333;
            font-size: 30px;
            margin-bottom: 30px;
            font-weight: 700;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 6px;
            color: #333333;
            font-weight: 600;
            font-size: 16px;
        }

        .form-control {
            width: 100%;
            padding: 12px 18px;
            border: 2px solid #ddd;
            border-radius: 8px;
            background: #fafafa;
            color: #333;
            font-size: 16px;
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        .form-control::placeholder {
            color: #bbb;
        }

        .form-control:focus {
            background: #fff;
            outline: none;
            border-color: #4CAF50;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: #007BFF;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            font-weight: 600;
            transition: background 0.3s ease;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .form-select {
            width: 100%;
            padding: 12px 18px;
            border: 2px solid #ddd;
            border-radius: 8px;
            background: #fafafa;
            color: #333;
            font-size: 16px;
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        .form-select:focus {
            background: #fff;
            outline: none;
            border-color: #007BFF;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .form-select option {
            background-color: #fff;
            color: #333;
        }

        /* Media Query for smaller devices */
        @media (max-width: 768px) {
            .form-container {
                padding: 25px 30px;
                max-width: 85%;
            }

            .form-title {
                font-size: 26px;
            }

            .form-control,
            .form-select,
            .btn-submit {
                font-size: 14px;
                padding: 10px 14px;
            }
        }

        /* Media Query for mobile devices */
        @media (max-width: 576px) {
            .form-container {
                padding: 20px 25px;
            }

            .form-title {
                font-size: 24px;
            }

            .form-control,
            .form-select,
            .btn-submit {
                font-size: 12px;
                padding: 8px 12px;
            }
        }
    </style>

</head>

<body>

    <div class="form-container">
        <h2 class="form-title">Apply Now</h2>

        <form id="applicationForm" action="" method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="role" class="form-label">Select Role</label>
                <select id="role" name="role" class="form-select" required>
                    <option value="">--Select--</option>
                    <option value="doctor">Doctor</option>
                    <option value="employee">Employee</option>
                    <option value="account_branch">Account Branch</option>
                </select>
            </div>

            <div id="departmentFields">
                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <select id="department" name="department" class="form-select">
                        <option value="">--Select Department--</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select id="gender" name="gender" class="form-select" required>
                    <option value="">--Select Gender--</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" id="full_name" name="full_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="resume" class="form-label">Upload Resume (PDF)</label>
                <input type="file" id="resume" name="resume" class="form-control" accept=".pdf" required>
            </div>

            <div class="mb-3">
                <label for="profile" class="form-label">Upload Profile Picture (Optional)</label>
                <input type="file" id="profile" name="profile" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-submit" style="margin-top: 10px;">Submit Application</button>
        </form>
    </div>

    <script>
        const departmentSelect = document.getElementById('department');
        const departmentField = document.getElementById('departmentFields');
        const roleSelect = document.getElementById('role');

        const doctorDepartments = [{
                value: "Cardiology",
                text: "Cardiology"
            },
            {
                value: "Neurology",
                text: "Neurology"
            },
            {
                value: "Orthopedics",
                text: "Orthopedics"
            },
            {
                value: "Pediatrics",
                text: "Pediatrics"
            },
            {
                value: "Dermatology",
                text: "Dermatology"
            },
            {
                value: "Oncology",
                text: "Oncology"
            }
        ];

        const employeeDepartments = [{
                value: "HR",
                text: "Human Resources (HR)"
            },
            {
                value: "IT",
                text: "Information Technology (IT)"
            },
            {
                value: "Administration",
                text: "Administration"
            },
            {
                value: "Reception",
                text: "Reception"
            },
            {
                value: "Maintenance",
                text: "Maintenance"
            },
            {
                value: "Billing",
                text: "Billing"
            }
        ];

        roleSelect.addEventListener('change', function() {
            const role = this.value;

            // Clear previous department options
            departmentSelect.innerHTML = '<option value="">--Select Department--</option>';

            if (role === 'doctor') {
                departmentField.style.display = 'block';
                doctorDepartments.forEach(dep => {
                    const option = document.createElement('option');
                    option.value = dep.value;
                    option.text = dep.text;
                    departmentSelect.appendChild(option);
                });
                departmentSelect.required = true;
            } else if (role === 'employee') {
                departmentField.style.display = 'block';
                employeeDepartments.forEach(dep => {
                    const option = document.createElement('option');
                    option.value = dep.value;
                    option.text = dep.text;
                    departmentSelect.appendChild(option);
                });
                departmentSelect.required = true;
            } else {
                departmentField.style.display = 'none';
                departmentSelect.required = false;
            }
        });
    </script>

</body>

</html>