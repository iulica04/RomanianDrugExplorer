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
            <p>Here you can find the statistics of the drug abuse in Romania. The data is updated every year.</p>
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
                    <a href="Admiterea_la_tratament.xlsx">Admiterea la tratament ca urmare a consumului de stupefiante</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Urgente_medicale.xlsx">Urgențele medicale datorate consumului de droguri</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Bolile_infectioase.xlsx">Bolile infecțioase asociate consumului de droguri</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Confiscari_droguri.xlsx">Situația confiscărilor de droguri</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Infractiuni_regim_droguri.xlsx">Infracționalitatea la regimul drogurilor</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Proiecte_campanii_prevenire.xlsx">Proiectele și campaniile naționale de prevenire</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                </li>
                <li><i class="large material-icons">library_books</i>
                    <a href="Precursori.xlsx">Precursorii (substanțe clasificate și operațiunile autorizate)</a>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Download</button>
                </li>
            </ul>
        </div>
    </div>

</div>

<script>
    function updateYearUrl() {
        var selectedYear = document.getElementById('year-select').value;
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
</script>

</body>
</html>
