<?php

require_once dirname(__FILE__) . '/../models/User.php';
require_once dirname(__FILE__) . '/../models/Code.php';
require_once dirname(__FILE__) . '/../../vendor/autoload.php';
use \Firebase\JWT\JWT;

class UsersController {
    private $userModel;
    private $codeModel;

    public function __construct() {
        $this->userModel = new User();
        $this->codeModel = new Code();
    }

    public function getUsers() {
        // Send response with status code 200
        http_response_code(200);
        echo json_encode($this->userModel->getUsers());
    }

    public function getUser($id) {
        // Find user by ID
        $user = $this->userModel->getUserById($id);
            if ($user) {
                // Send response with status code 200
                http_response_code(200);
                echo json_encode($user);
                return;
            }

        // Send response with status code 404 if user not found
        http_response_code(404);
        echo '404 Not Found';
    }

    public function updateUser($id) {
         // Get the JSON data from the request body
         $json_data = file_get_contents('php://input');
         $data = json_decode($json_data, true);
     
         // Check if JSON data is valid
         if ($data === null) {
             // Send response with status code 400 for invalid JSON
             http_response_code(400);
             echo json_encode(['error' => 'Invalid JSON data']);
             return;
         }
     
         // Define the required fields
         $required_fields = ['username', 'email', 'phonenumber', 'password', 'role'];
     
         // Check if all required fields are present in the JSON data
         foreach ($required_fields as $field) {
             if (!array_key_exists($field, $data)) {
                 // Send response with status code 400 for missing fields
                 http_response_code(400);
                 echo json_encode(['error' => 'Missing required field: ' . $field]);
                 return;

             }
         }

        $result = $this->userModel->editUser($id, $data['username'], $data['email'], $data['phonenumber'], $data['password'], $data['role']);


        //You can be more thorough with error codes for example and include the 204 no content
        if($result) {
            // Send response with status code 200 if user was updated
            http_response_code(200);
            echo json_encode(['message' => 'User updated succesfully']);
        } else {
            // Send response with status code 404 if user not found
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
        
    }

    public function createUser() {
        // Get the JSON data from the request body
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
    
        // Check if JSON data is valid
        if ($data === null) {
            // Send response with status code 400 for invalid JSON
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
    
        // Define the required fields
        $required_fields = ['username', 'email', 'phonenumber', 'password', 'role'];
    
        // Check if all required fields are present in the JSON data
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                // Send response with status code 400 for missing fields
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }
    
        // Check if the username already exists
        if ($this->userModel->getUserByUsername($data['username'])) {
            // Send response with status code 409 for conflict
            http_response_code(409);
            echo json_encode(['message' => 'Username already exists.']);
            return;
        }
    
        // Check if the phone number already exists
        if ($this->userModel->getUserByPhonenumber($data['phonenumber'])) {
            // Send response with status code 409 for conflict
            http_response_code(409);
            echo json_encode(['message' => 'Phone number already exists.']);
            return;
        }

        if ($this->userModel->getUserByEmail($data['email'])) {
            // Send response with status code 409 for conflict
            http_response_code(409);
            echo json_encode(['message' => 'Email already exists.']);
            return;
        }
    
        // Hash the password before storing it
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
    
        $newUserId = $this->userModel->addUser($data['username'], $data['email'], $data['phonenumber'], $hashed_password, $data['role']);
    
        // Send response with status code 201 and location header
        http_response_code(201);
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $newUserId);
        echo json_encode(['message' => 'User created successfully!']);
    }
    
    

