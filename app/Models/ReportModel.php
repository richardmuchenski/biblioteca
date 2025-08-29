<?php

class ReportModel {
    /**
     * @var PDO // var que representa a conexão com o banco de dados
     */

    private $db;

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
                books b ON l.book_ISBN = b.ISBN
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

    public function getMostLoansReport($limit = 10) {
        $stmt = $this->db->prepare("
            SELECT 
                b.titulo AS book_tittle,
                COUNT(l.id) AS total_loans
            FROM
                loans l
            JOIN
                books b ON l.book_ISBN = b.ISBN
            GROUP BY
                b.ISBN, b.titulo
            ORDER BY
                total_loans DESC
            LIMIT :limit
        ");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 