import { APP_PORT } from './config.js';

// Afiseaza datele in tabelul specific PROJECTS
function renderStats(stats, year, type) {
    var tableBody = document.querySelector(`#${type}-table tbody`);
    
    if (!tableBody) {
        return; // Încheie funcția dacă tabelul nu este găsit
    }

    tableBody.innerHTML = ''; // Curăță conținutul actual al tabelului

    // Actualizează textul anului selectat pe pagină
    var selectedYearElement = document.getElementById('selected-year');
    if (selectedYearElement) {
        if (year) {
            selectedYearElement.textContent = year;
        } else {
            selectedYearElement.textContent = 'Choose a year...';
        }
    } else {
        console.error('Selected year element not found.');
    }

    // Iterează prin fiecare statistică și adaugă un rând nou în tabel pentru fiecare
    stats.forEach(stat => {
        var row = document.createElement('tr');
        var cells = `
                    <td>${stat.category}</td>
                    <td>${stat.subcategory}</td>
                    <td>${stat.beneficiaries}</td>
                `;
               
        row.innerHTML = cells;
        tableBody.appendChild(row);
    });
}


function saveTableAsSVG(tableId) {
    var table = document.getElementById(tableId);
    if (!table) {
        showSnackbar('Table element not found.', 'error');
        return;
    }

    var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    var svgNS = svg.namespaceURI;

    // Creează un container SVG cu dimensiunile tabelului
    var svgWidth = table.offsetWidth;
    var svgHeight = table.offsetHeight;

    svg.setAttribute('width', svgWidth);
    svg.setAttribute('height', svgHeight);

    // Adaugă stiluri CSS
    var styleElement = document.createElement('style');
    styleElement.textContent = `
        table { font-family: Arial, sans-serif; border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    `;
    svg.appendChild(styleElement);

    // Creează un container SVG pentru tabel
    var tableSvg = document.createElementNS(svgNS, 'foreignObject');
    tableSvg.setAttribute('width', '100%');
    tableSvg.setAttribute('height', '100%');

    // Creează un div pentru a înfășura tabelul
    var tableWrapper = document.createElement('div');
    tableWrapper.appendChild(table.cloneNode(true)); // Clonează tabelul

    // Adaugă div-ul la containerul SVG pentru tabel
    tableSvg.appendChild(tableWrapper);

    // Adaugă containerul SVG pentru tabel la SVG principal
    svg.appendChild(tableSvg);

    // Serializează SVG
    var serializer = new XMLSerializer();
    var svgString = serializer.serializeToString(svg);

    // Crează un link pentru descărcare
    var link = document.createElement('a');
    link.download = 'table.svg';
    link.href = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svgString);
    link.click();
    showSnackbar('Table saved as SVG!', 'info');
}



// Download CSV file related to the selected year
function downloadFile(type, format) {
    var selectedYear = document.getElementById('year-select').value;
    if (selectedYear === '') {
        showSnackbar('Select an year before you want to save a file.', 'error');
        return;
    }

    var fileName = selectedYear + '-' + type + '.' + format;

    var url = `http://localhost${APP_PORT}/RomanianDrugExplorer/downloads/` + fileName;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                showSnackbar('Failed to download file.', 'error');
                throw new Error('Failed to download file.');
            }
            return response.blob();
        })
        .then(blob => {
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            showSnackbar('Downloaded successfully!', 'info');
        })
        .catch(error => {
            showSnackbar('Download error.', 'error');
        });
}

// Open CSV file in a new tab related to the selected year
function openFileInNewTab(type, format) {
    var selectedYear = document.getElementById('year-select').value;
    if (selectedYear === '') {
        showSnackbar('Select an year before you want to save a file!', 'error');
        return;
    }

    var fileName = selectedYear + '-' + type + '.' + format;
    var url = `http://localhost${APP_PORT}/RomanianDrugExplorer/downloads/` + fileName;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                showSnackbar('Failed to download file.', 'error');
                throw new Error('Failed to open file.');
            }
            return response.text(); // Assuming CSV file is plain text
        })
        .then(data => {
            displayCsvInNewTab(data);
            showSnackbar('Fle open in a new tab.', 'info');
        })
        .catch(error => {
            showSnackbar('Open file error.', 'error');
        });
}

// Function to display CSV content in a new tab
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

// Function to generate table content from CSV data
function generateTableContent(csvData) {
    var rows = csvData.split("\n");
    var tableContent = '';

    rows.forEach((row, index) => {
        var columns = row.split(",");
        var rowContent = columns.map(col => `<td>${col}</td>`).join("");
        tableContent += `<tr>${rowContent}</tr>`;
    });

    return tableContent;
}