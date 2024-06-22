<?php

require_once dirname(__FILE__) .'/../config/Db.php';

class DrugStats  extends Db{
 
    /////////////////////////////////////////DRUG CONSUMPTION////////////////////////////////////////////
     public function getStats() {
        try {
            $sql = "SELECT * FROM confiscari_droguri";
            $stmt = $this->pdo->query($sql);
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $drugs;
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
            $sql = "SELECT * FROM infractionalitate ";
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
        $sql = "SELECT * FROM urgente_medicale";
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
        AND category = 'Diagnostic' 
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


   
}
?>