<?php
require_once dirname(__FILE__) . '/../config/Db.php';
require_once 'DrugStats.php'; // Asigură-te că acesta este numele corect al fișierului clasei DrugStats
// Creează o instanță a clasei DrugStats
$drugStats = new DrugStats();


// Testează metoda getStatsByYear
$an = 2022; // Anul pe care vrei să-l testezi
$statsByYear = $drugStats->getStatsByYear($an);
var_dump($statsByYear);