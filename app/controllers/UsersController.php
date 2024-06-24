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
        include_once 'D:\\ProgramFiles\\htdocs\\RomanianDrugExplorer\\public\\utils\\validate_jwt.php';

        http_response_code(200);
        echo json_encode($this->userModel->getUsers());
    }

    public function getUser($id) {
        $user = $this->userModel->getUserById($id);
        if ($user) {
            http_response_code(200);
            echo json_encode($user);
            return;
        }

        http_response_code(404);
        echo '404 Not Found';
    }

    public function updateUser($id) {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        $required_fields = ['username', 'email', 'phonenumber', 'password', 'role'];

        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $result = $this->userModel->editUser($id, $data['username'], $data['email'], $data['phonenumber']);

        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'User updated succesfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    public function createUser() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        $required_fields = ['username', 'email', 'phonenumber', 'password', 'role'];

        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        if ($this->userModel->getUserByUsername($data['username'])) {
            http_response_code(409);
            echo json_encode(['message' => 'Username already exists.']);
            return;
        }

        if ($this->userModel->getUserByPhonenumber($data['phonenumber'])) {
            http_response_code(409);
            echo json_encode(['message' => 'Phone number already exists.']);
            return;
        }

        if ($this->userModel->getUserByEmail($data['email'])) {
            http_response_code(409);
            echo json_encode(['message' => 'Email already exists.']);
            return;
        }

        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

        $newUserId = $this->userModel->addUser($data['username'], $data['email'], $data['phonenumber'], $hashed_password, $data['role']);
        $this->userModel->sendConfirmation($data['email'],  $data['username']);

        http_response_code(200);
        echo json_encode(['message' => 'User created successfully!']);
    }

    public function deleteUser($id) {
        $success = $this->userModel->deleteUser($id);

        if ($success) {
            http_response_code(200);
            echo json_encode(['message' => 'User deleted successfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    public function loginUser() {
        session_start();
        $data = json_decode(file_get_contents("php://input"));

        $username = $data->username;
        $password = $data->password;

        $user = $this->userModel->authenticateUser($username, $password);

        if ($user === 'invalid_username') {
            http_response_code(401);
            echo json_encode(["message" => "Account not found. Please check your username or create a new account."]);
            return;
        }

        if ($user === 'invalid_password') {
            http_response_code(401);
            echo json_encode(["message" => "Invalid password."]);
            return;
        }

        $key = "81eddc0ad6797e1e86cfe55dbb1e9d97a344bedc777358daf48dbb190f0764c320fc0fadefe3b9ccacc173dd4297b1926d2907222c424ed8cafedd789f4dd46f";
        $payload = array(
            "iss" => "localhost:80",
            "aud" => "localhost:80",
            "iat" => time(),
            "exp" => time() + (60*60),
            "data" => array(
                "id" => $user['id'],
                "username" => $user['username']
            )
        );
        $header = [
            "alg" => "HS256",
            "typ" => "JWT",
            "kid" => "d111111111111111111111111111111111"
        ];
        $jwt = JWT::encode($payload, $key, 'HS256', null, $header);

        setcookie("jwt", $jwt, time() + (60*60), "/");
        $_SESSION['loggedin'] = true;
        $_SESSION['isAdmin'] = $user['role'] === 'admin' ? true : false;

        http_response_code(200);
        echo json_encode(["message" => "Login successful."]);
    }

    public function logoutUser() {
        session_start();
        session_unset();
        session_destroy();

        if (isset($_COOKIE['jwr'])) {
            unset($_COOKIE['jwt']);
            setcookie('jwt', '', time() - 3600, '/');
        }

        http_response_code(200);
        echo json_encode(['message' => 'Successfully logged out']);
    }

    public function forgotPassword() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        $required_fields = ['username', 'email'];

        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $user = $this->userModel->getUserByUsername($data['username']);
        if (!$user) {
            http_response_code(404);
            echo json_encode(['message' => 'Username not found']);
            return;
        }

        if ($user['email'] !== $data['email']) {
            http_response_code(400);
            echo json_encode(['message' => 'Email does not match username']);
            return;
        }

        $code = rand(1000, 9999);

        while($this->codeModel->getCodeByCode($code)) {
            $code = rand(1000, 9999);
        }

        if($this->codeModel->getCodeByUserId($user['id'])) {
            http_response_code(429);
            echo json_encode(['message' => 'A reset code has already been sent. Please wait before requesting another.']);
            return;
        }

        $this->codeModel->addCode($user['id'], $code);

        if($this->userModel->sendEmail($data['email'], $code, $user['username'])) {
            http_response_code(200);
            echo json_encode(['message' => 'Reset code sent to email']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to send reset code']);
        }
    }

    public function verifyCode() {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        $required_fields = ['code'];

        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['message' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $code = $data['code'];
        $codeData = $this->codeModel->getCodeByCode($code);

        if(!$codeData) {
            http_response_code(404);
            echo json_encode(['message' => 'Invalid code for reset password.']);
            return;
        }

        http_response_code(200);
        echo json_encode(['message' => 'Code verified successfully', 'userId' => $codeData['user_id']]);
    }

    public function resetPassword($id) {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        if ($data === null) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid JSON data']);
            return;
        }

        $required_fields = ['password'];

        foreach ($required_fields as $field) {
            if (!array_key_exists($field, $data)) {
                http_response_code(400);
                echo json_encode(['error' => 'Missing required field: ' . $field]);
                return;
            }
        }

        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $result = $this->userModel->resetPassword($id, $hashed_password);

        $user = $this->userModel->getUserById($id);
        $this->codeModel->deleteCodeByUserId($user['id']);

        if ($result) {
            http_response_code(200);
            echo json_encode(['message' => 'User updated succesfully']);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }
}
