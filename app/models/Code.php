<?php


require_once dirname(__FILE__) .'/../config/Db.php';

class Code extends DB {
    
        public function getCodes() {
            try {
                $sql = "SELECT * FROM codes";
                $stmt = $this->pdo->query($sql);
                $codes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $codes;
            } catch (PDOException $e) {
                echo "Error fetching codes: " . $e->getMessage();
                return null;
            }
        }
    
        public function getCodeById($id) {
            try {
                $sql = "SELECT * FROM codes WHERE id = :id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                $code = $stmt->fetch(PDO::FETCH_ASSOC);
                return $code;
            } catch (PDOException $e) {
                echo "Error fetching code: " . $e->getMessage();
                return null;
            }
        }
    
        public function getCodeByCode($code) {
            try {
                $sql = "SELECT * FROM codes WHERE code = :code";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':code', $code, PDO::PARAM_STR);
                $stmt->execute();
                $code = $stmt->fetch(PDO::FETCH_ASSOC);
                return $code;
            } catch (PDOException $e) {
                echo "Error fetching code: " . $e->getMessage();
                return null;
            }
        }
    
        public function getCodeByUserId($user_id) {
            try {
                $sql = "SELECT * FROM codes WHERE user_id = :user_id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->execute();
                $code = $stmt->fetch(PDO::FETCH_ASSOC);
                return $code;
            } catch (PDOException $e) {
                echo "Error fetching code: " . $e->getMessage();
                return null;
            }
        }

        public function addCode($user_id, $code) {
            try {
                $sql = "INSERT INTO codes (user_id, code) VALUES (:user_id, :code)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':code', $code, PDO::PARAM_STR);
                $stmt->execute();
                return $this->pdo->lastInsertId();
            } catch (PDOException $e) {
                echo "Error adding code: " . $e->getMessage();
                return null;
            }
        }
}