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
            echo 'Statistici pe ani...';
        } ?>
    </h1>
   </div>
  
   <div class="container_1">
        <div class="card">
            <div class="card_1">
                <h1>Drug Confiscation Statistics:</h1>
                <p>Here you can find the statistics about drug confiscation in Romania.</p>
                <button class="button button3">Download PNG</button>
                <button class="button button2">Download SVG</button>
            </div>
            <div class="button-column">
                <div class="card_2">
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
        </div>
    </div>

    <div class="container_1">
    <div class="card">
    <div class="image-column">
       <div class="card_1">
       <h1>Drug Related Infractionality Statistics:</h1>
       <p>Here you can find the statistics about drug related infractionality in Romania.</p>
       <button class="button button3">Download PNG</button>
       <button class="button button2">Download SVG</button>
       </div>
   </div>

     <div class="button-column">
     <div class ="card_1">

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
   </div>
    </div>
    <div class="container_1">
    <div class="card">
    <div class="image-column">
       <div class="card_1">
       <h1>Drug Emergencies Statistics:</h1>
       <p>Here you can find the statistics about drug emergencies in Romania.</p>
       <button class="button button3">Download PNG</button>
       <button class="button button2">Download SVG</button>
       </div>
   </div>

     <div class="button-column">
     <div class ="card_1">

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
   </div>
    </div>

    <div class="container_1">
    <div class="card">
    <div class="image-column">
       <div class="card_1">
       <h1>Anti-Drug Projects Statistics:</h1>
       <p>Here you can find the statistics about projects and campaigns against drugs in Romania.</p>
       <button class="button button3">Download PNG</button>
       <button class="button button2">Download SVG</button>
       </div>
   </div>

     <div class="button-column">
     <div class ="card_1">

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
   </div>
    </div>


    <div class="container_2">
        <div class="card">
            <ul>
                <h1>Resources:</h1>
                <li><i class="large material-icons">library_books</i>
                    <a href="2021-capturidroguri.xlsx">Situația confiscărilor de droguri</a>
                    <button class="button button5" onclick="downloadFile('-capturidroguri.xlsx')">Download Report CSV</button>
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

<script src="/RomanianDrugExplorer/public/utils/LearnMore.js"></script>

</body>
</html>
