<?php

namespace App\Core;

$page = $_GET['page'] ?? 'home';

$controllerMap = [
    'login' => ['controller' => 'UserController', 'method' => 'login'],
    'logout' => ['controller' => 'UserController', 'method' => 'logout'],
    'dashboard' => ['controller' => 'DashboardController', 'method' => 'index'],
    'books' => ['controller' => 'BookController', 'method' => 'listBooks'],
    'addBook' => ['controller' => 'BookController', 'method' => 'addBook'],
    'editBook' => ['controller' => 'BookController', 'method' => 'editBook'],
    'deleteBook' => ['controller' => 'BookController', 'method' => 'deleteBook'],
    'users' => ['controller' => 'UserController', 'method' => 'listUsers'],
    'addUser' => ['controller' => 'UserController', 'method' => 'addUser'],
    'editUser' => ['controller' => 'UserController', 'method' => 'editUser'],
    'deleteUser' => ['controller' => 'UserController', 'method' => 'deleteUser'],
    'loans' => ['controller' => 'LoanController', 'method' => 'listLoans'],
    'addLoan' => ['controller' => 'LoanController', 'method' => 'addLoan'],
    'returnLoan' => ['controller' => 'LoanController', 'method' => 'returnLoan'],
    'reports' => ['controller' => 'ReportController', 'method' => 'generatePDF'],
];

//Primeira vez utilizando Router, muito provavlemente precise ajustar depois

if (array_key_exists($page, $controllerMap)) {
    $controllerName = $controllerMap[$page]['controller'];
    $methodName = $controllerMap[$page]['method'];

    require_once __DIR__ . '/../Controllers/' . $controllerName . '.php';
    $controller = new $controllerName();
    $controller->$methodName();
} else {
    http_response_code(404);
    echo "Página não encontrada.";
}