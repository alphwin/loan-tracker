<?php
// Connect to your database
$conn = mysqli_connect("localhost", "root", "", "loan_tracker");

// Retrieve the search term from the query string
$searchTerm = isset($_GET["search"]) ? $_GET["search"] : "";

// Query the database for loans matching the search term
$sql = "SELECT * FROM loans WHERE borrower_name LIKE '%$searchTerm%'";
$result = mysqli_query($conn, $sql);

// Fetch the results into an array
$loans = [];
while ($row = mysqli_fetch_assoc($result)) {
    $loans[] = $row;
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="search.css">
    <title>Search Results</title>
</head>
<body>
  <header>
    <nav>
        <a href="index.html">Home</a>
    </nav>
  <h1>Search Results for: <?php echo htmlspecialchars($searchTerm); ?></h1>
  </header>
 

    <?php if (count($loans) > 0) : ?>
        <table>
            <thead>
                <tr>
                    <th>Borrower Name</th>
                    <th>Borrowed Amount</th>
                    <th>Modify</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loans as $loan) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($loan["borrower_name"]); ?></td>
                        <td>$<?php echo number_format($loan["borrowed_amount"], 2); ?></td>
                        <td><button class="modify-button" data-borrower-id="<?php echo $loan["id"]; ?>">Modify</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No loans found for the search term.</p>
    <?php endif; ?>

    <div id="modify-loan-modal" class="modal">
        <div class="modal-content"></div>
    </div>

    <script>
        document.addEventListener("click", function (event) {
            if (event.target.classList.contains("modify-button")) {
                const borrowerId = event.target.dataset.borrowerId;
                fetch("get_loan_details.php?borrower_id=" + borrowerId)
                    .then(response => response.json())
                    .then(loanDetails => {
                        // Populate the modify-loan-modal with loan details
                        const modalContent = document.querySelector("#modify-loan-modal .modal-content");
                        modalContent.innerHTML = `
                            <h2>Modify Loan</h2>
                            <p>Borrower Name: ${loanDetails.borrower_name}</p>
                            <p>Current Borrowed Amount: $${loanDetails.borrowed_amount}</p>
                            <form id="modify-loan-form">
                                <input type="hidden" id="borrower_id" value="${loanDetails.id}">
                                <label for="modify-amount">Amount:</label>
                                <input type="number" id="modify-amount" step="0.01" required>
                                <button type="button" id="add-button">Add</button>
                                <button type="button" id="reduce-button">Reduce</button>
                            </form>
                        `;

                        // Handle form submission
                        const modifyLoanForm = document.getElementById("modify-loan-form");
                        const addBtn = document.getElementById("add-button");
                        const reduceBtn = document.getElementById("reduce-button");

                        addBtn.addEventListener("click", function () {
                            handleFormSubmission("add");
                        });

                        reduceBtn.addEventListener("click", function () {
                            handleFormSubmission("reduce");
                        });

                        function handleFormSubmission(action) {
                            const modifyAmount = document.getElementById("modify-amount").value;
                            const borrowerId = document.getElementById("borrower_id").value;

                            fetch("modify_loan.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/x-www-form-urlencoded"
                                },
                                body: `borrower_id=${borrowerId}&modify_amount=${modifyAmount}&action=${action}`
                            })
                                .then(response => {
                                    if (response.ok) {
                                        // Success: Update the table and display a message
                                        window.location.reload();
                                    } else {
                                        // Error: Display an error message
                                        console.error("Error modifying loan:", response.statusText);
                                        // ... (Handle the error appropriately)
                                    }
                                });
                        }
                    });
            }
        });
    </script>
</body>
</html>
