<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Upload CSV</title>
</head>
<body>
    <input type="file" id="csvFileInput" accept=".csv" />
    <button onclick="openCsvInNewTab()">Open CSV in New Tab</button>

    <script>
    function openCsvInNewTab() {
    var fileInput = document.getElementById('csvFileInput');
    if (fileInput.files.length === 0) {
        alert("Selectează un fișier CSV mai întâi.");
        return;
    }

    var file = fileInput.files[0];
    var reader = new FileReader();

    reader.onload = function(event) {
        var csvData = event.target.result;
        displayCsvInNewTab(csvData);
    };

    reader.onerror = function() {
        alert('Eroare la citirea fișierului!');
    };

    reader.readAsText(file);
}

function displayCsvInNewTab(csvData) {
    var newTab = window.open();
    var htmlContent = `
        <html>
        <head>
            <title>CSV Data</title>
            <style>
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
            </style>
        </head>
        <body>
            <table>
                ${generateTableContent(csvData)}
            </table>
        </body>
        </html>
    `;
    newTab.document.open();
    newTab.document.write(htmlContent);
    newTab.document.close();
}

function generateTableContent(csvData) {
    var rows = csvData.split("\n");
    var tableContent = '';

    rows.forEach((row, index) => {
        var columns = row.split(",");
        var rowContent = columns.map(col => `<td>${col}</td>`).join("");
        tableContent += `<tr>${rowContent}</tr>`;
    });

    return tableContent;
}</script>
</body>
</html>