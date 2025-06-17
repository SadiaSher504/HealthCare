<?php
include('../include/connection.php');

if(isset($_POST['department'])){
    $department = $_POST['department'];

    $query = "SELECT * FROM doctors WHERE department='$department' AND status='Approved'";
    $result = mysqli_query($connect, $query);

    $output = '<option value="">-- Select Doctor --</option>';
    while($row = mysqli_fetch_assoc($result)){
        $output .= '<option value="'.$row['username'].'" 
        data-days="'.$row['available_days'].'" 
        data-from="'.$row['available_time_from'].'" 
        data-to="'.$row['available_time_to'].'">
        '.$row['full_name'].'</option>';
    }
    echo $output;
}
?>
