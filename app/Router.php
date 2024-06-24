<?php
class Router {
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        $segments = explode('/', $url);
        array_shift($segments);

        $controllerName = !empty($segments[1]) ? ucfirst($segments[1]) . 'Controller' : 'HomeController';
        $methodName = !empty($segments[2]) ? $segments[2] : 'index';
        $params = array_slice($segments, 2);

        $controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';

        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        } else {
            header('Location: /RomanianDrugExplorer/app/views/errorPages/404NotFound.php');
            exit;
        }

        $controller = new $controllerName();

        switch ($method) {
            case 'GET':
                if ($controllerName === 'UsersController') {
                    if (!empty($segments[1]) && is_numeric($segments[1])) {
                        $controller->getUser($segments[1]);
                    } else {
                        $controller->getUsers();
                    }
                } elseif ($controllerName === 'DrugStatsController') {
                    if (!empty($segments[2]) && $segments[2] === 'confiscations') {
                        if (!empty($segments[3]) && $segments[3] === 'captures') {
                            if (!empty($segments[4]) && is_numeric($segments[4])) {
                                $controller->getStatsByYear($segments[4]);
                            }
                        } elseif (!empty($segments[3]) && $segments[3] === 'grams') {
                            if (!empty($segments[4]) && is_numeric($segments[4])) {
                                $controller->getStatsByYearGrams($segments[4]);
                            }
                        } elseif (!empty($segments[3]) && $segments[3] === 'tablets') {
                            if (!empty($segments[4]) && is_numeric($segments[4])) {
                                $controller->getStatsByYearTablets($segments[4]);
                            }
                        } else {
                            $controller->getDrugStats();
                        }
                    } elseif (!empty($segments[2]) && $segments[2] === 'infractionality') {
                        if (!empty($segments[3]) && $segments[3] === 'gender') {
                            if (!empty($segments[4]) && is_numeric($segments[4])) {
                                $controller->getStatsByYearInfractionalityGenderAge($segments[4]);
                            }
                        } elseif (!empty($segments[3]) && $segments[3] === 'penalities') {
                            if (!empty($segments[4]) && is_numeric($segments[4])) {
                                $controller->getStatsByYearInfractionalityPenalities($segments[4]);
                            }
                        } else {
                            $controller->getDrugStatsInfractionality();
                        }
                    } elseif (!empty($segments[2]) && $segments[2] === 'emergencies') {
                        if (!empty($segments[3]) && $segments[3] === 'gender') {
                            if (!empty($segments[4]) && is_numeric($segments[4])) {
                                $controller->getStatsByYearMedicGenderDrug($segments[4]);
                            } else {
                                $controller->getDrugStatsMedic();
                            }
                        } elseif (!empty($segments[3]) && $segments[3] === 'emergency') {
                            if (!empty($segments[4]) && is_numeric($segments[4])) {
                                $controller->getStatsByYearMedicEmergencyDrug($segments[4]);
                            } else {
                                $controller->getDrugStatsMedic();
                            }
                        } elseif (!empty($segments[3]) && $segments[3] === 'age') {
                            if (!empty($segments[4]) && is_numeric($segments[4])) {
                                $controller->getStatsByYearMedicAgeDrug($segments[4]);
                            } else {
                                $controller->getDrugStatsMedic();
                            }
                        } else {
                            $controller->getDrugStatsMedic();
                        }
                    } elseif (!empty($segments[2]) && $segments[2] === 'projects') {
                        if (!empty($segments[3]) && is_numeric($segments[3])) {
                            $controller->getStatsByYearProject($segments[3]);
                        } else {
                            $controller->getDrugStatsProject();
                        }
                    }
                } elseif ($controllerName === 'HomeController') {
                    $controller->index();
                } else {
                    header('Location: /RomanianDrugExplorer/app/views/errorPages/405NotFound.php');
                    exit;
                }
                break;

            case 'PUT':
                if ($controllerName === 'UsersController' && !empty($segments[2]) && is_numeric($segments[2]) && $segments[3] === 'reset-password') {
                    $controller->resetPassword($segments[2]);
                } else {
                    header('Location: /RomanianDrugExplorer/app/views/errorPages/405NotFound.php');
                    exit;
                }
                break;

            case 'POST':
                if ($controllerName === 'UsersController' && empty($segments[2])) {
                    $controller->createUser();
                } elseif ($controllerName === 'UsersController' && $segments[2] === 'login') {
                    $controller->loginUser();
                } elseif ($controllerName === 'UsersController' && $segments[2] === 'logout') {
                    $controller->logoutUser();
                } elseif ($controllerName === 'UsersController' && $segments[2] === 'forgot-password') {
                    $controller->forgotPassword();
                } elseif ($controllerName === 'UsersController' && $segments[2] === 'verify-code') {
                    $controller->verifyCode();
                } elseif ($controllerName === 'DrugStatsController' && $segments[2] === 'add-data' && $segments[3] === 'urgente-medicale' && !empty($segments[4]) && is_numeric($segments[4])) {
                    $controller->addDataToUrgenteMedicale($segments[4]);
                } elseif ($controllerName === 'DrugStatsController' && $segments[2] === 'add-data' && $segments[3] === 'infractionalitati' && !empty($segments[4]) && is_numeric($segments[4])) {
                    $controller->addDataToInfractionalitati($segments[4]);
                } elseif ($controllerName === 'DrugStatsController' && $segments[2] === 'add-data' && $segments[3] === 'proiecte' && !empty($segments[4]) && is_numeric($segments[4])) {
                    $controller->addDatatoProiecte($segments[4]);
                } elseif ($controllerName === 'DrugStatsController' && $segments[2] === 'add-data' && $segments[3] === 'confiscari-dorguri' && !empty($segments[4]) && is_numeric($segments[4])) {
                    $controller->addDataToConfiscariDroguri($segments[4]);
                } else {
                    header('Location: /RomanianDrugExplorer/app/views/errorPages/405NotFound.php');
                    exit;
                }
                break;

            case 'DELETE':
                if ($controllerName === 'UsersController' && !empty($segments[2]) && is_numeric($segments[2])) {
                    $controller->deleteUser($segments[2]);
                } else {
                    header('Location: /RomanianDrugExplorer/app/views/errorPages/405NotFound.php');
                    exit;
                }
                break;

            default:
                header('Location: /RomanianDrugExplorer/app/views/errorPages/405NotFound.php');
                exit;
        }
    }
}
?>
