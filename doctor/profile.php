<?php
session_start();
error_reporting(0);
include("../include/connection.php");

// Initialize a message variable
$message = '';
$message_type = '';

$doc = $_SESSION['doctor_username']; // Use the session variable

$query = "SELECT * FROM doctors WHERE username='$doc'";
$res = mysqli_query($connect, $query);
$row = mysqli_fetch_array($res);

if (isset($_POST['upload'])) {
    $image = $_FILES['img']['name'];
    if (!empty($image)) {
        $image_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_exts = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($image_ext, $allowed_exts)) {
            $update = "UPDATE doctors SET profile='$image' WHERE username='$doc'";
            $upload_res = mysqli_query($connect, $update);
            if ($upload_res) {
                move_uploaded_file($_FILES['img']['tmp_name'], "img/$image");
                // Set success message
                $_SESSION['message'] = 'Profile updated successfully!';
                $_SESSION['message_type'] = 'success';
            } else {
                // Set error message
                $_SESSION['message'] = 'Profile update failed: ' . mysqli_error($connect);
                $_SESSION['message_type'] = 'error';
            }
        } else {
            // Set error message for invalid file extension
            $_SESSION['message'] = 'Only image files are allowed!';
            $_SESSION['message_type'] = 'error';
        }
    }
}

// Handle username update
if (isset($_POST['change_uname'])) {
    $uname = trim($_POST['uname']);
    if (!empty($uname)) {
        $check = mysqli_query($connect, "SELECT * FROM doctors WHERE username='$uname'");
        if (mysqli_num_rows($check) > 0) {
            $_SESSION['message'] = 'Username already taken!';
            $_SESSION['message_type'] = 'error';
        } else {
            // Start a transaction to update multiple tables
            mysqli_begin_transaction($connect);

            try {
                // Update the doctor's username
                $update_uname = mysqli_query($connect, "UPDATE doctors SET username='$uname' WHERE username='$doc'");

                if (!$update_uname) {
                    throw new Exception("Failed to update doctor's username.");
                }

                // Update the username in appointments table
                $update_appointments = mysqli_query($connect, "UPDATE appointment SET doctor_username='$uname' WHERE doctor_username='$doc'");

                if (!$update_appointments) {
                    throw new Exception("Failed to update appointments.");
                }

                // Update the username in the income table
                $update_income = mysqli_query($connect, "UPDATE income SET doctor='$uname' WHERE doctor='$doc'");

                if (!$update_income) {
                    throw new Exception("Failed to update income records.");
                }

                // Commit the transaction
                mysqli_commit($connect);

                // Update the session variable for doctor username
                $_SESSION['doctor_username'] = $uname; // Update session variable
                $doc = $uname; // Also update $doc to reflect the new username in the current request

                // Set success message
                $_SESSION['message'] = 'Username changed successfully!';
                $_SESSION['message_type'] = 'success';

            } catch (Exception $e) {
                // Rollback the transaction if any query fails
                mysqli_roll_back($connect);

                // Set error message
                $_SESSION['message'] = 'Error: ' . $e->getMessage();
                $_SESSION['message_type'] = 'error';
            }
        }
    }
}

