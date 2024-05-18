<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/RomanianDrugExplorer/' :
        require __DIR__ . '/public/pages/home.php';
        break;
    case '' :
        require __DIR__ . '/public/pages/home.php';
        break;
    case '/public/pages/login' :
        require __DIR__ . '/public/pages/login.php';
        break;
    case '/public/pages/register' :
        require __DIR__ . '/public/pages/register.php';
        break;
    default:
        http_response_code(404);
        break;
}

?>