<!DOCTYPE html>
<html lang="en">

<head>
    <title>Learn More</title>
    <script type="module" src="/RomanianDrugExplorer/public/utils/snackBar.js"></script>
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_LearnMore.css">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_ShackBar.css">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_Navbar.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script type="module" src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="module" src="/RomanianDrugExplorer/public/utils/Chart.js"></script>
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
                    <button class="button button2" data-chart-id="confiscations-chartpie" data-chart-type="chartPie"
                        data-file-type="png">
                        <a>Download PNG</a></button>
                    <button class="button button2" data-chart-id="confiscations-chartpie" data-chart-type="chartPie"
                        data-file-type="svg">
                        <a>Download SVG</a></button>
                </div>

                <div class="card_2">
                    <div class="chartpie-container">
                        <canvas id="confiscations-chartpie"></canvas>
                    </div>
                    <div class="radio-buttons">
                        <label>
                            <input name="chartType" type="radio" data-chart-id="drug-captures"
                                data-chart-type="confiscations" checked />
                            <span>Drug & Captures</span>
                        </label>
                        <label>
                            <input name="chartType" type="radio" data-chart-id="drug-grams"
                                data-chart-type="confiscations" />
                            <span>Drug & Grams</span>
                        </label>
                        <label>
                            <input name="chartType" type="radio" data-chart-id="drug-tablets"
                                data-chart-type="confiscations" />
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
            <button class="button button2" data-chart-id="infractionality-chart" data-chart-type="chart" data-file-type="png">
                <a>Download PNG</a>
            </button>
            <button class="button button2" data-chart-id="infractionality-chart" data-chart-type="chart" data-file-type="svg">
                <a>Download SVG</a>
            </button>
        </div>
        <div class="card_2">
            <div class="chart-container">
                <canvas id="infractionality-chart"></canvas>
            </div>
            <div class="radio-buttons">
                <label>
                    <input name="chartType" type="radio" data-chart-id="gender-age" data-chart-type="infractionality" checked />
                    <span>Gender & Age</span>
                </label>
                <label>
                    <input name="chartType" type="radio" data-chart-id="penalties-situation" data-chart-type="infractionality" />
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
            <button class="button button2" data-chart-id="emergencies-chart" data-chart-type="chart" data-file-type="png">
                <a>Download PNG</a>
            </button>
            <button class="button button2" data-chart-id="emergencies-chart" data-chart-type="chart" data-file-type="svg">
                <a>Download SVG</a>
            </button>
        </div>
        <div class="card_2">
            <div class="chart-container">
                <canvas id="emergencies-chart"></canvas>
            </div>
            <div class="radio-buttons">
                <label>
                    <input name="chartType" type="radio" data-chart-id="gender-drug" data-chart-type="emergencies" checked />
                    <span>Gender & Drug</span>
                </label>
                <label>
                    <input name="chartType" type="radio" data-chart-id="age-drug" data-chart-type="emergencies" />
                    <span>Age & Drug</span>
                </label>
                <label>
                    <input name="chartType" type="radio" data-chart-id="emergencie-drug-canabis" data-chart-type="emergencies" checked />
                    <span>Emergencie & Drug Canabis</span>
                </label>
                <label>
                    <input name="chartType" type="radio" data-chart-id="emergencie-drug-stimulanti" data-chart-type="emergencies" />
                    <span>Emergencie & Drug Stimulanti</span>
                </label>
                <label>
                    <input name="chartType" type="radio" data-chart-id="emergencie-drug-opiacee" data-chart-type="emergencies" checked />
                    <span>Emergencie & Drug Opiacee</span>
                </label>
                <label>
                    <input name="chartType" type="radio" data-chart-id="emergencie-drug-NSP" data-chart-type="emergencies" />
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

                    <button class="button button2" data-chart-id="projects-table" data-chart-type="table"
                        data-file-type="svg">
                        <a>Download SVG</a></button>

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
                        <button class="button1" data-action="downloadFile" data-file="capturidroguri"
                            data-type="csv"><a>Download Report CSV</a></button>
                        <button class="button1" data-action="openFileInNewTab" data-file="capturidroguri"
                            data-type="csv"><a>Open in New Tab</a></button>
                    </li>
                    <li>
                        <i class="large material-icons">library_books</i>
                        <a>Urgențele medicale datorate consumului de droguri</a>
                        <button class="button1" data-action="downloadFile" data-file="urgentemedicale"
                        data-type="csv"><a>Download Report
                                CSV</a></button>
                        <button class="button1"  data-action="openFileInNewTab" data-file="urgentemedicale"
                        data-type="csv"><a>Open in New Tab</a></button>
                    </li>
                    <li>
                        <i class="large material-icons">library_books</i>
                        <a>Infracționalitatea la regimul drogurilor</a>
                        <button class="button1" data-action="downloadFile" data-file="infractionalitate"
                        data-type="csv"><a>Download Report CSV</a></button>
                        <button class="button1" data-action="openFileInNewTab" data-file="infractionalitate"
                        data-type="csv"><a>Open in New Tab</a></button>
                    </li>
                    <li>
                        <i class="large material-icons">library_books</i>
                        <a>Proiectele și campaniile naționale de prevenire</a>
                        <button class="button1"  data-action="downloadFile" data-file="proiectesicampanii"
                        data-type="csv"><a>Download Report CSV</a></button>
                        <button class="button1"  data-action="openFileInNewTab" data-file="proiectesicampanii"
                        data-type="csv"><a>Open in New Tab</a></button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>