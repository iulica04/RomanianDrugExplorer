<?php

require_once dirname(__FILE__) .'/../config/Db.php';

class DrugStats  extends Db{
 
    /////////////////////////////////////////DRUG CONSUMPTION////////////////////////////////////////////
    public function getStats() {
        try {
            $sql = "SELECT year, SUM(catches) AS total_value FROM confiscari_droguri GROUP BY year";
            $stmt = $this->pdo->query($sql);
            $stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $stats;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;
        }
    }
    

    public function getStatsByYear($an) {
        try {
            $sql = "SELECT drug_name, catches 
                    FROM confiscari_droguri
                    WHERE year =:an
                    And drug_name IS NOT NULL AND drug_name != '' 
                    AND catches IS NOT NULL AND catches != ''";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':an', $an, PDO::PARAM_INT);
            $stmt->execute();
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);  
            return $drugs;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;
        }
    }


    /////////////////////////////////////////INFRACTIONALITY////////////////////////////////////////////
    public function getStatsInfractionality() {
        try {
            $sql = "SELECT year, SUM(value) AS total_value FROM infractionalitate GROUP BY year";
            $stmt = $this->pdo->query($sql);
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $drugs;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;
        }
    }
    

    public function getStatsByYearInfractionality($an) {
        try {
            $sql = "SELECT * FROM  infractionalitate WHERE year = :an";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':an', $an, PDO::PARAM_INT);
            $stmt->execute();
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC); 
            return $drugs;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;
        }
    }

    public function getStatsByYearInfractionalityGenderAge($an) {
        try {
            $sql = "SELECT category, subcategory, type, value
                    FROM infractionalitate 
                    WHERE year =:an
                    AND category = 'Persoane condamnate pe sexe' 
                    AND subcategory IS NOT NULL AND subcategory != ''
                    AND type IS NOT NULL AND type != 'Total'
                    AND value IS NOT NULL AND value != ''";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':an', $an, PDO::PARAM_INT);
            $stmt->execute();
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $drugs;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;
        }
    }

    public function getStatsByYearInfractionalityPenalities($an) {
        try {
            $sql = "SELECT category, subcategory, value 
                    FROM infractionalitate 
                    WHERE year =:an
                    AND category = 'Persoane cercetate trimise in judecata si condamnate' 
                    AND subcategory IS NOT NULL AND subcategory != ''
                    AND value IS NOT NULL AND value != ''";

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':an', $an, PDO::PARAM_INT);
            $stmt->execute();
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $drugs;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;
        }
    }
    
    
    /////////////////////////////////////////MEDICAL EMERGENCIES/////////////////////////////////////////////////////////////

    public function getStatsMedic() {
        try {
            $sql = "SELECT year, SUM(cases) AS total_value FROM urgente_medicale GROUP BY year";
            $stmt = $this->pdo->query($sql);
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $drugs;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;

        }
    }


    public function getStatsByYearMedic($an) {
        try {
            $sql = "SELECT * FROM urgente_medicale WHERE year = :an";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':an', $an, PDO::PARAM_INT);
            $stmt->execute();
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);  
            return $drugs;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;
        }
    }

    public function getStatsByYearMedicEmergencyDrug($an) {
        try {
            $sql = "SELECT subcategory, drug_type, cases
            FROM urgente_medicale 
            WHERE year = :an 
            AND category = 'Diagnosis' 
            AND subcategory is not null AND subcategory != ''";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':an', $an, PDO::PARAM_INT);
            $stmt->execute();
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);  
            return $drugs;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;
        }
    }

    public function getStatsByYearMedicGenderDrug($an) {
        try {
            $sql = "SELECT subcategory, drug_type, cases
                    FROM urgente_medicale 
                    WHERE year = :an 
                    AND category = 'Sex' 
                    AND subcategory IS NOT NULL AND subcategory != ''";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':an', $an, PDO::PARAM_INT);
            $stmt->execute();
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);  
            return $drugs;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;
        }
    }


    public function getStatsByYearMedicAgeDrug($an) {
        try {
            $sql = "SELECT subcategory, drug_type, cases
                    FROM urgente_medicale 
                    WHERE year = :an 
                    AND category = 'Age' 
                    AND subcategory IS NOT NULL AND subcategory != ''";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':an', $an, PDO::PARAM_INT);
            $stmt->execute();
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);  
            return $drugs;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;

        }
    }
    ///////////////////////////////////////////PROJECTS//////////////////////////////////////////////

    public function getStatsProject() {
        try {
            $sql = "SELECT * FROM proiecte";
            $stmt = $this->pdo->query($sql);
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $drugs;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;
        }
    }


    public function getStatsByYearProject($an) {
        try {
            $sql = "SELECT * FROM proiecte WHERE year = :an";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':an', $an, PDO::PARAM_INT);
            $stmt->execute();
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);  
            return $drugs;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;
        }
    }

    public function addDataToUrgenteMedicale($year, $category, $subcategory, $drug_type, $cases){
        try {
            $sql = "INSERT INTO urgente_medicale (year, category, subcategory, drug_type, cases) VALUES (:year, :category, :subcategory, :drug_type, :cases)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->bindParam(':subcategory', $subcategory, PDO::PARAM_STR);
            $stmt->bindParam(':drug_type', $drug_type, PDO::PARAM_STR);
            $stmt->bindParam(':cases', $cases, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error adding data: " . $e->getMessage();
            return false;
        }
    }

    public function addDataToProiecte($year, $category, $subcategory, $beneficiaries)
    {
        try {
            $sql = "INSERT INTO proiecte (year, category, subcategory, beneficiaries) VALUES (:year, :category, :subcategory, :beneficiaries)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->bindParam(':subcategory', $subcategory, PDO::PARAM_STR);
            $stmt->bindParam(':beneficiaries', $beneficiaries, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error adding data: " . $e->getMessage();
            return false;
        }   
    }

    public function addDataToInfractionalitate($year, $category, $subcategory, $value, $type)
    {
        try {
            $sql = "INSERT INTO infractionalitate (year, category, subcategory, value, type) VALUES (:year, :category, :subcategory, :value, :type)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
            $stmt->bindParam(':subcategory', $subcategory, PDO::PARAM_STR);
            $stmt->bindParam(':value', $value, PDO::PARAM_INT);
            $stmt->bindParam(':type', $type, PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error adding data: " . $e->getMessage();
            return false;
        }   
    }

    public function addDataToConfiscariDroguri($year, $drug_name, $grams, $tablets, $doses, $mililiters, $catches)
    {
        try {
            $sql = "INSERT INTO confiscari_droguri (year, drug_name, grams, tablets, doses, mililiters, catches) VALUES (:year, :drug_name, :grams, :tablets, :doses, :mililiters, :catches)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':drug_name', $drug_name, PDO::PARAM_STR);
            $stmt->bindParam(':grams', $grams, PDO::PARAM_INT);
            $stmt->bindParam(':tablets', $tablets, PDO::PARAM_INT);
            $stmt->bindParam(':doses', $doses, PDO::PARAM_INT);
            $stmt->bindParam(':mililiters', $mililiters, PDO::PARAM_INT);
            $stmt->bindParam(':catches', $catches, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error adding data: " . $e->getMessage();
            return false;
        }
    }
}

?>