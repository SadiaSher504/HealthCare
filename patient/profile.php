<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Profile</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJf23R7mC5dK4Hb3Ak0Nl5aO3+q0h6b6h2z7BoeWxlgD1yIuL99e5HJ2XNKQ" crossorigin="anonymous">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Custom CSS -->
    <style>
    body {
        background-color: #f9f9f9;
    }

    .profile-card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 100%; /* Ensure it takes full width on smaller screens */
        max-width: 600px; /* Maximum width for large screens */
        margin: auto; /* Center the card */
    }

    .profile-card img {
        border-radius: 50%;
        width: 150px;
        height: 150px;
        object-fit: cover;
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 8px;
    }

    .btn-info,
    .btn-success {
        border-radius: 8px;
        padding: 10px 20px;
    }

    .table th,
    .table td {
        text-align: center;
    }

    .section-header {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .image-upload-form {
        margin-top: 10px;
    }

    .profile-details td {
        font-weight: 600;
    }

    /* Centered form layout */
    .profile-content {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .profile-details-table {
        width: 100%;
        max-width: 600px;
    }

    .profile-info {
        width: 100%;
        max-width: 600px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .profile-card {
            width: 90%; /* Make profile card smaller on mobile */
        }

        .profile-content {
            padding: 15px;
        }

        .image-upload-form input {
            max-width: 100%; /* Ensure input fields are responsive */
        }

        .profile-info input {
            width: 100%; /* Ensure input fields fill the available space */
        }

        .profile-details-table {
            font-size: 0.9rem; /* Reduce font size for mobile */
        }

        .table th,
        .table td {
            font-size: 0.9rem; /* Reduce font size in the table for smaller screens */
        }
    }

    @media (max-width: 576px) {
        .profile-card {
            width: 95%; /* Further reduce width on very small screens */
            padding: 15px; /* Adjust padding */
        }

        .profile-card img {
            width: 120px;
            height: 120px; /* Reduce profile image size */
        }

        .section-header {
            font-size: 1.1rem; /* Adjust section header font size */
        }

        .profile-details td {
            font-size: 0.85rem; /* Make the table text smaller */
        }
    }
</style>

</head>

<body>
    <div>
        <?php include("header.php"); ?>
        <?php include('../include/connection.php'); ?>
    </div>

    <div class="container-fluid">
        <div class="row">
            <?php include("sidenav.php"); ?>

            <div class="col-md-9 profile-content">
                <div class="profile-card">
                    <h5 class="section-header">My Profile</h5>
                    <?php
                    include("../include/connection.php");

                    // Check if session variable is set
                    if (!isset($_SESSION['patient'])) {
                        header("Location: login.php"); // Redirect to login if not logged in
                        exit();
                    }

                    $patient = $_SESSION['patient'];

                    // Fetch patient data
                    $query = "SELECT * FROM patient WHERE username='$patient'";
                    $res = mysqli_query($connect, $query);
                    $row = mysqli_fetch_array($res);

                    // Default profile image if none exists
                    $profileImage = !empty($row['profile']) ? $row['profile'] : "default.jpg";
                    ?>

                    <!-- Display Profile Image -->
                    <div class="text-center">
                        <img src='img/<?php echo $profileImage; ?>' alt="Profile Picture">
                    </div>

                    <!-- Upload Image Form -->
                    <?php
                    if (isset($_POST['upload'])) {
                        if (!empty($_FILES['img']['name'])) {
                            $image = $_FILES['img']['name'];
                            $imageTmpName = $_FILES['img']['tmp_name'];
                            $imagePath = "uploads/" . basename($image);

                            // Move the uploaded image to the "img" folder
                            if (move_uploaded_file($imageTmpName, $imagePath)) {
                                // Update the profile image in the database
                                $updateQuery = "UPDATE patient SET profile='$image' WHERE username='$patient'";
                                if (mysqli_query($connect, $updateQuery)) {
                                    echo "<script>
                                            Swal.fire({
                                                title: 'Success!',
                                                text: 'Profile image updated successfully.',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            }).then(function() {
                                                window.location.href='profile.php';
                                            });
                                          </script>";
                                }
                            } else {
                                echo "<script>
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Error uploading file.',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                      </script>";
                            }
                        } else {
                            echo "<script>
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Please select an image.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                  </script>";
                        }
                    }
                    ?>

                    <!-- Image Upload Form -->
                    <form method="post" enctype="multipart/form-data" class="text-center image-upload-form">
                        <input type="file" name="img" class="form-control mb-3" style="max-width: 300px; margin: auto;">
                        <input type="submit" name="upload" class="btn btn-info" value="Update Profile Image">
                    </form>

                    <!-- Display Patient Details -->
                    <table class="table table-bordered my-3 profile-details-table">
                        <tr>
                            <th colspan="2">My Details</th>
                        </tr>
                        <tr>
                            <td>Full Name</td>
                            <td><?php echo $row['full_name']; ?></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td><?php echo $row['username']; ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?php echo $row['email']; ?></td>
                        </tr>
                        <tr>
                            <td>Phone Number</td>
                            <td><?php echo $row['phone']; ?></td>
                        </tr>
                    </table>
                </div>

                <!-- Change Username Section -->
                <div class="profile-card mt-4">
                    <h5 class="section-header">Change Username</h5>
                    <?php
                    if (isset($_POST['change_uname'])) {
                        $uname = $_POST['uname'];
                        if (!empty($uname)) {
                            $query = "UPDATE patient SET username='$uname' WHERE username='$patient'";
                            $res = mysqli_query($connect, $query);
                            if ($res) {
                                $_SESSION['patient'] = $uname;
                                echo "<script>
                                        Swal.fire({
                                            title: 'Success!',
                                            text: 'Username changed successfully.',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(function() {
                                            window.location.href='profile.php';
                                        });
                                      </script>";
                            }
                        } else {
                            echo "<script>
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Username field is required.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                  </script>";
                        }
                    }
                    ?>
                    <form method="post" class="profile-info">
                        <input type="text" name="uname" class="form-control mb-3" placeholder="Enter New Username">
                        <input type="submit" name="change_uname" class="btn btn-success" value="Update Username">
                    </form>

                    <!-- Change Password Section -->
                    <h5 class="section-header mt-4">Change Password</h5>
                    <?php
                    if (isset($_POST['change_pass'])) {
                        $old = $_POST['old_pass'];
                        $new = $_POST['new_pass'];
                        $con = $_POST['con_pass'];

                        $query = "SELECT password FROM patient WHERE username='$patient'";
                        $re = mysqli_query($connect, $query);
                        $row = mysqli_fetch_array($re);
                        $storedPassword = $row['password'];

                        if (empty($old) || empty($new) || empty($con)) {
                            echo "<script>
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'All fields are required.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                  </script>";
                        } elseif ($old !== $storedPassword) {
                            echo "<script>
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Old password is incorrect.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                  </script>";
                        } elseif ($new !== $con) {
                            echo "<script>
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'New Password and Confirm Password do not match.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                  </script>";
                        } else {
                            $updateQuery = "UPDATE patient SET password='$new' WHERE username='$patient'";
                            if (mysqli_query($connect, $updateQuery)) {
                                echo "<script>
                                        Swal.fire({
                                            title: 'Success!',
                                            text: 'Password changed successfully.',
                                            icon: 'success',
                                            confirmButtonText: 'OK'
                                        }).then(function() {
                                            window.location.href='profile.php';
                                        });
                                      </script>";
                            }
                        }
                    }
                    ?>

                    <form method="post" class="profile-info">
                        <div class="form-group">
                            <input type="password" name="old_pass" class="form-control mb-3" placeholder="Enter Old Password">
                        </div>
                        <div class="form-group">
                            <input type="password" name="new_pass" class="form-control mb-3" placeholder="Enter New Password">
                        </div>
                        <div class="form-group">
                            <input type="password" name="con_pass" class="form-control mb-3" placeholder="Confirm New Password">
                        </div>
                        <input type="submit" name="change_pass" class="btn btn-info" value="Change Password">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
