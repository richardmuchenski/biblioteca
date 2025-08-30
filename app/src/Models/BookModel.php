<?php

namespace App\Models;

use PDO;
use PDOException;

class BookModel {

    /**
     * @var PDO // var que representa a conexão com o banco de dados
     */

    private $db;

    //private $redis;

    // Construtor da classe, realiza configuração com o banco de dados.
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
    
    //Função para retornar todos os livros.
    public function getAllBooks() {
        $stmt = $this->db->query("SELECT isbn, titulo, autor, ano_publicado, categoria,  quantidade_estoque, capa_url FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca um livro pelo isbn.
    public function getBookByisbn($isbn) {
        $stmt = $this->db->prepare("SELECT isbn, titulo, autor, ano_publicado, categoria, quantidade_estoque, capa_url FROM books WHERE isbn = :isbn");
        $stmt->bindParam(':isbn', $isbn);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Cria um novo livro.
    public function createBook($isbn, $titulo, $autor, $ano_publicado, $categoria, $quantidade_estoque, $capa_url) {
        $stmt = $this->db->prepare("INSERT INTO books (isbn, titulo, autor, ano_publicado, categoria, quantidade_estoque, capa_url) VALUES (:isbn, :titulo, :autor, :ano_publicado, :categoria, :quantidade_estoque, :capa_url)");
        $stmt->bindParam(':isbn', $isbn);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':autor', $autor);
        $stmt->bindParam(':ano_publicado', $ano_publicado);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':quantidade_estoque', $quantidade_estoque);
        $stmt->bindParam(':capa_url', $capa_url);
        return $stmt->execute();
    }
    //Atualiza informações do livro apontado.
    public function updateBook($isbn, $titulo, $autor, $ano_publicado, $categoria, $quantidade_estoque, $capa_url) {
        $stmt = $this->db->prepare("UPDATE books SET titulo = :titulo, autor = :autor, ano_publicado = :ano_publicado, categoria = :categoria, quantidade_estoque = :quantidade_estoque, capa_url = :capa_url WHERE isbn = :isbn");
        $stmt->bindParam(':isbn', $isbn);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':autor', $autor);
        $stmt->bindParam(':ano_publicado', $ano_publicado);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':quantidade_estoque', $quantidade_estoque);
        $stmt->bindParam(':capa_url', $capa_url);
        return $stmt->execute();
    }
    //Deleta o livro apontado.
    public function deleteBook($isbn) {
        $stmt = $this->db->prepare("DELETE FROM books WHERE isbn = :isbn");
        $stmt->bindParam(':isbn', $isbn);
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
