<?php
include("header.php");
include("../include/connection.php");

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit();
}

$error = [];
$success = "";
$admin_id = $_SESSION['admin'];

$query = "SELECT * FROM admin WHERE ID='" . mysqli_real_escape_string($connect, $admin_id) . "'";
$result = mysqli_query($connect, $query);
$admin_data = ($result && mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result) : [];
$admin_name = $admin_data['full_name'] ?? "UNKNOWN";

if (isset($_POST['update'])) {
    $id = mysqli_real_escape_string($connect, $_POST['id']);
    $newUname = trim($_POST['new_uname']);
    $newPass = trim($_POST['new_pass']);
    $newImage = $_FILES['new_img']['name'];

    if (empty($newUname)) {
        $error['new_u'] = "Enter a new Username";
    } elseif (empty($newPass)) {
        $error['new_p'] = "Enter a new Password";
    }

    if (count($error) == 0) {
        $hashedPass = password_hash($newPass, PASSWORD_BCRYPT);
        $updateQuery = "UPDATE admin SET username='$newUname', password='$hashedPass'";

        if (!empty($newImage)) {
            $img_name = time() . '_' . basename($newImage);
            $updateQuery .= ", profile='$img_name'";
        }

        $updateQuery .= " WHERE id='$id'";
        mysqli_query($connect, $updateQuery);

        if (!empty($newImage)) {
            $targetDir = "img/";
            move_uploaded_file($_FILES['new_img']['tmp_name'], $targetDir . $img_name);
        }

        $success = "Admin information updated successfully.";
    }
}

if (isset($_POST['add'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $gender = trim($_POST['gender']);
    $uname = trim($_POST['uname']);
    $pass = trim($_POST['pass']);
    $admin_status = trim($_POST['admin_status']);
    $image = $_FILES['img']['name'];

    if (empty($full_name) || empty($email) || empty($phone) || empty($gender) || empty($uname) || empty($pass) || empty($admin_status) || empty($image)) {
        $error['form'] = "All fields are required";
    } else {
        $hashedPass = password_hash($pass, PASSWORD_BCRYPT);
        $img_name = time() . '_' . basename($image);

        $q = "INSERT INTO admin (full_name, email, phone, gender, username, password, admin_status, profile, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'approved')";

        $stmt = mysqli_prepare($connect, $q);
        mysqli_stmt_bind_param($stmt, "ssssssss", $full_name, $email, $phone, $gender, $uname, $hashedPass, $admin_status, $img_name);

        if (mysqli_stmt_execute($stmt)) {
            move_uploaded_file($_FILES['img']['tmp_name'], 'img/' . $img_name);
            $success = "Admin added successfully.";
        } else {
            $error['db'] = "Database error: " . mysqli_error($connect);
        }
    }
}

$current_username = isset($admin_data['username']) ? mysqli_real_escape_string($connect, $admin_data['username']) : '';
$query = "SELECT * FROM admin WHERE username != '$current_username'";
$res = mysqli_query($connect, $query);

if (isset($_GET['remove'])) {
    $remove_id = mysqli_real_escape_string($connect, $_GET['remove']);
    if ($remove_id == $admin_id) {
        $error['remove'] = "You cannot delete your own account!";
    } else {
        $check_query = "SELECT * FROM admin WHERE id='$remove_id' AND admin_status!='main admin'";
        $check_result = mysqli_query($connect, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $delete_query = "DELETE FROM admin WHERE id='$remove_id'";
            if (mysqli_query($connect, $delete_query)) {
                $success = "Admin removed successfully.";
            } else {
                $error['remove'] = "Error deleting admin.";
            }
        } else {
            $error['remove'] = "You cannot remove a main admin.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn {
            border-radius: 8px;
        }
        .alert {
            border-radius: 10px;
            margin-top: 10px;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        img.profile-pic {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <?php include("sidenav.php"); ?>

        <div class="col-md-10 mt-3">
            <?php if (!empty($success)) { ?>
                <div class="alert alert-success text-center shadow-sm"><?= htmlspecialchars($success) ?></div>
            <?php } ?>
            <?php foreach ($error as $err) { ?>
                <div class="alert alert-danger text-center shadow-sm"><?= htmlspecialchars($err) ?></div>
            <?php } ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header bg-primary text-white text-center">
                            <h4>Edit Admin</h4>
                        </div>
                        <div class="card-body">
                            <?php
                            if (isset($_GET['edit'])) {
                                $edit_id = mysqli_real_escape_string($connect, $_GET['edit']);
                                $edit_query = "SELECT * FROM admin WHERE id='$edit_id' AND admin_status!='main admin'";
                                $edit_result = mysqli_query($connect, $edit_query);

                                if ($edit_result && mysqli_num_rows($edit_result) > 0) {
                                    $edit_row = mysqli_fetch_assoc($edit_result);
                                    ?>
                                    <form method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($edit_id) ?>">
                                        <div class="form-group">
                                            <label>New Username</label>
                                            <input type="text" name="new_uname" class="form-control" value="<?= htmlspecialchars($edit_row['username']) ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" name="new_pass" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>New Admin Picture</label>
                                            <input type="file" name="new_img" class="form-control">
                                        </div>
                                        <button type="submit" name="update" class="btn btn-success btn-block">Update Admin</button>
                                    </form>
                                    <?php
                                } else {
                                    echo "<div class='alert alert-danger text-center'>You cannot edit the main admin.</div>";
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div class="card shadow">
                        <div class="card-header bg-dark text-white text-center">
                            <h4>Admin List</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-striped table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Profile</th>
                                    <th>Username</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($row = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                        <td><img src="img/<?= htmlspecialchars($row['profile']) ?>" class="profile-pic"></td>
                                        <td><?= htmlspecialchars($row['username']) ?></td>
                                        <td>
                                            <a href="admin.php?edit=<?= $row['id'] ?>" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="admin.php?remove=<?= $row['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to remove this admin?');">
                                                <i class="fas fa-trash"></i> Remove
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-success text-white text-center">
                            <h4>Add Admin</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label>Full Name</label>
                                    <input type="text" name="full_name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control">
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="uname" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="pass" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Admin Status</label>
                                    <select name="admin_status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="main admin">Main Admin</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Profile Picture</label>
                                    <input type="file" name="img" class="form-control">
                                </div>
                                <button type="submit" name="add" class="btn btn-success btn-block">Add Admin</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

</body>
</html>


