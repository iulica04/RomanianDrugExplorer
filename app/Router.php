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
            require_once $controllerFile;
        } else {
            // Handle 404 Not Found
            http_response_code(404);
            echo '404 Not Found ' . $controllerFile;
            exit;
        }

        // Instantiate the controller
        $controller = new $controllerName();

        // Call the appropriate method based on HTTP method
        switch ($method) {
            case 'GET':
                if ($controllerName === 'UsersController') {
                    // Handle GET /users and GET /users/{id}
                    if (!empty($segments[1]) && is_numeric($segments[1])) {
                        $controller->getUser($segments[1]);
                    } else {
                        $controller->getUsers();
                    }
                } elseif ($controllerName === 'DrugStatsController') {
                    // Handle GET /DrugStats/{type}/{year}
                    if(!empty($segments[2]) && $segments[2]==='confiscations') {
                        if (!empty($segments[3]) && is_numeric($segments[3])){
                       
                            $controller->getStatsByYear($segments[3]);
       
                           } else {
                               $controller->getDrugStats();
                              // echo 'nu e numeric';
                           }
                    } elseif(!empty($segments[2]) && $segments[2]==='infractionality') {
                        if (!empty($segments[3]) &&  $segments[3]=== 'gender'){
                            if (!empty($segments[4]) && is_numeric($segments[4])){
                            $controller->getStatsByYearInfractionalityGenderAge($segments[4]);
       
                           }
                        }elseif (!empty($segments[3]) &&  $segments[3] ==='penalities'){
                            if (!empty($segments[4]) && is_numeric($segments[4])){
                            $controller->getStatsByYearInfractionalityPenalities($segments[4]);
       
                           } 
                        }else{
                            $controller->getDrugStatsInfractionality();
                        }
                    }elseif(!empty($segments[2]) && $segments[2]==='emergencies') {
                        if (!empty($segments[3]) &&  $segments[3]=== 'gender'){
                            if (!empty($segments[4]) && is_numeric($segments[4])){
                            $controller->getStatsByYearMedicGenderDrug($segments[4]);
       
                           } else {
                               $controller->getDrugStatsMedic();
                              // echo 'nu e numeric';
                           }
                        }elseif (!empty($segments[3]) &&  $segments[3] ==='emergency'){
                            if (!empty($segments[4]) && is_numeric($segments[4])){
                            $controller->getStatsByYearMedicEmergencyDrug($segments[4]);
       
                           } else {
                               $controller->getDrugStatsMedic();
                              // echo 'nu e numeric';
                           }
                        }elseif (!empty($segments[3]) &&  $segments[3] ==='age'){
                            if (!empty($segments[4]) && is_numeric($segments[4])){
                            $controller->getStatsByYearMedicAgeDrug($segments[4]);
       
                           } else {
                               $controller->getDrugStatsMedic();
                              // echo 'nu e numeric';
                           }
                        }else{
                            $controller->getDrugStatsMedic();
                        }
                    }elseif(!empty($segments[2]) && $segments[2]==='projects') {
                        if (!empty($segments[3]) &&is_numeric($segments[3])){
                       
                            $controller->getStatsByYearProject($segments[3]);
       
                           } else {
                               $controller->getDrugStatsProject();
                              // echo 'nu e numeric';
                           }
                    }  
                } elseif ($controllerName === 'HomeController') {
                    $controller->index();
                } else {
                    // Handle 405 Method Not Allowed for other controllers
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'PUT':
                if ($controllerName === 'UsersController' && !empty($segments[2]) && is_numeric($segments[2]) && $segments[3] === 'reset-password') {
                    // Handle PUT /users/{id}
                    $controller->resetPassword($segments[2]);
                } 
                else {
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
                 } elseif ($controllerName === 'UsersController' && $segments[2] === 'forgot-password')
                 {
                    // Handle POST /users/forgot-password
                    $controller->forgotPassword();
                 } elseif($controllerName === 'UsersController' && $segments[2] === 'verify-code'){
                    $controller->verifyCode();
                 } elseif($controllerName === 'DrugStatsController' && $segments[2] === 'add-data' && $segments[3] === 'urgente-medicale' && !empty($segments[4]) && is_numeric($segments[4])){
                    $controller->addDataToUrgenteMedicale($segments[4]);
                 } elseif($controllerName === 'DrugStatsController' && $segments[2] === 'add-data' && $segments[3] === 'infractionalitati' && !empty($segments[4]) && is_numeric($segments[4])){
                    $controller->addDataToInfractionalitati($segments[4]);
                } elseif($controllerName === 'DrugStatsController' && $segments[2] === 'add-data' && $segments[3] === 'proiecte' && !empty($segments[4]) && is_numeric($segments[4])){
                    $controller->addDatatoProiecte($segments[4]);
                } elseif($controllerName === 'DrugStatsController' && $segments[2] === 'add-data' && $segments[3] === 'confiscari-dorguri' && !empty($segments[4]) && is_numeric($segments[4])){
                    $controller->addDataToConfiscariDroguri($segments[4]);
                 }else {
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            case 'DELETE':
                if ($controllerName === 'UsersController' && !empty($segments[2]) && is_numeric($segments[2])) {
                    // Handle DELETE /users/{id}
                    $controller->deleteUser($segments[2]);
                } else {
                    // Handle 405 Method Not Allowed for other controllers or invalid endpoint
                    http_response_code(405);
                    echo '405 Method Not Allowed';
                    exit;
                }
                break;
            default:
                // Handle other HTTP methods
                http_response_code(405);
                echo json_encode(['message' => 'Method Not Allowed']);
                exit;
        }
    }
}
