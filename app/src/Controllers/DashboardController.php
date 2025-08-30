<?php

namespace App\Controllers;

use App\Models\UserModel;

class DashboardController
{
    private $userModel;

    public function __construct()
    {

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Verifica se o usuário está logado
        if (!isset($_SESSION['user'])) {
            // Se não estiver logado, redireciona para a página de login
            header('Location: /login');
            exit();
        }

        // Pega o email do usuário da sessão
        $email = $_SESSION['user'];

        // Verifica se o usuário é um administrador
        if ($this->userModel->isAdmin($email)) {
            // Se for admin, carrega a view do admin
            include __DIR__ . '/../Views/Dashboard_admin.php';
        } else {
            // Se for um usuário comum, carrega a view do usuário
            include __DIR__ . '/../Views/Dashboard_user.php';
        }
    }
}