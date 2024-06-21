<?php


require_once dirname(__FILE__) .'/../config/Db.php';
require_once dirname(__FILE__) . '/../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

    public function getUserByUsername($username) {
        try {
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return null;
        }
    }

    public function getUserByPhonenumber($phonenumber) {
        try {
            $sql = "SELECT * FROM users WHERE phonenumber = :phonenumber";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':phonenumber', $phonenumber, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch (PDOException $e) {
            echo "Error fetching user: " . $e->getMessage();
            return null;
        }
    }

    public function getUserByEmail($email) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
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

    public function sendEmail($email, $code, $username) {
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = 0; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.office365.com'; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = 'romaniandrugexplorer@outlook.com'; // Your Gmail address
            $mail->Password = 'DrugSafe@12'; // Your Gmail password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to

    
            $mail->setFrom('romaniandrugexplorer@outlook.com', 'Drug Info');
            $mail->addAddress($email, $username);

            
            $mail->isHTML(true);
            $mail->Subject = 'Reset Your Password';
            $mail->Body = '<!DOCTYPE html>
            <html>
            <head>
                <title>Password Reset</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f9;
                        color: #333;
                        margin: 0;
                        padding: 20px;
                    }
                    .email-container {
                        background-color: #CFE1B9;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                        max-width: 600px;
                        margin: 0 auto;
                    }
                    .email-container h2 {
                        margin-top: 0;
                        font-size: 24px;
                        color: #333;
                    }
                    .email-container p {
                        font-size: 16px;
                        color: #666;
                    }
                    .code {
                        display: block;
                        width: fit-content;
                        margin: 20px auto;
                        padding: 10px 20px;
                        background-color: #5e6b51;
                        border: 1px solid #ddd;
                        border-radius: 4px;
                        font-size: 18px;
                        color: #c6d9a5;
                    }
                    .footer {
                        margin-top: 30px;
                        font-size: 12px;
                        color: #999;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class="email-container">
                    <h2>Password Reset</h2>
                    <p>Hello, ' . $username . '</p>
                    <p>We received a request to reset your account password. Please use the code below to reset your password:</p>
                    <div class="code">' . $code . '</div>
                    <p>This reset code is valid for 30 minutes. If you did not request a password reset, please ignore this email.</p>
                    <p>Thank you!</p>
                    <p>Romanian Drug Explorer Team</p>
                    <div class="footer">
                        <p> 2024 Your Company. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>';
            
    
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function resetPassword($id, $password) {
        try {
            $sql = "UPDATE users SET password = :password WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Check if any rows were affected
            if ($stmt->rowCount() > 0) {
                return true; // Password updated successfully
            } else {
                return false; // User not found
            }
        } catch (PDOException $e) {
            echo "Error resetting password: " . $e->getMessage();
            return false;
        }
    }
}
?>