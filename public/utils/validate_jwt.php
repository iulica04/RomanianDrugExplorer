<?php
use Firebase\JWT\JWT;

// Get JWT from cookies
$jwt = isset($_COOKIE['jwt']) ? $_COOKIE['jwt'] : "";

if ($jwt) {
    try {
        // Decode JWT
        $key = "81eddc0ad6797e1e86cfe55dbb1e9d97a344bedc777358daf48dbb190f0764c320fc0fadefe3b9ccacc173dd4297b1926d2907222c424ed8cafedd789f4dd46f"; // Replace with your secret key
        $decoded = JWT::decode($jwt, $key);

        // Now you can use $decoded to get the user data
        $userId = $decoded->data->id;
        $username = $decoded->data->username;

        // If the JWT is valid, you can continue with the request...
    } catch (Exception $e) {
        // If the JWT is invalid, you can send an error response
        http_response_code(401);
        echo json_encode(["message" => "Access denied. Invalid token.", "error" => $e->getMessage()]);
        exit();
    }
} else {
    // If no JWT was provided, you can send an error response
    http_response_code(401);
    echo json_encode(["message" => "Access denied. No token provided."]);
    exit();
}
?>