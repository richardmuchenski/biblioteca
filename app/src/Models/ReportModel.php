<?php

namespace App\Models;

use PDO;
use PDOException;

class ReportModel {
    /**
     * @var PDO // var que representa a conexão com o banco de dados
     */

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
            // Define o modo de erro do PDO para exceções.
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Em caso de erro, exibe a mensagem e termina a execução.
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



    // Função para gerar relatório de livros mais emprestados.
    public function getReturnedLoansReport($limit = 10) {
        $stmt = $this->db->prepare("
            SELECT 
                b.titulo AS book_tittle,
                u.name AS user_name,
                l.loan_date, AS loan_date
            FROM
                loans l
            JOIN
                books b ON l.book_isbn = b.isbn
            JOIN
                users u ON l.user_cpf = u.cpf
            WHERE
                l.returned = 1
            ORDER BY
                l.loan_date DESC
            LIMIT :limit
        ");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Função para gerar relatório de livros mais emprestados.
    public function getMostLoansReport($limit = 10) {
        $stmt = $this->db->prepare("
            SELECT 
                b.titulo AS book_tittle,
                COUNT(l.id) AS total_loans
            FROM
                loans l
            JOIN
                books b ON l.book_isbn = b.isbn
            GROUP BY
                b.isbn, b.titulo
            ORDER BY
                total_loans DESC
            LIMIT :limit
        ");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Função para gerar relatório de empréstimos atrasados.
    public function getOverdueLoansReport() {
        $stmt = $this->db->prepare("
            SELECT 
                b.titulo AS book_tittle,
                u.name AS user_name,
                l.loan_date,
                l.return_date
            FROM
                loans l
            JOIN
                books b ON l.book_isbn = b.isbn
            JOIN
                users u ON l.user_cpf = u.cpf
            WHERE
                l.returned = 0 AND l.return_date < CURDATE()
            ORDER BY
                l.return_date ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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