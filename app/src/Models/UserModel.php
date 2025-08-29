<?php

namespace App\Models;

use PDO;
use PDOException;

class UserModel
{
    /**
     * @var PDO representa a conexão com o banco de dados
     */
    private $db;

    public function __construct()
    {
        $dbConfig = require __DIR__ . '/../../config/database.php';
        try {
            $this->db = new PDO(
                "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset=utf8",
                $dbConfig['user'],
                $dbConfig['password']
            );
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro de conexão com o banco de dados: " . $e->getMessage());
        }
    }

    /**
     * Autentica um usuário com base no email e senha.
     */
    public function authenticate($email, $senha)
    {
        $user = $this->getUserByEmail($email);

        // Verifica se o usuário existe e se a senha fornecida corresponde ao hash no banco de dados.
        if ($user && password_verify($senha, $user['senha'])) {
            return true;
        }

        return false;
    }

    /**
     * Busca um usuário pelo email diretamente do banco de dados.
     */
    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cria um novo usuário, criptografando a senha.

    public function createUser($nome, $email, $senha, $telefone, $cpf)
    {
        // Criptografa a senha antes de salvar no banco de dados.
        $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            "INSERT INTO users (nome, email, senha, telefone, cpf) VALUES (:nome, :email, :senha, :telefone, :cpf)"
        );

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $hashedPassword);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':cpf', $cpf);

        return $stmt->execute();
    }
        // Verifica se o usuário é admin com base no email.
        public function isAdmin($email)
    {
        $user = $this->getUserByEmail($email);
        // Verifica se o usuário foi encontrado, se a coluna 'role' existe e se o valor é 'admin'
        return $user && isset($user['role']) && $user['role'] === 'admin';
    }

    public function getAllUsers() {
        $stmt = $this->db->query("SELECT nome, email, telefone, cpf, role FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}