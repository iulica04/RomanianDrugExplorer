<?php session_start(); ?>
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
        <h1>Statistics of the drug abuse per years:</h1>
        <div id="snackbar"></div>
        <div class="container_1">
            <div class="card">
                <div class="card_1">
                    <h1>Drug Confiscation Statistics:</h1>
                    <p>Here you can find the statistics about drug confiscation in Romania.</p>
                    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                    <button class="button button2" onclick="saveChart('confiscations-chart', 'chart', 'png')">
                        <a>Download PNG</a>
                    </button>
                    <?php } else { ?>
                        <button class="button button2" onclick="saveChartNotLoggedIn()">
                            <a>Download PNG</a>
                        </button>
                    <?php } ?>
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
                    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                    <button class="button button2"
                        onclick="saveChart('infractionality-chart' , 'chart', 'png')"><a>Download PNG</a></button>
                    <?php } else { ?>
                        <button class="button button2" onclick="saveChartNotLoggedIn()"><a>Download PNG</a></button>
                    <?php } ?>
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
                    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                        <button class="button button2" onclick="saveChart('emergencies-chart' , 'chart', 'png')"><a>Download PNG</a></button>
                    <?php } else { ?>
                        <button class="button button2" onclick="saveChartNotLoggedIn()"><a>Download PNG</a></button>
                    <?php } ?>

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
                    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                        <button class="button button2" onclick="saveChart('projects-chart','chart','png')"><a>Download PNG</a></button>
                    <?php } else { ?>
                        <button class="button button2" onclick="saveChartNotLoggedIn()"><a>Download PNG</a></button>
                    <?php } ?>
                    
                </div>

                <div class="card_2">
                <div class="chart-container">
                      <canvas id="projects-chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class = "container-more-data">
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
            <p>Interested in a deeper dive? 
            <a class="click-here" href="/RomanianDrugExplorer/app/views/LearnMore.php">Click here</a> 
            to explore personalized statistics and uncover insights that are tailored to your interests.</p>
        <?php } else { ?>
            <p>Interested in a deeper dive? 
            <a class="click-here" onclick=" showSnackbar('Please log in to uncover more personalized insights','error')">Click here</a> 
            to explore personalized statistics and uncover insights that are tailored to your interests.</p>
        <?php } ?>
        </div>


    <script src="/RomanianDrugExplorer/public/utils/Statistics.js"></script>
    <script src="/RomanianDrugExplorer/public/utils/SnackBar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>