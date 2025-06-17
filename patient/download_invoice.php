<?php
// Include database connection
include('../include/connection.php');

if (isset($_GET['id'])) {
    $invoice_id = $_GET['id'];

    // Fetch the invoice details from the database
    $query = "SELECT * FROM income WHERE id = '$invoice_id'";
    $result = mysqli_query($connect, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Set the content type to text/plain for download
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="invoice_' . $row['id'] . '.txt"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Create the content for the file
        $invoice_content = "Invoice ID: " . $row['id'] . "\n";
        $invoice_content .= "Doctor: " . $row['doctor'] . "\n";
        $invoice_content .= "Patient: " . $row['patient'] . "\n";
        $invoice_content .= "Discharge Date: " . $row['date_discharge'] . "\n";
        $invoice_content .= "Amount Paid: " . $row['amount_paid'] . "\n";
        $invoice_content .= "Description: " . $row['description'] . "\n";

        // Output the file content
        echo $invoice_content;
        exit;
    } else {
        echo "Invoice not found.";
    }
} else {
    echo "No invoice ID provided.";
}
?>
