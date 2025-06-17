<?php
include("../include/connection.php");

if (isset($_POST['id']) && isset($_POST['type']) && isset($_POST['action'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $action = $_POST['action'];
    $salary = isset($_POST['salary']) ? $_POST['salary'] : null;

    // Validate input
    if (empty($id) || empty($type)) {
        echo json_encode(["status" => "error", "message" => "Invalid request parameters."]);
        exit;
    }

    // Sanitize input to prevent SQL injection
    $id = mysqli_real_escape_string($connect, $id);
    $salary = mysqli_real_escape_string($connect, $salary);

    // Define the query based on the type (employee, doctor, account branch)
    if ($type == 'doctor') {
        // Update the doctor status to 'approved' and set the salary if provided
        if ($salary) {
            $query = "UPDATE doctors SET status='approved', salary='$salary' WHERE id='$id'";
        } else {
            $query = "UPDATE doctors SET status='approved' WHERE id='$id'";
        }
    } elseif ($type == 'employee') {
        // Update the employee status to 'approved' and set the salary
        $query = "UPDATE employee SET status='approved', salary='$salary' WHERE id='$id'";
    } elseif ($type == 'account_branch') {
        // Update the account branch status to 'approved' and set the salary
        if ($salary) {
            $query = "UPDATE account_branch SET status='approved', salary='$salary' WHERE id='$id'";
        } else {
            $query = "UPDATE account_branch SET status='approved' WHERE id='$id'";
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid type."]);
        exit;
    }

    // Execute the query
    if (mysqli_query($connect, $query)) {
        echo json_encode(["status" => "success", "message" => "Approved successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to approve."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing required parameters."]);
}
?>
