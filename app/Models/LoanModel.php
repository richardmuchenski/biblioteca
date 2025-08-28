<?php


class LoanModel {
    /**
    *@var PDO var que representa a conexão com o banco de dados
    **/
    private $db;
    /**
     *@var \Predis\Client|null O cliente de conexão com o servidor Redis.
    **/
    private $redis;

    // Construtor da classe.
    public function __construct() {
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
        // --- Conexão com o Redis usando Predis ---
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
        }
    }

    public function getAllLoans() {
        $stmt = $this->db->query("SELECT id, user_cpf, book_isbn, loan_date, return_date, returned FROM loans");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Revisar tudo e verificar se está funcionando
}