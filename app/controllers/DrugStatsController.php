<?php

require_once dirname(__FILE__) . '/../models/DrugStats.php';

class DrugStatsController {

    private $drugStatsModel;

    public function __construct() {
        $this->drugStatsModel = new DrugStats();
    }

    public function getStatsByYear($year) {
        $stats = $this->drugStatsModel->getStatsByYear($year);
        header('Content-Type: application/json'); // Ensure the response is JSON

        if ($stats) {
            $response = [
                'stats' => $stats,
                'year' => $year
            ];
            echo json_encode($response);
        } else {
            echo json_encode(['stats' => [], 'year' => $year]);
        }
    }

    public function getDrugStats() {
        $stats = $this->drugStatsModel->getStats();
        header('Content-Type: application/json'); // Ensure the response is JSON

        if ($stats) {
            $response = [
                'stats' => $stats
            ];
            echo json_encode($response);
        } else {
            echo json_encode(['stats' => []]);
        }
    }
}



?>