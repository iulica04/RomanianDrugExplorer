<!DOCTYPE html>
<html lang="en">
<head>
    <title>Learn More</title>
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_LearnMore.css">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_ShackBar.css">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_Navbar.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta charset="UTF-8">
</head>

<body>
    <header>
        <h1 class="title">Romanian Drug Explorer</h1>
        <?php include 'elements/navbar.php'; ?>
    </header>

    <div class="main">
        <h1>Statistics of the drug abuse:</h1>
        <div class="input-field col s12">
            <select id="year-select" onchange="updateYearUrl()">
                <option value="" disabled selected>Choose a year...</option>
                <option value="2023">2023</option>
                <option value="2022">2022</option>
                <option value="2021">2021</option>
            </select>
        </div>

        <div>
            <h2 id="selected-year">
                <?php if (isset($_GET['year'])) {
                    echo $_GET['year'];
                }
                ?>
            </h2>
        </div>

        <div class="container_1">
            <div class="card">
                <div class="card_1">
                    <h1>Drug Related Confiscations Statistics:</h1>
                    <p>Here you can find the statistics about drug confiscation in Romania.</p>
                    <button class="button button2" onclick="savePieChart('confiscations-chartpie', 'chartPie', 'png')">
                        <a>Download PNG</a>
                    </button>
                    <button class="button button2" onclick="savePieChart('confiscations-chartpie','chartPie', 'svg')">
                        <a>Download SVG</a>
                    </button>
                </div>

                <div class="card_2">
                <div class="chartpie-container">
                      <canvas id="confiscations-chartpie"></canvas>
                </div>
                <div class="radio-buttons">
                        <label>
                            <input name="chartType" type="radio" checked onchange="updateChartPie('drug-captures','confiscations')" />
                            <span>Drug & Captures</span>
                        </label>
                        <label>
                            <input name="chartType" type="radio" onchange="updateChartPie('drug-grams','confiscations')" />
                            <span>Drug & Grams</span>
                        </label>
                        <label>
                            <input name="chartType" type="radio" onchange="updateChartPie('drug-tablets','confiscations')" />
                            <span>Drug & Tablets</span>
                        </label>
                    </div>
                </div>

            </div>
        </div>

        <div class="container_1">
            <div class="card">
                <div class="card_1">
                    <h1>Drug Related Infractionality Statistics:</h1>
                    <p>Here you can find the statistics about drug related infractionality in Romania.</p>
                    <button class="button button2"
                        onclick="saveChart('infractionality-chart' , 'chart', 'png')"><a>Download PNG</a></button>
                    <button class="button button2"
                        onclick="saveChart('infractionality-chart', 'chart', 'svg')"><a>Download SVG</a></button>

                </div>

                <div class="card_2">
                    <div class="chart-container">
                        <canvas id="infractionality-chart"></canvas>
                    </div>
                    <div class="radio-buttons">
                        <label>
                            <input name="chartType" type="radio" checked onchange="updateChart('gender-age','infractionality')" />
                            <span>Gender & Age</span>
                        </label>
                        <label>
                            <input name="chartType" type="radio" onchange="updateChart('penalties-situation','infractionality')" />
                            <span>Penalties & Situation</span>
                        </label>
                    </div>
                </div>

            </div>
        </div>

        <div class="container_1">
            <div class="card">
                <div class="card_1">
                    <h1>Drug Emergencies Statistics:</h1>
                    <p>Here you can find the statistics about drug emergencies in Romania.</p>
                     <button class="button button2" onclick="saveChart('emergencies-chart' , 'chart', 'png')"><a>Download PNG</a></button>
                     <button class="button button2" onclick="saveChart('emergencies-chart', 'chart', 'svg')"><a>Download SVG</a></button>

                </div>

                <div class="card_2">
                    <div class="chart-container">
                        <canvas id="emergencies-chart"></canvas>
                    </div>
                    <div class="radio-buttons">
                        <label>
                            <input name="chartType" type="radio" checked onchange="updateChartEmergencies('gender-drug','emergencies')" />
                            <span>Gender & Drug</span>
                        </label>
                        <label>
                            <input name="chartType" type="radio" onchange="updateChartEmergencies('age-drug','emergencies')" />
                            <span>Age & Drug</span>
                        </label>
                        <label>
                            <input name="chartType" type="radio" onchange="updateChartEmergencies('emergencie-drug-canabis','emergencies')" />
                            <span>Emergencie & Drug Canabis</span>
                        </label>
                        <label>
                            <input name="chartType" type="radio" onchange="updateChartEmergencies('emergencie-drug-stimulanti','emergencies')" />
                            <span>Emergencie & Drug Stimulati</span>
                        </label>
                        <label>
                            <input name="chartType" type="radio" onchange="updateChartEmergencies('emergencie-drug-opiacee','emergencies')" />
                            <span>Emergencie & Drug Opiacee</span>
                        </label>
                        <label>
                            <input name="chartType" type="radio" onchange="updateChartEmergencies('emergencie-drug-NSP','emergencies')" />
                            <span>Emergencie & Drug NSP</span>
                        </label>
                    </div>
                </div>

            </div>
        </div>

        <div class="container_1">
            <div class="card">
                <div class="card_1">
                    <h1>Anti-Drug Projects Statistics:</h1>
                    <p>Here you can find the statistics about projects and campaigns against drugs in Romania.</p>
                    <button class="button button2" onclick="saveTableAsSVG('projects-table')"><a>Download
                            SVG</a></button>
                </div>

                <div class="card_2">
                    <table id="projects-table">
                    <canvas id="my-canvas" style="display: none;"></canvas>
                        <thead>
                            <tr>
                                <th>Tip Proiect</th>
                                <th>Nume Proiect</th>
                                <th>Numar de beneficiari</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aici vor fi adăugate rândurile pentru statistici -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="snackbar"></div>

     <div class="container_2">
    <div class="card">
        <ul>
            <h1>Resources:</h1>
            <li>
                <i class="large material-icons">library_books</i>
                <a>Situația confiscărilor de droguri</a>
                <button class=" button1" onclick="downloadFile('capturidroguri', 'csv')"><a>Download Report CSV</a></button>
                <button class=" button1" onclick="openFileInNewTab('capturidroguri', 'csv')"><a>Open in New Tab</a></button>
            </li>
            <li>
                <i class="large material-icons">library_books</i>
                <a>Urgențele medicale datorate consumului de droguri</a>
                <button class="button1" onclick="downloadFile('urgentemedicale', 'csv')"><a>Download Report CSV</a></button>
                <button class="button1" onclick="openFileInNewTab('urgentemedicale', 'csv')"><a>Open in New Tab</a></button>
            </li>
            <li>
                <i class="large material-icons">library_books</i>
                <a>Infracționalitatea la regimul drogurilor</a>
                <button class="button1" onclick="downloadFile('infractionalitate', 'csv')"><a>Download Report CSV</a></button>
                <button class="button1" onclick="openFileInNewTab('infractionalitate', 'csv')"><a>Open in New Tab</a></button>
            </li>
            <li>
                <i class="large material-icons">library_books</i>
                <a>Proiectele și campaniile naționale de prevenire</a>
                <button class="button1" onclick="downloadFile('proiectesicampanii', 'csv')"><a>Download Report CSV</a></button>
                <button class="button1" onclick="openFileInNewTab('proiectesicampanii', 'csv')"><a>Open in New Tab</a></button>
            </li>
        </ul>
    </div>
</div>
</div>

     <script type="module" src="/RomanianDrugExplorer/public/utils/snackBar.js" defer></script>
     <script type="module" src="/RomanianDrugExplorer/public/utils/Chart.js" defer></script>
     <script type="module" src="/RomanianDrugExplorer/public/utils/LearnMore.js" defer></script>
     <script type="module" src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
    
</body>
</html>