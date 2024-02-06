<?php
// Connect to database (replace placeholders with your credentials)
$conn = mysqli_connect("localhost", "root", "", "loan_tracker");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$searchTerm = mysqli_real_escape_string($conn, $_GET["search"]);

$sql = "SELECT borrower_name, borrowed_amount, borrow_date FROM loans WHERE borrower_name LIKE '%$searchTerm%'";
$result = mysqli_query($conn, $sql);

$loans = [];
while ($row = mysqli_fetch_assoc($result)) {
  $loans[] = $row;
}

mysqli_close($conn);

echo json_encode($loans);
?>