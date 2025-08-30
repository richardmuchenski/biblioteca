<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController {
    private $model;
    public function __construct() {
        $this->model = new UserModel();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';

            if ($this->model->authenticate($email, $senha)) {
                $_SESSION['user'] = $email;
                header('Location: /dashboard');
                exit();
            } else {
                echo "Credenciais inválidas.";
            }
        } else {
            include __DIR__ . '/../Views/UserView.php';
        }
    }
    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: index.php?page=login');
        exit();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $telefone = $_POST['telefone'] ?? '';
            $cpf = $_POST['cpf'] ?? '';

            if (empty($nome) || empty($email) || empty($senha) || empty($telefone) || empty($cpf)) {
                echo "Todos os campos são obrigatórios.";
                return;
            }
            if ($this->model->createUser($nome, $email, $senha, $telefone, $cpf)) {
                echo "Usuário registrado com sucesso. <a href='/login'>Faça o login</a>";
            } else {
                echo "Erro ao registrar usuário.";
            };
        }
    }
    //Preciso testar depois se está funcionando
}