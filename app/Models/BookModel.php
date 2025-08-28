<?php

class BookModel {

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
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro de conexão com o banco de dados: " . $e->getMessage());
        }
    }

    public function getAllBooks() {
        $stmt = $this->db->query("SELECT ISBN, titulo, autor, year FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //Revisar tudo e verificar se está funcionando
}
