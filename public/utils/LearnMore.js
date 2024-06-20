// Definește funcția showSnackbar înainte de utilizare
function showSnackbar(message, messageType) {
    var snackbar = document.getElementById("snackbar");
    snackbar.innerHTML = message;
    snackbar.className = "show";

    // Adaugă clasa de tip de mesaj la Snackbar
    if (messageType === 'error') {
        snackbar.className += " error";
    } else if (messageType === 'info') {
        snackbar.className += " info";
    }

    setTimeout(function(){ snackbar.className = snackbar.className.replace("show", ""); }, 3000);
}

function updateYearUrl() {
    var selectedYear = document.getElementById('year-select').value;
    if (selectedYear === '') {
        return; // Dacă nu este selectat niciun an, nu face nimic
    }
    console.log('Selected year:', selectedYear);

    // Trimite cereri GET pentru fiecare tip de statistică
    ['confiscations', 'infractionality', 'emergencies', 'projects'].forEach(type => {
        var url = 'http://localhost:8080/RomanianDrugExplorer/DrugStats/' + type + '/' + selectedYear;
        console.log('Requesting data from:', url);
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(data => {
                console.log('Response text:', data);
                try {
                    const jsonData = JSON.parse(data);
                    if (jsonData && jsonData.stats) {
                        renderStats(jsonData.stats, jsonData.year, type);
                    } else {
                        console.error('Empty response or invalid data received:', jsonData);
                    }
                } catch (error) {
                    console.error('Error parsing JSON:', error);
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });
}

// Afiseaza datele in tabelul specific
function renderStats(stats, year, type) {
    var tableBody = document.querySelector(`#${type}-table tbody`);
    tableBody.innerHTML = ''; // Curăță conținutul actual al tabelului

    // Actualizează textul anului selectat pe pagină
    var selectedYearElement = document.getElementById('selected-year');
    if (year) {
        selectedYearElement.textContent = year;
    } else {
        selectedYearElement.textContent = ' Statistici pe ani ';
    }

    // Iterează prin fiecare statistică și adaugă un rând nou în tabel pentru fiecare
    stats.forEach(stat => {
        var row = document.createElement('tr');
        var cells = '';

        switch(type) {
            case 'confiscations':
                cells = `
                    <td>${stat.drog}</td>
                    <td>${stat.grame}</td>
                    <td>${stat.comprimate}</td>
                    <td>${stat.mililitri}</td>
                    <td>${stat.capturi}</td>
                `;
                break;
            case 'infractionality':
                cells = `
                    <td>${stat.gen}</td>
                    <td>${stat.varsta}</td>
                    <td>${stat.stare}</td>
                    <td>${stat.situatia_pedepsei}</td>
                    <td>${stat.numar}</td>
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
                break;
            case 'projects':
                cells = `
                    <td>${stat.tip_proiect}</td>
                    <td>${stat.nume_proiect}</td>
                    <td>${stat.numar_beneficiari}</td>
                    <td>${stat.nivel}</td>
                `;
                break;
        }

        row.innerHTML = cells;
        tableBody.appendChild(row);
    });
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
