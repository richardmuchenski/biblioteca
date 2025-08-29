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
            // Define o modo de erro do PDO para exceções.
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Em caso de erro, exibe a mensagem e termina a execução.
            die("Erro de conexão com o banco de dados: " . $e->getMessage());
        }
    }
    
    //Função para retornar todos os livros.
    public function getAllBooks() {
        $stmt = $this->db->query("SELECT ISBN, titulo, autor, ano_publicado, categoria,  quantidade_estoque, capa_url FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Busca um livro pelo ISBN.
    public function getBookByISBN($isbn) {
        $stmt = $this->db->prepare("SELECT ISBN, titulo, autor, ano_publicado, categoria, quantidade_estoque, capa_url FROM books WHERE ISBN = :isbn");
        $stmt->bindParam(':isbn', $isbn);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    // Cria um novo livro.
    public function createBook($isbn, $titulo, $autor, $ano_publicado, $categoria, $quantidade_estoque, $capa_url) {
        $stmt = $this->db->prepare("INSERT INTO books (ISBN, titulo, autor, ano_publicado, categoria, quantidade_estoque, capa_url) VALUES (:isbn, :titulo, :autor, :ano_publicado, :categoria, :quantidade_estoque, :capa_url)");
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
        $stmt = $this->db->prepare("UPDATE books SET titulo = :titulo, autor = :autor, ano_publicado = :ano_publicado, categoria = :categoria, quantidade_estoque = :quantidade_estoque, capa_url = :capa_url WHERE ISBN = :isbn");
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
        $stmt = $this->db->prepare("DELETE FROM books WHERE ISBN = :isbn");
        $stmt->bindParam(':isbn', $isbn);
        return $stmt->execute();
    }
    //Revisar tudo e verificar se está funcionando
}
