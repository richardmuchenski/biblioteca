<?php

class UserModel {
    /**
     * @var PDO var que representa a conexão com o banco de dados
     */
    private $db;
 
    //private $redis;

    // Construtor da classe.
    
    public function __construct() {
        // Conexão com o Banco de Dados (MySQL) 
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

        /* Conexão com o Redis usando Predis
        $redisConfig = require __DIR__ . '/../../config/redis.php';
        try {
            $this->redis = new \Predis\Client([
                'scheme' => 'tcp',
                'host'   => $redisConfig['host'],
                'port'   => $redisConfig['port'],
            ]);
            $this->redis->ping(); // Testa a conexão
        } catch (Exception $e) {
            error_log("Erro de conexão com o Redis: " . $e->getMessage());
            $this->redis = null;
        }*/
    }

    // Autentica um usuário com base no email e senha.
     
    public function authenticate($email, $senha) {
        $user = $this->getUserByEmail($email); // Reutiliza o function

        if ($user && password_verify($senha, $user['senha'])) {
            return true;
        }

        return false;
    }

    // Busca um usuário pelo email, com lógica de cache.
     
    public function getUserByEmail($email) {
        $cacheKey = "user:email:" . md5($email);

        if ($this->redis && $this->redis->exists($cacheKey)) {
            return json_decode($this->redis->get($cacheKey), true);
        }

        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $this->redis) {
            // Armazena no cache por 1 hora
            $this->redis->setex($cacheKey, 3600, json_encode($user));
        }

        return $user;
    }

    // Cria um novo usuário.
     
    public function createUser($nome, $email, $senha) {
        $hashedPassword = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (nome, email, senha) VALUES (:nome, :email, :senha)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $hashedPassword);
        return $stmt->execute();
    }

    // Atualiza um usuário e invalida o cache.
     
    public function updateUser($cpf, $nome, $email) {
        $stmt = $this->db->prepare("UPDATE users SET nome = :nome, email = :email WHERE cpf = :cpf");
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $success = $stmt->execute();

        if ($success && $this->redis) {
            // Remove o usuário do cache para garantir que os dados sejam atualizados na próxima busca.
            $cacheKey = "user:email:" . md5($email);
            $this->redis->del([$cacheKey]);
        }
        return $success;
    }

    // Deleta um usuário e limpa o cache.
    public function deleteUser($cpf) {
        // Primeiro, busca os dados do usuário para poder limpar o cache depois
        $user = $this->getUserByCpf($cpf);

        if ($user) {
            $stmt = $this->db->prepare("DELETE FROM users WHERE cpf = :cpf");
            $stmt->bindParam(':cpf', $cpf);
            $success = $stmt->execute();

            if ($success && $this->redis) {
                // Remove o usuário do cache usando o email.
                $cacheKey = "user:email:" . md5($user['email']);
                $this->redis->del([$cacheKey]);
            }
            return $success;
        }
        return false;
    }

    // Lista todos os usuários.
    public function getAllUsers() {
        $stmt = $this->db->query("SELECT cpf, nome, email, role FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verifica se o usuário é admin.
    public function isAdmin($email) {
        $user = $this->getUserByEmail($email); // Reutiliza o método com cache
        return $user && isset($user['role']) && $user['role'] === 'admin';
    }

    public function getUserByCpf($cpf) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE cpf = :cpf");
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByName($name) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE nome = :nome");
        $stmt->bindParam(':nome', $name);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* Função para armazenar um empréstimo no cache Redis, removido por conta que teve problemas em utilizar redis.
    public function cacheLoan($loan) {
        if ($this->redis) {
            $this->redis->set("loan:{$loan['id']}", json_encode($loan));
            $this->redis->expire("loan:{$loan['id']}", 3600); // Expira em 1 hora
        }
    }*/    

    //Revisar tudo e verificar se está funcionando, uso do redis é a primeira vez não tenho certeza se funcionaria mas deixei aqui.
}