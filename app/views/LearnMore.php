<!DOCTYPE html>
<html lang="en">
<head>
    <title> Learn More</title>
    <link rel = "stylesheet" href="/RomanianDrugExplorer/public/styles/style_LearnMore.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <meta charset="UTF-8">
</head>
<body>
<header>
    <h1 class="title">Romanian Drug Explorer</h1>
    <nav class="items">
        <div class="logo">
            <a href="#">RoDX</a>
        </div>
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="menu-icon">&#9776;</label>
        <div class="list">
            <a href="/RomanianDrugExplorer/app/views/LearnMore.php">Home</a>
            <a href="index.html#about">About</a>
            <a href="/RomanianDrugExplorer/app/views/Contact.php">Contact</a>
            <a href="/RomanianDrugExplorer/app/views/HelpAndAdvice.php">Help & Advice</a>
            <div class="for_login">
                <a href="/RomanianDrugExplorer/app/views/login.php">Login</a>
            </div>
        </div>
    </nav>
</header>

<div class="main">
    <h1>Statistics of the drug abuse :</h1>
    <div class="input-field col s12">
        <select id="year-select" onchange="updateYearUrl()">
            <option value="" disabled selected>Choose a year...</option>
            <option value="2023">2023</option>
            <option value="2022">2022</option>
            <option value="2021">2021</option>
            <option value="2020">2020</option>
        </select>
    </div>
    <div>
    <h1 id="selected-year">
        <?php if(isset($_GET['year'])) {
            echo $_GET['year'];
        } else {
            echo 'Choose a year...';
        } ?>
    </h1>
   </div>
  
    <div class="container_1">
    <div class="card">
       <div class="card_2">
       <h1>Drug Abuse Statistics:</h1>
       <p>Here you can find the statistics about drug confiscation in Romania.</p>
    
</div>
    <table id="stats-table">
        <thead>
            <tr>
                <th>Drog</th>
                <th>Gramaj</th>
                <th>Comprimate</th>
                <th>Mililitri</th>
                <th>Capturi</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aici vor fi adăugate rândurile pentru statistici -->
        </tbody>
    </table>
    </div>
   </div>

    <div class="container_2">
        <div class="card">
            <ul>
                <h1>Resources:</h1>
                <li><i class="large material-icons">library_books</i>
                    <a href="2021-capturidroguri.xlsx">Situația confiscărilor de droguri</a>
                    <button class="btn-download" onclick="downloadFile('-capturidroguri.xlsx')">Download Report CSV</button>
                    <p id="download-error" style="color: red; display: none;">Failed to download file.</p>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Urgente_medicale.xlsx">Urgențele medicale datorate consumului de droguri</a>
                    <button class="btn-download" onclick="downloadFile('-urgentemedicale.xlsx')">Download Report CSV</button>
                    <p id="download-error" style="color: red; display: none;">Failed to download file.</p>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Infractiuni_regim_droguri.xlsx">Infracționalitatea la regimul drogurilor</a>
                    <button class="btn-download" onclick="downloadFile('-infractionalitate.xlsx')">Download Report CSV</button>
                    <p id="download-error" style="color: red; display: none;">Failed to download file.</p>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Proiecte_campanii_prevenire.xlsx">Proiectele și campaniile naționale de prevenire</a>
                    <button class="btn-download" onclick="downloadFile('-proiectecampanii.xlsx')">Download Report CSV</button>
                    <p id="download-error" style="color: red; display: none;">Failed to download file.</p>
                </li>
            </ul>
        </div>
    </div>

</div>

<script>
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
    
    function renderStats(stats, year) {
    var tableBody = document.querySelector('#stats-table tbody');
    tableBody.innerHTML = ''; // Curăță conținutul actual al tabelului

    // Actualizează textul anului selectat pe pagină
    var selectedYearElement = document.getElementById('selected-year');
    if (year) {
        selectedYearElement.textContent = year;
    } else {
        selectedYearElement.textContent = 'Choose a year...';
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

</script>

</body>
</html>
