<?php

require_once dirname(__FILE__) . '/../models/DrugStats.php';
require_once dirname(__FILE__) . '/../../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

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
public function getStatsByYearMedicEmergencyDrug($year) {
    $stats = $this->drugStatsModel->getStatsByYearMedicEmergencyDrug($year);
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
public function getStatsByYearMedicGenderDrug($year) {
    $stats = $this->drugStatsModel->getStatsByYearMedicGenderDrug($year);
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
public function getStatsByYearMedicAgeDrug($year) {
    $stats = $this->drugStatsModel->getStatsByYearMedicAgeDrug($year);
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














//-------------------------------------------
public function addDataUrgenteMedicale($year){

    if(isset($_FILES['fileToUpload'])) {
        $file = $_FILES['fileToUpload']['tmp_name'];

        // Încărcăm fișierul .xlsx
        try {
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();


            // Parcurgem rândurile
            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // Acest lucru permite parcurgerea tuturor celulelor, chiar și celor goale
                $rowIndex = $row->getRowIndex();
                $array_data = [];
                foreach ($cellIterator as $cell) {
                    $array_data[] = $cell->getValue();
                }

                // Definim variabilele pentru fiecare categorie și subcategorie
                if ($rowIndex >= 5 && $rowIndex <= 6) {
                    $category = 'Sex';
                    $subcategory = $array_data[0];
                } elseif ($rowIndex >= 10 && $rowIndex <= 12) {
                    $category = 'Age';
                    $subcategory = $array_data[0];
                } elseif ($rowIndex >= 16 && $rowIndex <= 18) {
                    $category = 'Administration';
                    $subcategory = $array_data[0];
                } elseif ($rowIndex >= 22 && $rowIndex <= 23) {
                    $category = 'ConsumptionModel';
                    $subcategory = $array_data[0];
                } elseif ($rowIndex >= 27 && $rowIndex <= 34) {
                    $category = 'Diagnosis';
                    $subcategory = $array_data[0];
                } else {
                    continue;
                }

                // Inserăm datele în tabelul SQL
                for ($i = 1; $i < count($array_data); $i++) {
                    $drug_type = '';
                    $cases = $array_data[$i];

                    if ($i == 1) $drug_type = 'Canabis';
                    elseif ($i == 2) $drug_type = 'Stimulanți';
                    elseif ($i == 3) $drug_type = 'Opiacee';
                    elseif ($i == 4) $drug_type = 'NSP';

                    if(!$this->drugStatsModel->addDataToUrgenteMedicale($year, $category, $subcategory, $drug_type, $cases)){
                        http_response_code(500); 
                        echo json_encode(['message' => 'Error processing data.']);
                    }

                    
                }
            }

            http_response_code(200);
            echo json_encode(['message' => 'Data processed successfully.']);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error loading file: ' . $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'No file uploaded.']);
    }

}


}

?>