<?php
require_once 'DrugStatsController.php';

// Testează metoda getStatsByYear
$controller = new DrugStatsController();
$controller->getStatsByYear(2021); // Înlocuiește 2023 cu anul pentru care vrei să obții statistici

?>