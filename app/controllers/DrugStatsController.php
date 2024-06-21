<?php

require_once dirname(__FILE__) . '/../models/DrugStats.php';

class DrugStatsController {

    private $drugStatsModel;

    public function __construct() {
        $this->drugStatsModel = new DrugStats();
    }
    ///////////////////////////////////////////////DRUG CONSUMPTION////////////////////////////////////////////

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

///////////////////////////////////////////INFRACTIONALITY////////////////////////////////////////////
public function getStatsByYearInfractionality($year) {
    $stats = $this->drugStatsModel->getStatsByYearInfractionality($year);
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

public function getDrugStatsInfractionality() {
    $stats = $this->drugStatsModel->getStatsInfractionality();
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

public function getStatsByYearInfractionalityGenderAge($year) {
    $stats = $this->drugStatsModel->getStatsByYearInfractionalityGenderAge($year);
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
public function getStatsByYearInfractionalityPenalities($year) {
    $stats = $this->drugStatsModel->getStatsByYearInfractionalityPenalities($year);
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

///////////////////////////////////////////MEDICAL EMERGENCIES////////////////////////////////////////////
public function getStatsByYearMedic($year) {
    $stats = $this->drugStatsModel->getStatsByYearMedic($year);
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

public function getDrugStatsMedic() {
    $stats = $this->drugStatsModel->getStatsMedic();
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
//////////////////////////////////////////PROJECTS////////////////////////////////////////////
public function getStatsByYearProject($year) {
    $stats = $this->drugStatsModel->getStatsByYearProject($year);
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

public function getDrugStatsProject() {
    $stats = $this->drugStatsModel->getStatsProject();
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