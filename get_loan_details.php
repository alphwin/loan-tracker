<?php
// Connect to your database
$conn = mysqli_connect("localhost", "root", "", "loan_tracker");

// Retrieve the borrower ID from the query string
$borrowerId = $_GET["borrower_id"];

// Fetch loan details based on the borrower ID
$sql = "SELECT * FROM loans WHERE id = $borrowerId";
$result = mysqli_query($conn, $sql);
$loanDetails = mysqli_fetch_assoc($result);

// Return the loan details as a JSON response
echo json_encode($loanDetails);
?>