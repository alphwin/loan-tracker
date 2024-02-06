<?php
// Connect to your database
$conn = mysqli_connect("localhost", "root", "", "loan_tracker");

// Retrieve the form data from the POST request
$borrowerId = $_POST["borrower_id"];
$modifyAmount = $_POST["modify_amount"];
$action = $_POST["action"];

// Validate user input (implement your own validation)

// Update the loan amount based on the action
$updateSql = "";
if ($action === "add") {
  $updateSql = "UPDATE loans SET borrowed_amount = borrowed_amount + $modifyAmount WHERE id = $borrowerId";
} else if ($action === "reduce") {
  $updateSql = "UPDATE loans SET borrowed_amount = borrowed_amount - $modifyAmount WHERE id = $borrowerId";
}

if ($updateSql !== "") {
  $result = mysqli_query($conn, $updateSql);

  if ($result) {
    echo "Loan modified successfully.";
  } else {
    echo "Error modifying loan:", mysqli_error($conn);
  }
} else {
  echo "Invalid action";
}
?>
