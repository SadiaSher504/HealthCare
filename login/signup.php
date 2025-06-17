<?php
session_start();
include("../include/connection.php");

if (isset($_POST['register'])) {
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    $errors = array();

    if (empty($full_name)) {
        $errors['register'] = "full_name";
    } elseif (empty($phone)) {
        $errors['register'] = "Enter Surname";
    } elseif (empty($username)) {
        $errors['register'] = "Enter Username";
    } elseif (empty($email)) {
        $errors['register'] = "Enter Email Address";
    } elseif (empty($gender)) {
        $errors['register'] = "Select Gender";
    } elseif (empty($password)) {
        $errors['register'] = "Enter Password";
    }

    if (count($errors) == 0) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Use prepared statements to prevent SQL injection
        $query = "INSERT INTO `admin`(`full_name`, `username`, `password`, `profile`, `phone`, `email`, `gender`, `status`) 
                  VALUES (?, ?, ?, '', ?, ?, ?, 'pending')";

        $stmt = mysqli_prepare($connect, $query);
        mysqli_stmt_bind_param($stmt, "ssssss", $full_name, $username, $password, $phone, $email, $gender);

        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>
                    alert('Admin registered successfully');
                    window.location.href = 'login.php';
                 </script>";
            exit; // Stop further execution to prevent the HTML below from being output
        } else {
            echo "<script>alert('Failed to register admin')</script>";
        }
    }
}

if (isset($errors['register'])) {
    $error_message = $errors['register'];
    $show_error = "<h5 class='text-center alert alert-danger'>$error_message</h5>";
} else {
    $show_error = "";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Custom CSS for bordered input fields */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            border: 1px solid #ced4da;
            /* Border color */
            border-radius: 5px;
            /* Border radius */
            padding: 10px;
            /* Padding */
            margin-bottom: 10px;
            /* Margin between input fields */
            width: 100%;
            /* Full width */
        }
    </style>
    <title>Admin Registration Form</title>
</head>

<body>
    <div class="container" style="width:800px; margin-top:px;">
        <div class="form-container">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <h4 style="text-align: center;">Admin Registration Form</h4>
                <div class="form-row">
                    <div class="col">
                        <div class="form-group">
                            <input type="text" name="full_name" class="form-control" placeholder="Enter Full Name" style="width:300px;">
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control" placeholder="Enter Phone" style="width:300px;">
                        </div>
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" placeholder="Enter Username" style="width:300px;">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Enter Email Address" style="width:300px;">
                        </div>
                        <div class="form-group">
                            <select name="gender" class="form-control" style="width:300px;">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="others">Others</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Enter Password" style="width:300px;">

                            <button type="submit" name="register" class="btn btn-primary" style="width:300px; margin-left: -310px;">Register</button>
            </form>

        </div>
    </div>
    <script src="script.js">
    </script>
</body>

</html>