<?php
// Connect to MySQL database
$conn = mysqli_connect("127.0.0.1", "root", "", "loan_tracker");

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Receive form data
$borrowerName = mysqli_real_escape_string($conn, $_POST["borrower_name"]);
$borrowedAmount = mysqli_real_escape_string($conn, $_POST["borrowed_amount"]);
$borrowDate = date("Y-m-d H:i:s"); // Get current date and time

// Prepare SQL query
$sql = "INSERT INTO loans (borrower_name, borrowed_amount, borrow_date) VALUES ('$borrowerName', '$borrowedAmount', '$borrowDate')";

// Execute query
if (mysqli_query($conn, $sql)) {
    // Success: Send a success message back to JavaScript
    echo "Loan added successfully";
} else {
    // Error: Handle the error and send an error message back to JavaScript
    die("Error adding loan: " . mysqli_error($conn));
}

// Close database connection
mysqli_close($conn);
?>
