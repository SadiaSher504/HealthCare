<?php
include("../include/connection.php");

if (isset($_POST['id']) && isset($_POST['type']) && isset($_POST['action'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $action = $_POST['action'];

    // Ensure ID and type are provided
    if (empty($id) || empty($type) || $action != 'reject') {
        echo json_encode(["status" => "error", "message" => "Invalid request parameters."]);
        exit;
    }

    // Sanitize input to prevent SQL injection
    $id = mysqli_real_escape_string($connect, $id);

    // Define the query to reject based on the type
    if ($type == 'doctor') {
        $query = "UPDATE doctors SET status='rejected' WHERE id='$id'";
    } elseif ($type == 'employee') {
        $query = "UPDATE employee SET status='rejected' WHERE id='$id'";
    } elseif ($type == 'account_branch') {
        $query = "UPDATE account_branch SET status='rejected' WHERE id='$id'";
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid type."]);
        exit;
    }

    // Execute the query
    if (mysqli_query($connect, $query)) {
        echo json_encode(["status" => "success", "message" => "Rejected successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to reject."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing required parameters."]);
}
?>