// Handle password change
if (isset($_POST['change_pass'])) {
    $old_pass = $_POST['old_pass'];
    $new_pass = $_POST['new_pass'];
    $con_pass = $_POST['con_pass'];

    if ($old_pass != $row['password']) {
        $_SESSION['message'] = 'Old password incorrect!';
        $_SESSION['message_type'] = 'error';
    } elseif (empty($new_pass)) {
        $_SESSION['message'] = 'New password cannot be empty!';
        $_SESSION['message_type'] = 'error';
    } elseif ($new_pass != $con_pass) {
        $_SESSION['message'] = 'Passwords do not match!';
        $_SESSION['message_type'] = 'error';
    } else {
        // Update password
        mysqli_query($connect, "UPDATE doctors SET password='$new_pass' WHERE username='$doc'");
        $_SESSION['message'] = 'Password changed successfully!';
        $_SESSION['message_type'] = 'success';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .card-custom {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Sidebar */
        .sidebar {
            height: 100%;
            background: #17a2b8;
            padding-top: 20px;
            transition: 0.3s;
        }

        .sidebar a {
            display: block;
            padding: 12px;
            color: white;
            text-decoration: none;
            transition: 0.3s;
            font-weight: bold;
            text-align: center;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Mobile Sidebar */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                width: 250px;
                left: -250px;
                top: 0;
                z-index: 1050;
                padding-top: 50px;
            }

            .sidebar.show {
                left: 0;
            }
        }

        /* Dashboard Cards */
        .dashboard-card {
            height: 130px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px;
            color: white;
            margin-bottom: 15px;
        }

        .icon-container {
            font-size: 2rem;
        }

        /* Header Navbar
        nav.navbar {
            /* margin-bottom: 20px; 
        } 

        /* Toggle Button */
        #sidebarToggle {
            margin-top: -10px;
            margin-left: 10px;
        }

        .sidebar a.active {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 5px;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <?php include("header.php"); ?>

    <div class="container-fluid">
        <div class="row">
        <div class="col-12 col-md-2 p-0">
                <div class="sidebar bg-info" id="sidebar">
                    <a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="profile.php"><i class="fas fa-user-md"></i> My Profile</a>
                    <a href="appointment.php"><i class="fas fa-calendar-check"></i> Appointments</a>
                    <a href="patient.php"><i class="fas fa-procedures"></i> Patients</a>
                    <a href="../login/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <div class="col-md-10 p-4">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h2 class="text-center mb-5 font-weight-bold text-info">My Profile</h2>

                        <div class="row">
                            <div class="col-md-5 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-info text-white text-center">
                                        <h5>Profile Picture</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <img src="img/<?php echo $row['profile']; ?>" class="img-fluid rounded-circle mb-3"
                                            style="width:200px; height:200px; object-fit:cover;">
                                        <form method="post" enctype="multipart/form-data">
                                            <input type="file" name="img" class="form-control-file mb-3">
                                            <button type="submit" name="upload" class="btn btn-outline-success btn-sm btn-block">Update Profile</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-success text-white text-center">
                                        <h5>Doctor Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-5 font-weight-bold">Full Name:</div>
                                            <div class="col-7"><?php echo $row['full_name']; ?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5 font-weight-bold">Department:</div>
                                            <div class="col-7"><?php echo $row['department']; ?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5 font-weight-bold">Username:</div>
                                            <div class="col-7"><?php echo $doc; ?></div> <!-- Using updated $doc -->
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5 font-weight-bold">Email:</div>
                                            <div class="col-7"><?php echo $row['email']; ?></div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-5 font-weight-bold">Salary:</div>
                                            <div class="col-7">Rs. <?php echo number_format($row['salary']); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-warning text-white text-center">
                                        <h5>Change Username</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <input type="text" name="uname" class="form-control" placeholder="Enter New Username" required>
                                            </div>
                                            <button type="submit" name="change_uname" class="btn btn-outline-warning btn-block">Change Username</button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-danger text-white text-center">
                                        <h5>Change Password</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-group">
                                                <input type="password" name="old_pass" class="form-control mb-2" placeholder="Old Password" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="new_pass" class="form-control mb-2" placeholder="New Password" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="con_pass" class="form-control mb-2" placeholder="Confirm Password" required>
                                            </div>
                                            <button type="submit" name="change_pass" class="btn btn-outline-danger btn-block">Change Password</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- SweetAlert based on message type -->
    <?php if (isset($_SESSION['message'])): ?>
        <script>
            Swal.fire({
                title: "<?php echo ucfirst($_SESSION['message_type']); ?>",
                text: "<?php echo $_SESSION['message']; ?>",
                icon: "<?php echo $_SESSION['message_type']; ?>",
                confirmButtonText: "OK"
            }).then(() => {
                // Clear the message from the session after it is shown
                <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
            });
        </script>
    <?php endif; ?>
    <script>
        document.getElementById("sidebarToggle").addEventListener("click", function(event) {
            document.getElementById("sidebar").classList.toggle("show");
            event.stopPropagation();
        });

        document.addEventListener("click", function(event) {
            let sidebar = document.getElementById("sidebar");
            let toggleButton = document.getElementById("sidebarToggle");
            if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
                sidebar.classList.remove("show");
            }
        });

        // Add Active class to current link
        const currentLocation = window.location.href;
        const menuItems = document.querySelectorAll('.sidebar a');

        menuItems.forEach(item => {
            if (item.href === currentLocation) {
                item.classList.add('active');
            }
        });
    </script>

</body>

</html>
