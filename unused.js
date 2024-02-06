        // New JavaScript code for search functionality
        document.getElementById("search-bar").addEventListener("input", function() {
            const searchTerm = this.value;

            // Send an AJAX request to fetch loans matching the search term
            // (implement this part using fetch or XMLHttpRequest)
        });
        document.getElementById("search-bar").addEventListener("keyup", function(event) {
        if (event.key === "Enter") {
          const searchTerm = this.value;

          fetch("search_loans.php?search=" + encodeURIComponent(searchTerm))
            .then(response => response.json())
            .then(data => {
              displaySearchResults(data); // Call a function to display results
            });
        }
      });
      //display loan function
      function displaySearchResults(loans) {
  // Clear potential previous results
  const resultsDiv = document.getElementById("search-results");
  resultsDiv.innerHTML = "";

  if (loans.length === 0) {
    resultsDiv.textContent = "No loans found.";
  } else {
    // Create table structure
    const table = document.createElement("table");
    table.innerHTML = `
      <thead>
        <tr>
          <th>Borrower Name</th>
          <th>Borrowed Amount</th>
          <th>Borrow Date</th>
          <th>Borrower Total</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    `;

    // Track borrower totals
    const borrowers = {};

    // Iterate through loans
    loans.forEach(loan => {
      const borrowerName = loan.borrower_name;

      // Calculate and store borrower total
      borrowers[borrowerName] = (borrowers[borrowerName] || 0) + parseFloat(loan.borrowed_amount);

      // Create table row with borrower total
      const row = document.createElement("tr");
      row.innerHTML = `
        <td>${borrowerName}</td>
        <td>${loan.borrowed_amount}</td>
        <td>${loan.borrow_date}</td>
        <td>${borrowers[borrowerName].toFixed(2)}</td>
      `;
      table.querySelector("tbody").appendChild(row);
    });

    // Add overall total row
    const totalRow = document.createElement("tr");
    totalRow.innerHTML = `
      <td>Total</td>
      <td colspan="3">${loans.reduce((total, loan) => total + parseFloat(loan.borrowed_amount), 0).toFixed(2)}</td>
    `;
    table.querySelector("tbody").appendChild(totalRow);

    // Append table to results section
    resultsDiv.appendChild(table);
  }
}