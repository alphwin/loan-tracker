<?php
// Connect to MySQL database
$conn = mysqli_connect("127.0.0.1", "root", "", "loan_tracker");

// Check for connection errors
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Remove zero-amount loans
$sql = "DELETE FROM loans WHERE borrowed_amount = 0";
mysqli_query($conn, $sql);

// Fetch remaining loans
$sql = "SELECT borrower_name, borrowed_amount, borrow_date FROM loans";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>
<body>
    <header>
    <nav>
        <a href="index.html">Home</a>
    </nav>
    <h1>List of Loans</h1>
    </header>
    <style>
        header {
            background-color: #f2f2f2;
            padding: 10px;
            display: flex;
            text-align: center;
            justify-content: space-between;
            align-items: center; /* Vertically align elements */
        }
        nav {
            /* Style the navigation bar */
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        nav a {
            text-decoration: none;
            padding: 10px;
            color: #333;
        }

        nav a:hover {
            background-color: #eee; /* Highlight on hover */
        }
        h1 {
            margin: 0; /* Remove default margin for better alignment */
        }
        main {
            padding-top: 10px; /* Adjust based on header height */
        }

        table {
            border-collapse: collapse;
            margin: auto; /* Center the table */
            width: 50%; /* Optional: Set a width for the table */
        }
        th, td {
            text-align: center; /* Center cell contents */
            padding: 8px;
            border: 1px solid #ddd;
        }

    /* Styling for headers */
        th {
        background-color: #f2f2f2;
        font-weight: bold;
        }
    </style>
    <main>
        <table>
        <thead>
            <tr>
            <th>Borrower Name</th>
            <th>Borrowed Amount</th>
            <th>Borrow Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["borrower_name"] . "</td>";
            echo "<td>" . $row["borrowed_amount"] . "</td>";
            echo "<td>" . $row["borrow_date"] . "</td>";
            echo "</tr>";
            }
            ?>
        </tbody>
        </table>
    </main>
</body>