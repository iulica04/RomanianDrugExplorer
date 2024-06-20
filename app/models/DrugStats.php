<?php

require_once dirname(__FILE__) .'/../config/Db.php';

class DrugStats  extends Db{
    // Metode pentru interogarea datelor despre consumul de droguri
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
    

    public function getStatsById($id) {
        try {
            $sql = "SELECT * FROM confiscari_droguri WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $drug = $stmt->fetch(PDO::FETCH_ASSOC);
            return $drug;
        } catch (PDOException $e) {
            echo "Error fetching drug: " . $e->getMessage();
            return null;
        }
    }

    public function getStatsByYear($an) {
        try {
            $sql = "SELECT * FROM confiscari_droguri WHERE an = :an";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':an', $an, PDO::PARAM_INT);
            $stmt->execute();
            $drugs = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Folosește fetchAll pentru a aduna toate rândurile
            return $drugs;
        } catch (PDOException $e) {
            echo "Error fetching drugs: " . $e->getMessage();
            return null;
        }
    }

    /*public function addDrug($drog, $grame, $comprimate, $mililitri, $capturi) {
        try {
            $sql = "INSERT INTO confiscari_droguri (drog, grame, comprimate, mililitri, capturi) VALUES (:drog, :grame, :comprimate, :mililitri, :capturi)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':drog', $drog, PDO::PARAM_STR);
            $stmt->bindParam(':grame', $grame, PDO::PARAM_STR);
            $stmt->bindParam(':comprimate', $comprimate, PDO::PARAM_INT);
            $stmt->bindParam(':mililitri', $mililitri, PDO::PARAM_STR);
            $stmt->bindParam(':capturi', $capturi, PDO::PARAM_INT);
            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo "Error adding drug: " . $e->getMessage();
            return false;
        }
    }

    public function editDrug($id, $drog, $grame, $comprimate, $mililitri, $capturi) {
        try {
            $sql = "UPDATE confiscari_droguri SET drog = :drog, grame = :grame, comprimate = :comprimate, mililitri = :mililitri, capturi = :capturi WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':drog', $drog, PDO::PARAM_STR);
            $stmt->bindParam(':grame', $grame, PDO::PARAM_STR);
            $stmt->bindParam(':comprimate', $comprimate, PDO::PARAM_INT);
            $stmt->bindParam(':mililitri', $mililitri, PDO::PARAM_STR);
            $stmt->bindParam(':capturi', $capturi, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            // Check if any rows were affected
            if ($stmt->rowCount() > 0) {
                return true; // Drug updated successfully
            } else {
                return false; // Drug not found
            }
        } catch (PDOException $e) {
            echo "Error editing drug: " . $e->getMessage();
            return false;
        }
    }

    public function deleteDrug($id) {
        try {
            $sql = "DELETE FROM confiscari_droguri WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true; // Drug deleted successfully
            } else {
                return false; // Drug not found
            }
        } catch (PDOException $e) {
            echo "Error deleting drug: " . $e->getMessage();
            return false;
        }
 }*/
}
?>