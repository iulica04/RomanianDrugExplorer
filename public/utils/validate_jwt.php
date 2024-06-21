<?php
use Firebase\JWT\JWT;

// Get JWT from cookies
$jwt = isset($_COOKIE['jwt']) ? $_COOKIE['jwt'] : "";

if ($jwt) {
    try {
        // Decode JWT
        $key = "your_secret_key"; // Replace with your secret key
        $decoded = JWT::decode($jwt, $key, array('HS256'));

        // Now you can use $decoded to get the user data
        $userId = $decoded->data->id;
        $username = $decoded->data->username;

        // If the JWT is valid, you can continue with the request...
    } catch (Exception $e) {
        // If the JWT is invalid, you can send an error response
        http_response_code(401);
        echo json_encode(["message" => "Access denied. Invalid token."]);
        exit();
    }
} else {
    // If no JWT was provided, you can send an error response
    http_response_code(401);
    echo json_encode(["message" => "Access denied. No token provided."]);
    exit();
}
?>