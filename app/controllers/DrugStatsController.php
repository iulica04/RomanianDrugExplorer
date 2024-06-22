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
public function addDataToUrgenteMedicale($year){

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

public function addDataToProiecte($year){

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
                if ($rowIndex == 3) {
                    $category = 'Proiecte Naționale';
                    $subcategory = 'CUM SĂ CREŞTEM SĂNĂTOŞI';
                } elseif ($rowIndex == 4) {
                    $category = 'Proiecte Naționale';
                    $subcategory = 'ABC-UL EMOŢIILOR';
                } elseif ($rowIndex == 5) {
                    $category = 'Proiecte Naționale';
                    $subcategory = 'NECENZURAT';
                } elseif ($rowIndex == 6) {
                    $category = 'Proiecte Naționale';
                    $subcategory = 'FRED GOES NET';
                } elseif ($rowIndex == 7) {
                    $category = 'Proiecte Naționale';
                    $subcategory = 'MESAJUL MEU ANTIDROG';
                } elseif ($rowIndex == 8) {
                    $category = 'Proiecte Naționale';
                    $subcategory = 'EU ŞI COPILUL MEU';
                } elseif ($rowIndex == 9) {
                    $category = 'Proiecte Naționale';
                    $subcategory = 'Abilități pentru acțiune';
                } elseif ($rowIndex == 10) {
                    $category = 'Proiecte Naționale';
                    $subcategory = 'Acționăm just';
                } elseif ($rowIndex == 15) {
                    $category = 'Campanii Naționale';
                    $subcategory = 'Ziua Națională Fără Tutun';
                } elseif ($rowIndex == 16) {
                    $category = 'Campanii Naționale';
                    $subcategory = '19 ZILE DE PREVENIRE A ABUZURILOR ȘI VIOLENȚELOR ASUPRA COPIILOR ȘI TINERILOR';
                } elseif ($rowIndex == 20) {
                    $category = 'Activități de Prevenire';
                    $subcategory = 'În mediul preşcolar';
                } elseif ($rowIndex == 21) {
                    $category = 'Activități de Prevenire';
                    $subcategory = 'În mediul primar, gimnazial şi liceal';
                } elseif ($rowIndex == 22) {
                    $category = 'Activități de Prevenire';
                    $subcategory = 'În mediul universitar';
                } elseif ($rowIndex == 23) {
                    $category = 'Activități de Prevenire';
                    $subcategory = 'În familie';
                } elseif ($rowIndex == 24) {
                    $category = 'Activități de Prevenire';
                    $subcategory = 'În comunitate';
                } else {
                    continue;
                }

                // Extragem valorile corespunzătoare pentru a fi inserate în tabel
                $beneficiaries = (int) filter_var($array_data[1], FILTER_SANITIZE_NUMBER_INT);

                if(!$this->drugStatsModel->addDataToProiecte($year, $category, $subcategory, $beneficiaries)){
                    http_response_code(500); 
                    echo json_encode(['message' => 'Error processing data.']);
                    return;
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

public function addDataToInfractionalitati($year){

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
                if ($rowIndex == 4) {
                    $category = 'Persoane cercetate trimise in judecata si condamnate';
                    $subcategory = 'Persoane cercetate';
                    $value = (int) filter_var($array_data[1], FILTER_SANITIZE_NUMBER_INT);
                } elseif ($rowIndex == 5) {
                    $category = 'Persoane cercetate trimise in judecata si condamnate';
                    $subcategory = 'Persoane trimise in judecata';
                    $value = (int) filter_var($array_data[1], FILTER_SANITIZE_NUMBER_INT);
                } elseif ($rowIndex == 6) {
                    $category = 'Persoane cercetate trimise in judecata si condamnate';
                    $subcategory = 'Persoane condamnate';
                    $value = (int) filter_var($array_data[1], FILTER_SANITIZE_NUMBER_INT);
                } elseif ($rowIndex >= 10 && $rowIndex <= 13) {
                    $category = 'Persoane condamnate pe încadrare juridică';
                    $subcategory = $array_data[0];
                    $value = (int) filter_var($array_data[1], FILTER_SANITIZE_NUMBER_INT);
                } elseif ($rowIndex == 18 || $rowIndex == 19) {
                    $category = 'Persoane condamnate pe sexe';
                    $subcategory = $array_data[0];
                    $value = (int) filter_var($array_data[1], FILTER_SANITIZE_NUMBER_INT);
                    $this->drugStatsModel->addDataToInfractionalitate($year, $category, $subcategory, $value, 'Majori');
                    
                    $subcategory = $array_data[0];
                    $value = (int) filter_var($array_data[2], FILTER_SANITIZE_NUMBER_INT);
                    $this->drugStatsModel->addDataToInfractionalitate($year, $category, $subcategory, $value, 'Minori');
                    continue;
                } elseif ($rowIndex == 23) {
                    $category = 'Grupări infracționale identificate';
                    $subcategory = 'Grupări identificate';
                    $value = (int) filter_var($array_data[1], FILTER_SANITIZE_NUMBER_INT);
                } elseif ($rowIndex == 24) {
                    $category = 'Grupări infracționale identificate';
                    $subcategory = 'Număr persoane implicate';
                    $value = (int) filter_var($array_data[1], FILTER_SANITIZE_NUMBER_INT);
                } elseif ($rowIndex >= 29 && $rowIndex <= 33) {
                    $category = 'Situația pedepselor aplicate pentru infracțiuni la regimul drogurilor';
                    $subcategory = $array_data[0];
                    $value_143 = (int) filter_var($array_data[1], FILTER_SANITIZE_NUMBER_INT);
                    $value_194 = (int) filter_var($array_data[2], FILTER_SANITIZE_NUMBER_INT);

                    $this->drugStatsModel->addDataToInfractionalitate($year, $category, $subcategory, $value_143, 'Legea nr. 143/2000');
                    $this->drugStatsModel->addDataToInfractionalitate($year, $category, $subcategory, $value_194, 'Legea nr. 194/2011');
                    continue; // Evităm dublarea inserării în baza de date
                } else {
                    continue;
                }

                // Inserăm datele în tabelul SQL
                if(!$this->drugStatsModel->addDataToInfractionalitate($year, $category, $subcategory, $value, 'Total')){
                    http_response_code(500); 
                    echo json_encode(['message' => 'Error processing data.']);
                    return;
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

public function addDataToConfiscariDroguri($year){

    if(isset($_FILES['fileToUpload'])) {
        $file = $_FILES['fileToUpload']['tmp_name'];

        // Încărcăm fișierul .xlsx
        try {
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();

            // Parcurgem rândurile
            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); 
                $rowIndex = $row->getRowIndex();
                $array_data = [];
                foreach ($cellIterator as $cell) {
                    $array_data[] = $cell->getValue();
                }

                if ($rowIndex <= 4) {
                    continue;
                }

                
                $drug_name = $array_data[0];
                $grams = !empty($array_data[1]) ? (float) filter_var($array_data[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : null;
                $tablets = !empty($array_data[2]) ? (int) filter_var($array_data[2], FILTER_SANITIZE_NUMBER_INT) : null;
                $doses = !empty($array_data[3]) ? (int) filter_var($array_data[3], FILTER_SANITIZE_NUMBER_INT) : null;
                $mililiters = !empty($array_data[4]) ? (float) filter_var($array_data[4], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : null;
                $catches = !empty($array_data[5]) ? (int) filter_var($array_data[5], FILTER_SANITIZE_NUMBER_INT) : null;

                // Inserăm datele în tabelul SQL pentru fiecare unitate de măsură existentă
                if (!$this->drugStatsModel->addDataToConfiscariDroguri($year, $drug_name, $grams, $tablets, $doses, $mililiters, $catches)){
                    http_response_code(500); 
                    echo json_encode(['message' => 'Error processing data.']);
                    return;
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