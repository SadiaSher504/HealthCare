<?php

include($_SERVER['DOCUMENT_ROOT'] . '/hospital/include/connection.php');// Include the connection to your database

// Function to upload a file (resume/profile)
function uploadFile($file, $target_dir) {
    $target_file = $target_dir . basename($file["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowedTypes = ["pdf", "jpg", "jpeg", "png"];

    if (!in_array($fileType, $allowedTypes)) {
        return false; // Invalid file type
    }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $target_file;
    } else {
        return false; // Failed to upload
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get role from form
    $role = $_POST['role'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Process resume file
    $resume = uploadFile($_FILES['resume'], "uploads/resumes/");
    if ($resume === false) {
        die("Error uploading resume.");
    }

    // Process profile picture if provided
    $profile = isset($_FILES['profile']) ? uploadFile($_FILES['profile'], "uploads/profiles/") : null;
    if ($profile === false && isset($_FILES['profile'])) {
        die("Error uploading profile picture.");
    }

    // Insert based on role
    if ($role == "doctor") {
        // Get the department selected
        $department = $_POST['department'];

        $query = "INSERT INTO doctors (full_name, email, department, role, username, password, status, gender, resume)
                  VALUES ('$full_name', '$email', '$department', '$role', '$username', '$password', 'pending', 'unknown', '$resume')";

        if (mysqli_query($connect, $query)) {
            echo "Doctor application submitted successfully!";
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    } elseif ($role == "employee") {
        $query = "INSERT INTO employee (full_name, email, username, password, date_reg, profile, role, gender, status, resume)
                  VALUES ('$full_name', '$email', '$username', '$password', NOW(), '$profile', '$role', 'unknown', 'pending', '$resume')";

        if (mysqli_query($connect, $query)) {
            echo "Employee application submitted successfully!";
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    } elseif ($role == "account_branch") {
        $query = "INSERT INTO account_branch (full_name, username, password, status, profile, gender, email, date_reg, role, resume, salary)
                  VALUES ('$full_name', '$username', '$password', 'pending', '$profile', 'unknown', '$email', NOW(), '$role', '$resume', 0)";  // salary is set by admin later

        if (mysqli_query($connect, $query)) {
            echo "Account branch application submitted successfully!";
        } else {
            echo "Error: " . mysqli_error($connect);
        }
    } else {
        echo "Invalid role selected.";
    }
}
?>