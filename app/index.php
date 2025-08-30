<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inicia a sessão para todas as requisições
session_start();

// Carrega o autoload do Composer
require __DIR__ . '/vendor/autoload.php';

use App\Controllers\UserController;
use App\Core\Router;
use App\Controllers\DashboardController;

$router = new Router();

$router->get('/', function() {
    // Lembre-se de ajustar este caminho se sua view estiver em outro lugar!
    include __DIR__ . '/src/Views/UserView.php';
});

// Rota GET para exibir o formulário de login e registro
$router->get('/login', function() {
    // Lembre-se de ajustar este caminho se sua view estiver em outro lugar!
    include __DIR__ . '/src/Views/UserView.php';
});

// Rota POST para processar os dados do formulário de login
$router->post('/login', [UserController::class, 'login']);

// Rota GET para exibir o formulário (a mesma página de login)
$router->get('/register', function() {
    // Lembre-se de ajustar este caminho se sua view estiver em outro lugar!
    include __DIR__ . '/src/views/UserView.php';
});

// Rota POST para processar o registro
$router->post('/register', [UserController::class, 'register']);

// Rota para logout
$router->get('/logout', [UserController::class, 'logout']);

// Rota para o dashboard
$router->get('/dashboard', [DashboardController::class, 'index']);


// Captura a URI e o método da requisição
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Despacha a rota
$router->dispatch($uri, $method);