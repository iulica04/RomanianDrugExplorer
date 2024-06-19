<?php

require_once dirname(__FILE__) . '/../models/User.php';

class UsersController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
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
        if ($this->userModel->usernameExists($data['username'])) {
            // Send response with status code 409 for conflict
            http_response_code(409);
            echo json_encode(['message' => 'Username already exists']);
            return;
        }
    
        // Hash the password before storing it
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
    
        $newUserId = $this->userModel->addUser($data['username'], $data['email'], $data['phonenumber'], $hashed_password, $data['role']);
    
        // Send response with status code 201 and location header
        http_response_code(201);
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/' . $newUserId);
        echo json_encode(['message' => 'User created successfully']);
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
}

?>