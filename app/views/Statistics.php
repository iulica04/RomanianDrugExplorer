<!DOCTYPE html>
<html lang="en">
<head>
    <title>Learn More</title>
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_LearnMore.css">
    <link rel="stylesheet" href="/RomanianDrugExplorer/public/styles/style_ShackBar.css">
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
        <h1>Statistics of the drug abuse per years:</h1>
        <div id="snackbar"></div>
        <div class="container_1">
            <div class="card">
                <div class="card_1">
                    <h1>Drug Confiscation Statistics:</h1>
                    <p>Here you can find the statistics about drug confiscation in Romania.</p>
                    <button class="button button2" onclick="saveChart('confiscations-chart', 'chart', 'png')">
                        <a href="#">Download PNG</a>
                    </button>
                </div>

                <div class="card_2">
                <div class="chart-container">
                      <canvas id="confiscation-chart"></canvas>
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
                </div>

                <div class="card_2">
                    <div class="chart-container">
                        <canvas id="infractionality-chart"></canvas>
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

                </div>

                <div class="card_2">
                    <div class="chart-container">
                        <canvas id="emergencies-chart"></canvas>
                    </div>
                </div>

            </div>
        </div>

        <div class="container_1">
            <div class="card">
                <div class="card_1">
                    <h1>Anti-Drug Projects Statistics:</h1>
                    <p>Here you can find the statistics about projects and campaigns against drugs in Romania.</p>
                    <button class="button button2" onclick="saveChart('projects-chart','chart','png')"><a>Download
                            PNG</a></button>
                </div>

                <div class="card_2">
                <div class="chart-container">
                      <canvas id="projects-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    
    <script src="/RomanianDrugExplorer/public/utils/Statistics.js"></script>
    <script src="/RomanianDrugExplorer/public/utils/SnackBar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>