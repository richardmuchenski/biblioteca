<?php

namespace App\Models;

use PDO;
use PDOException;   

class LoanModel {
    /**
    *@var PDO var que representa a conexão com o banco de dados
    **/
    private $db;
  
    //private $redis;

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

        /* Conexão com o Redis usando Predis, desativado por conta de problemas em utilizar redis.
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
    //Função para retornar todos os empréstimos.
    public function getAllLoans() {
        $stmt = $this->db->query("SELECT id, user_cpf, book_isbn, loan_date, return_date, returned FROM loans");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Busca um empréstimo pelo ID.
    public function getLoanById($id) {
        $stmt = $this->db->prepare("SELECT id, user_cpf, book_isbn, loan_date, return_date, returned FROM loans WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Cria um novo empréstimo.
    public function createLoan($user_cpf, $book_isbn, $loan_date, $return_date) {
        $stmt = $this->db->prepare("INSERT INTO loans (user_cpf, book_isbn, loan_date, return_date, returned) VALUES (:user_cpf, :book_isbn, :loan_date, :return_date, 0)");
        $stmt->bindParam(':user_cpf', $user_cpf);
        $stmt->bindParam(':book_isbn', $book_isbn);
        $stmt->bindParam(':loan_date', $loan_date);
        $stmt->bindParam(':return_date', $return_date);
        return $stmt->execute();
    }
    // Atualiza um empréstimo existente.
    public function updateLoan($id, $user_cpf, $book_isbn, $loan_date, $return_date, $returned) {
        $stmt = $this->db->prepare("UPDATE loans SET user_cpf = :user_cpf, book_isbn = :book_isbn, loan_date = :loan_date, return_date = :return_date, returned = :returned WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':user_cpf', $user_cpf);
        $stmt->bindParam(':book_isbn', $book_isbn);
        $stmt->bindParam(':loan_date', $loan_date);
        $stmt->bindParam(':return_date', $return_date);
        $stmt->bindParam(':returned', $returned);
        return $stmt->execute();
    }
    // Deleta um empréstimo.
    public function deleteLoan($id) {
        $stmt = $this->db->prepare("DELETE FROM loans WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
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