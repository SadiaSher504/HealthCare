<?php
include("../include/connection.php");

// Queries
$doctorQuery = "SELECT * FROM doctors WHERE status='pending'";
$employeeQuery = "SELECT * FROM employee WHERE status='pending'";
$accountBranchQuery = "SELECT * FROM account_branch WHERE status='pending'";

// Execute Queries
$doctorRes = mysqli_query($connect, $doctorQuery);
$employeeRes = mysqli_query($connect, $employeeQuery);
$accountBranchRes = mysqli_query($connect, $accountBranchQuery);

$output = "";

// Doctors
$output .= "<div class='table-responsive mb-5'>
<h4>Pending Doctor Requests</h4>
<table class='table table-striped table-bordered'>
<thead class='table-info'>
<tr>
<th>ID</th>
<th>Full Name</th>
<th>Email</th>
<th>Department</th>
<th>Resume</th>
<th>Action</th>
</tr>
</thead>
<tbody>";

if (mysqli_num_rows($doctorRes) > 0) {
    while ($row = mysqli_fetch_assoc($doctorRes)) {
        $resumeLink = !empty($row['resume']) ? "../" . $row['resume'] : "";

        $output .= "<tr>
        <td>{$row['id']}</td>
        <td>{$row['full_name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['department']}</td>
        <td>";

        if (!empty($resumeLink)) {
            $output .= "<button class='btn btn-primary btn-sm view-resume' data-resume-url='{$resumeLink}'>View</button>";
        } else {
            $output .= "No Resume";
        }

        $output .= "</td>
        <td>
            <button class='btn btn-success btn-sm approve' id='{$row['id']}' data-type='doctor'>Approve</button>
            <button class='btn btn-danger btn-sm reject' id='{$row['id']}' data-type='doctor'>Reject</button>
        </td>
        </tr>";
    }
} else {
    $output .= "<tr><td colspan='6' class='text-center'>No pending doctor requests.</td></tr>";
}
$output .= "</tbody></table></div>";

// Employees
$output .= "<div class='table-responsive mb-5'>
<h4>Pending Employee Requests</h4>
<table class='table table-striped table-bordered'>
<thead class='table-info'>
<tr>
<th>ID</th>
<th>Full Name</th>
<th>Email</th>
<th>Department</th>
<th>Resume</th>
<th>Action</th>
</tr>
</thead>
<tbody>";

if (mysqli_num_rows($employeeRes) > 0) {
    while ($row = mysqli_fetch_assoc($employeeRes)) {
        $resumeLink = !empty($row['resume']) ? "../" . $row['resume'] : "";

        $output .= "<tr>
        <td>{$row['id']}</td>
        <td>{$row['full_name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['department']}</td>
        <td>";

        if (!empty($resumeLink)) {
            $output .= "<button class='btn btn-primary btn-sm view-resume' data-resume-url='{$resumeLink}'>View</button>";
        } else {
            $output .= "No Resume";
        }

        $output .= "</td>
        <td>
            <button class='btn btn-success btn-sm approve' id='{$row['id']}' data-type='employee'>Approve</button>
            <button class='btn btn-danger btn-sm reject' id='{$row['id']}' data-type='employee'>Reject</button>
        </td>
        </tr>";
    }
} else {
    $output .= "<tr><td colspan='6' class='text-center'>No pending employee requests.</td></tr>";
}
$output .= "</tbody></table></div>";

// Account Branch
$output .= "<div class='table-responsive mb-5'>
<h4>Pending Account Branch Requests</h4>
<table class='table table-striped table-bordered'>
<thead class='table-info'>
<tr>
<th>ID</th>
<th>Full Name</th>
<th>Email</th>
<th>Role</th>
<th>Resume</th>
<th>Action</th>
</tr>
</thead>
<tbody>";

if (mysqli_num_rows($accountBranchRes) > 0) {
    while ($row = mysqli_fetch_assoc($accountBranchRes)) {
        $output .= "<tr>
        <td>{$row['id']}</td>
        <td>{$row['full_name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['role']}</td>
        <td>";
        if (!empty($resumeLink)) {
            $output .= "<button class='btn btn-primary btn-sm view-resume' data-resume-url='{$resumeLink}'>View</button>";
        } else {
            $output .= "No Resume";
        }
        $output .= "</td>
        <td>
            <button class='btn btn-success btn-sm approve' id='{$row['id']}' data-type='account_branch'>Approve</button>
            <button class='btn btn-danger btn-sm reject' id='{$row['id']}' data-type='account_branch'>Reject</button>
        </td>
        </tr>";
    }
} else {
    $output .= "<tr><td colspan='4' class='text-center'>No pending account branch requests.</td></tr>";
}
$output .= "</tbody></table></div>";

echo $output;
?>

<style>
    /* Make the table scrollable on small screens */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table th {
        background-color: #17a2b8;
        color: white;
    }

    /* Responsive styling for buttons */
    .btn {
        margin: 0.2rem;
        padding: 0.5rem 1rem;
    }

    /* For smaller devices, stack the buttons */
    @media (max-width: 576px) {
        .btn {
            font-size: 0.8rem;
            padding: 0.3rem 0.7rem;
        }

        .table th,
        .table td {
            font-size: 0.9rem;
            padding: 0.5rem;
        }

        .table {
            font-size: 0.9rem;
        }

        /* Adjust table and form fields on smaller screens */
        .salary-input {
            width: 100% !important;
        }
    }

    /* Additional styling for the form and table elements */
    .table th,
    .table td {
        vertical-align: middle;
    }

    .table-responsive {
        margin-top: 1rem;
    }
</style>