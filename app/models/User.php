<?php


require_once dirname(__FILE__) .'/../config/Db.php';

class User extends DB {

    public function getUsers() {
        try {
            $sql = "SELECT * FROM users";
            $stmt = $this->pdo->query($sql);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $e) {
            echo "Error fetching users: " . $e->getMessage();
            return null;
        }
    }

    public function getUserById($id) {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return null;
        }
    }

    public function addUser($username, $email, $phonenumber, $password, $role) {
        try {
            $sql = "INSERT INTO users (username, email, phonenumber, password, role) VALUES (:username, :email, :phonenumber, :password, :role)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);  
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':role', $role, PDO::PARAM_STR);
            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function editUser($id, $name, $email, $age) {
        try {
            $sql = "UPDATE users SET name = :name, email = :email, age = :age WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':age', $age, PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Check if any rows were affected
            if ($stmt->rowCount() > 0) {
                return true; // User updated successfully
            } else {
                return false; // User not found
            }
        } catch (PDOException $e) {
            echo "Error editing user: " . $e->getMessage();
            return false;
        }
    }

    public function deleteUser($id) {
        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->rowCount() > 0) {
                return true; //User deleted succesfully
            } else {
                return false; //User not found
            }
        } catch (PDOException $e) {
            echo "Error deleting user: " . $e->getMessage();
            return false;
        }
    }

     public function usernameExists($username) {
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    public function authenticateUser($username, $password) {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // If no user was found, return a specific error code
        if (!$user) {
            return 'invalid_username';
        }
    
        // If a user was found but the password is incorrect, return a different error code
        if (!password_verify($password, $user['password'])) {
            return 'invalid_password';
        }
    
        // If a user was found and the password is correct
        return $user;
    }

    public function phoneNumberExists($phonenumber) {
        $sql = "SELECT COUNT(*) FROM users WHERE phonenumber = :phonenumber";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['phonenumber' => $phonenumber]);
        $count = $stmt->fetchColumn();

        return $count > 0;
    }

    
}
?>