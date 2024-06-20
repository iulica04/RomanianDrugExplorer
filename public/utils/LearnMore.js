//trimite cerearea GET catre ruta corespunzatoare in router si primeste datele necesare
function updateYearUrl() {
    var selectedYear = document.getElementById('year-select').value ;
    if (selectedYear === '') {
        return; // Dacă nu este selectat niciun an, nu face nimic
    }
    console.log('Selected year:', selectedYear);
 // Face o cerere GET către ruta corespunzătoare în router
     var url = 'http://localhost:8080/RomanianDrugExplorer/DrugStats/' + selectedYear;
    console.log('Requesting data from:', url);
    fetch(url)
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.text(); // Utilizează response.text() pentru a afișa răspunsul complet
})
.then(data => {
    console.log('Response text:', data); // Afișează răspunsul complet în consolă pentru depanare
    // Continuă cu parsarea JSON
    try {
        const jsonData = JSON.parse(data);
        if (jsonData && jsonData.stats) {
            renderStats(jsonData.stats, jsonData.year);
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
}

//Afiseaza datele in tabel
function renderStats(stats, year) {
var tableBody = document.querySelector('#stats-table tbody');
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
    
    // Construiește celulele pentru fiecare câmp din statistică
    var cells = `
        <td>${stat.drog}</td>
        <td>${stat.grame}</td>
        <td>${stat.comprimate}</td>
        <td>${stat.mililitri}</td>
        <td>${stat.capturi}</td>
    `;
    
    row.innerHTML = cells;
    tableBody.appendChild(row);
});
}

//Download CSV file related to the selected year
function downloadFile(fileName) {
var selectedYear = document.getElementById('year-select').value;
fileName = selectedYear + fileName; 
console.log('Downloading file:', fileName);

if(selectedYear === '') {
    console.error('No year selected.');
    return;
}

var url = 'http://localhost:8080/RomanianDrugExplorer/downloads/' + fileName; // Asigură-te că adresa URL este corectă și conduce la locația reală a fișierului

fetch(url)
    .then(response => {
        if (!response.ok) {
            throw new Error('Failed to download file.');
        }
        return response.blob();
    })
    .then(blob => {
        // Crează un obiect URL pentru blob-ul descărcat
        var url = window.URL.createObjectURL(blob);
        
        // Creează un link pentru descărcare
        var a = document.createElement('a');
        a.href = url;
        a.download = fileName;
        document.body.appendChild(a);
        
        // Simulează clicul pe link pentru a iniția descărcarea
        a.click();
        
        // Șterge link-ul după ce descărcarea a fost inițiată
        document.body.removeChild(a);
    })
    .catch(error => {
        console.error('Download error:', error);
        // Afișează mesajul de eroare
        document.getElementById('download-error').style.display = 'block';
    });
}
