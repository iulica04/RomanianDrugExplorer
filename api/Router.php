<?php

class Router{
    public function dispatch() {
        $uri = $_SERVER['REQUEST_URI'];

        switch ($uri) {
            case '/users':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    echo json_encode([
                        'message' => 'Utilizator creat cu succes',
                    ]);
                }
                break;
            // alte rute aici
            default:
                // gestionarea rutei implicite
        }
    }
}

?>