    public function deleteUser($id) {
        $success = $this->userModel->deleteUser($id);

        if ($success) {
            // Remove the user from the users array

            // Send response with status code 200
            http_response_code(200);
            echo json_encode(['message' => 'User deleted successfully']);
        } else {
            // Send response with status code 404 if user not found
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    public function loginUser() {
        session_start();
        // Get the request body
        $data = json_decode(file_get_contents("php://input"));
    
        // Get the username and password from the request
        $username = $data->username;
        $password = $data->password;
    
        // Authenticate the user
        $user = $this->userModel->authenticateUser($username, $password);
    
        if ($user === 'invalid_username') {
            // Send response with status code 401 (Unauthorized)
            http_response_code(401);
            echo json_encode(["message" => "Account not found. Please check your username or create a new account."]);
            return;
        }
    
        if ($user === 'invalid_password') {
            // Send response with status code 401 (Unauthorized)
            http_response_code(401);
            echo json_encode(["message" => "Invalid password."]);
            return;
        }


    $key = "your_secret_key"; // Replace with your secret key
    $payload = array(
        "iss" => "your_issuer", // Replace with your issuer
        "aud" => "your_audience", // Replace with your audience
        "iat" => time(),
        "exp" => time() + (60*60), // Token valid for 1 hour
        "data" => array(
            "id" => $user['id'],
            "username" => $user['username']
        )
    );
    $jwt = JWT::encode($payload, $key, 'HS256');

    // Store JWT in a cookie
    setcookie("jwt", $jwt, time() + (60*60), "/"); // Cookie valid for 1 hour
    $_SESSION['loggedin'] = true;

    // Send response with status code 200
    http_response_code(200);
    echo json_encode(["message" => "Login successful."]);
    }


    public function logoutUser() {
        // Distrugi sesiunea
        session_start();
        session_destroy();

        if (isset($_COOKIE['token'])) {
            unset($_COOKIE['token']);
            setcookie('token', '', time() - 3600, '/'); // setează data de expirare la o oră în trecut
        }
    
        // Setezi un răspuns de succes
        http_response_code(200);
        echo json_encode(['message' => 'Successfully logged out']);
    }

    public function forgotPassword() {
        // Get the JSON data from the request body
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
    
        // Check if JSON data is valid
        if ($data === null) {
            // Send response with status code 400 for invalid JSON
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
    
        // Define the required fields
        $required_fields = ['username', 'email'];
    
        // Check if all required fields are present in the JSON data
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                // Send response with status code 400 for missing fields
                http_response_code(400);
                echo json_encode(['message' => 'Missing required field: ' . $field]);
                return;
            }
        }
    
        $user = $this->userModel->getUserByUsername($data['username']);
        if (!$user) {
            // Send response with status code 404 if username not found
            http_response_code(404);
            echo json_encode(['message' => 'Username not found']);
            return;
        }
    
        // Check if the email matches the username
        if ($user['email'] !== $data['email']) {
            // Send response with status code 400 if email does not match username
            http_response_code(400);
            echo json_encode(['message' => 'Email does not match username']);
            return;
        }
    
        // Generate a random token
        $code = rand(1000, 9999);
    
        while($this->codeModel->getCodeByCode($code)) {
            $code = rand(1000, 9999);
        }

        if($this->codeModel->getCodeByUserId($user['id'])) {
            http_response_code(429);
            echo json_encode(['message' => 'A reset code has already been sent. Please wait before requesting another.']);
            return;
        }

        // Save the code in the database
        $this->codeModel->addCode($user['id'], $code);

        // Send the code to the user's email
        if($this->userModel->sendEmail($data['email'], $code, $user['username'])) {
            // Send response with status code 200
            http_response_code(200);
            echo json_encode(['message' => 'Reset code sent to email']);
        } else {
            // Send response with status code 500 for server error
            http_response_code(500);
            echo json_encode(['message' => 'Failed to send reset code']);
        }
        
    }

    public function verifyCode(){
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
    
        // Check if JSON data is valid
        if ($data === null) {
            // Send response with status code 400 for invalid JSON
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }
    
        // Define the required fields
        $required_fields = ['code'];

        // Check if all required fields are present in the JSON data
        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                // Send response with status code 400 for missing fields
                http_response_code(400);
                echo json_encode(['message' => 'Missing required field: ' . $field]);
                return;
            }
        }

        // Get the code from the request
        $code = $data['code'];

        // Find the code in the database
        $codeData = $this->codeModel->getCodeByCode($code);
        if(!$codeData) {
            // Send response with status code 404 if code not found
            http_response_code(404);
            echo json_encode(['message' => 'Code not found']);
            return;
        }

        // Send response with status code 200 if code is valid
        http_response_code(200);
        echo json_encode(['message' => 'Code verified successfully', 'userId' => $codeData['user_id']]);
    }

    public function resetPassword($id){
        $json_data = file_get_contents('php://input');
         $data = json_decode($json_data, true);
     
         // Check if JSON data is valid
         if ($data === null) {
             // Send response with status code 400 for invalid JSON
             http_response_code(400);
             echo json_encode(['error' => 'Invalid JSON data']);
             return;
         }
     
         // Define the required fields
         $required_fields = ['password'];
     
         // Check if all required fields are present in the JSON data
         foreach ($required_fields as $field) {
             if (!array_key_exists($field, $data)) {
                 // Send response with status code 400 for missing fields
                 http_response_code(400);
                 echo json_encode(['error' => 'Missing required field: ' . $field]);
                 return;

             }
         }

        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $result = $this->userModel->resetPassword($id, $hashed_password);


        //You can be more thorough with error codes for example and include the 204 no content
        if($result) {
            // Send response with status code 200 if user was updated
            http_response_code(200);
            echo json_encode(['message' => 'User updated succesfully']);
        } else {
            // Send response with status code 404 if user not found
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }
}

?>