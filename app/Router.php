<?php



class Router {
    public function dispatch() {

        // Get the request method
        $method = $_SERVER['REQUEST_METHOD'];

        // Get the request URL
        $url = $_SERVER['REQUEST_URI'];
        

        

        // Split the URL into segments
        $segments = explode('/', $url);
        array_shift($segments);

        // Extract the controller and method from the URL
        $controllerName = !empty($segments[1]) ? ucfirst($segments[1]) . 'Controller' : 'HomeController';
        $methodName = !empty($segments[2]) ? $segments[2] : 'index';

        // Extract parameters from URL segments
        $params = array_slice($segments, 2);

       

        // Include the controller file
        $controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';

        
        if (file_exists($controllerFile)) {
            //echo "YES"; // deci intra in controler :))))
            require_once $controllerFile;
        } else {
            // Handle 404 Not Found
            http_response_code(404);
            echo '404 Not Found' . $controllerFile;
            exit;
        }

    

        // Instantiate the controller and call the method
        $controller = new $controllerName();
       

        // Call the appropriate method based on HTTP method

        switch ($method) {
            case 'GET':
                if ($controllerName === 'UsersController') {
                    // Handle GET /users and GET /users/{id}
                    if (!empty($segments[1]) && is_numeric($segments[1])) {
                        // GET /users/{id}
                        $controller->getUser($segments[1]);
                    } else {
                        // GET /users
                        $controller->getUsers();
                    }
                } elseif ($controllerName === 'HomeController'){
                    // Handle GET /home
                    $controller->index();
                
                } 
                else {
                    // Handle 405 Method Not Allowed for other controllers
                    http_response_code(405);  //////// nu aici
                    echo '405 Method Not Allowed2';
                    exit;
                }
                break;
            case 'PUT':
                if ($controllerName === 'UsersController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    // Handle PUT /users/{id}
                    $controller->updateUser($segments[1]);
                } else {
                    // Handle 405 Method Not Allowed for other controllers or invalid endpoint
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'POST':
                if ($controllerName === 'UsersController' && empty($segments[2])) {
                    // Handle POST /users
                    $controller->createUser();
                } elseif($controllerName === 'UsersController' && $segments[2] === 'login') {
                    // Handle POST /users/login
                    $controller->loginUser();
                 } elseif($controllerName === 'UsersController' && $segments[2] === 'logout') {
                    // Handle POST /users/logout
                    $controller->logoutUser();
                 } else {
                    http_response_code(405);
                    echo '405 Method Not Allowed3'. $controllerName;
                    exit;
                }
                break;
            case 'DELETE':
                if ($controllerName === 'UsersController' && !empty($segments[1]) && is_numeric($segments[1])) {
                    // Handle DELETE /users/{id}
                    $controller->deleteUser($segments[1]);
                } else {
                    // Handle 405 Method Not Allowed for other controllers or invalid endpoint
                    
                    echo '405 Method Not Allowed4 ' . $controllerName;
                    exit;
                }
                break;
            default:
                // Handle other HTTP methods

                
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Mesajul tau personalizat pentru eroarea 405']);
                exit;
        }
        
    }
}

?>