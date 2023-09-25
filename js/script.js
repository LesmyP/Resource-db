async function fetchFavourites(url) {
  const repsonse = await fetch(url);
  const data = await repsonse.json();
  displayData(data);
}

// call funstion to fetch data
fetchFavourites("app/select.php");

// display data - table
function displayData(data) {
  console.log(data);
  const display = document.querySelector("#display");
  display.innerHTML = "";

  // Check if data is null or undefined
  if (!data) {
    display.innerHTML = "No data available.";
    return;
  }

  // Check if data is an empty array
  if (data.length === 0) {
    display.innerHTML = "No data available.";
    return;
  }

  const table = document.createElement("table");
  table.classList.add("resource-table");

  // Create table header
  const thead = document.createElement("thead");
  const headerRow = document.createElement("tr");
  const headers = ["▼ Name", "▼ Link", "▼ Type", "Description", "▼ Keyword"];

  headers.forEach((headerText, index) => {
    const th = document.createElement("th");
    th.textContent = headerText;
    th.dataset.columnIndex = index; // Store the column index for sorting
    th.addEventListener("click", () => sortTable(index)); // Add a click event listener for sorting
    headerRow.appendChild(th);
  });

  thead.appendChild(headerRow);
  table.appendChild(thead);

  // Create table body
  const tbody = document.createElement("tbody");

  data.forEach((resource) => {
    const row = document.createElement("tr");
    const columns = [
      "resourceName",
      "resourceLink",
      "resourceType",
      "resourceDescription",
      "resourceKeyword",
    ];

    columns.forEach((columnKey) => {
      const cell = document.createElement("td");

      // Check if the column is "resourceLink" and create a hyperlink
      if (columnKey === "resourceLink") {
        const link = document.createElement("a");
        link.href = resource[columnKey];
        link.textContent = resource[columnKey];
        link.target = "_blank"; // Open the link in a new tab
        cell.appendChild(link);
      } else {
        cell.textContent = resource[columnKey];
      }

      row.appendChild(cell);
    });

    tbody.appendChild(row);
  });

  table.appendChild(tbody);
  display.appendChild(table);
}

//// to sort data alphabetically
let currentSortColumn = null;
let isAscending = true;

function sortTable(columnIndex) {
  const table = document.querySelector(".resource-table");
  const tbody = table.querySelector("tbody");
  const rows = Array.from(tbody.querySelectorAll("tr"));

  if (currentSortColumn === columnIndex) {
    isAscending = !isAscending;
    rows.reverse();
  } else {
    currentSortColumn = columnIndex;
    isAscending = true;
    rows.sort((a, b) => {
      const cellA = a.cells[columnIndex].textContent.toLowerCase();
      const cellB = b.cells[columnIndex].textContent.toLowerCase();
      return isAscending
        ? cellA.localeCompare(cellB)
        : cellB.localeCompare(cellA);
    });
  }

  tbody.innerHTML = ""; // Clear the table body

  // Reappend sorted rows to the table
  rows.forEach((row) => {
    tbody.appendChild(row);
  });
}

// const submitButton = document.querySelector("#submit");
const submitButton = document.querySelector("#submit");
submitButton.addEventListener("click", getFormData);

function getFormData(event) {
  event.preventDefault();

  // get the form data and call an async function
  const insertFormData = new FormData(document.querySelector("#resourceForm"));
  let url = "app/insert_2.php";
  // reset form here
  document.querySelector("#resource_id").value = "";
  document.querySelector("#resource_name").value = "";
  document.querySelector("#resource_link").value = "";
  document.querySelector("#resource_type").value = "";
  document.querySelector("#resource_description").value = "";
  document.querySelector("#resource_keyword").value = "";
  inserter(insertFormData, url);
}

async function inserter(data, url) {
  const response = await fetch(url, {
    method: "POST",
    body: data,
  });
  const confirmation = await response.json();

  console.log(confirmation);
  //call function again to refresh the page
  fetchFavourites("app/select.php");
}
