function showSnackbar(message, messageType) {
    var snackbar = document.getElementById("snackbar");
    snackbar.innerHTML = message;
    snackbar.className = "show";

    // Add the message type class to the Snackbar
    if (messageType === 'error') {
        snackbar.className += " error";
    } else if (messageType === 'info') {
        snackbar.className += " info";
    }

    setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 3000);
}

// Afiseaza datele in tabelul specific
function renderStats(stats, year, type) {
    var tableBody = document.querySelector(`#${type}-table tbody`);
    
    if (!tableBody) {
        console.error(`Table body for type "${type}" not found.`);
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
        var cells = '';

        switch(type) {
           /* case 'confiscations':
                cells = `
                    <td>${stat.drog}</td>
                    <td>${stat.grame}</td>
                    <td>${stat.comprimate}</td>
                    <td>${stat.mililitri}</td>
                    <td>${stat.capturi}</td>
                `;
                break;
            case 'emergencies':
                cells = `
                    <td>${stat.drog}</td>
                    <td>${stat.gen}</td>
                    <td>${stat.varsta}</td>
                    <td>${stat.administrare}</td>
                    <td>${stat.diagnostic}</td>
                    <td>${stat.numar}</td>
                `;
                break;*/
            case 'projects':
                cells = `
                    <td>${stat.category}</td>
                    <td>${stat.subcategory}</td>
                    <td>${stat.beneficiaries}</td>
                `;
                break;
        }

        row.innerHTML = cells;
        tableBody.appendChild(row);
    });
}

function saveTableAsPNG(tableId, filename) {
    var tableElement = document.getElementById(tableId);

    // Verifică dacă tabelul există
    if (!tableElement) {
        console.error('Table element not found:', tableId);
        snackbar('Tabelul nu a fost găsit.', 'error');
        return;
    }

    // Convertirea tabelului într-un canvas utilizând html2canvas
    html2canvas(tableElement).then(function(canvas) {
        // Obține obiectul blob pentru canvas
        canvas.toBlob(function(blob) {
            // Crează un element <a> pentru a descărca fișierul PNG
            var link = document.createElement('a');
            link.download = filename + '.png';
            link.href = URL.createObjectURL(blob);
            link.click();
        });
    });
}

function saveTableAsSVG(tableId) {
    var table = document.getElementById(tableId);
    if (!table) {
        console.error('Table element not found:', tableId);
        showSnackbar('Tabelul nu a fost găsit.', 'error');
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
    showSnackbar('Tabelul a fost salvat ca fișier SVG.', 'info');
}



// Download CSV file related to the selected year
function downloadFile(type, format) {
    var selectedYear = document.getElementById('year-select').value;
    if (selectedYear === '') {
        console.error('No year selected.');
        showSnackbar('Selectează un an înainte de a descărca fișierul.', 'error');
        return;
    }

    var fileName = selectedYear + '-' + type + '.' + format;
    console.log('Downloading file:', fileName);

    var url = 'http://localhost:8080/RomanianDrugExplorer/downloads/' + fileName;

    fetch(url)
        .then(response => {
            if (!response.ok) {
                showSnackbar('Descărcarea fișierului a eșuat.', 'error');
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
            showSnackbar('Descărcarea fișierului a reușit.', 'info');
        })
        .catch(error => {
            console.error('Download error:', error);
            document.getElementById(`download-error-${type}`).style.display = 'block';
        });
}



