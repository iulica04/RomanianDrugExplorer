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
            $sql = "SELECT * FROM confiscari_droguri WHERE an = :an";
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
            $sql = "SELECT * FROM infractionalitate";
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
            $sql = "SELECT * FROM  infractionalitate WHERE an = :an";
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
            $sql = "SELECT gen, varsta, numar 
                    FROM infractionalitate 
                    WHERE an = :an 
                    AND gen IS NOT NULL AND gen != '' 
                    AND varsta IS NOT NULL AND varsta != ''";
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
            $sql = "SELECT stare, numar 
                    FROM infractionalitate 
                    WHERE an = :an 
                    AND stare IS NOT NULL AND stare != ''";
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
        $sql = "SELECT * FROM urgente_medicale WHERE an = :an";
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
        $sql = "SELECT * FROM proiecte WHERE an = :an";
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