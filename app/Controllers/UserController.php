<?php

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
                header('Location: index.php?page=dashboard');
                exit();
            } else {
                echo "Credenciais inválidas.";
            }
        } else {
            include __DIR__ . '/../Views/login.php';
        }
    }
    public function logout() {
        session_destroy();
        header('Location: index.php?page=login');
        exit();
    }

    //Preciso testar depois se está funcionando
}