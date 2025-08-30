<?php

namespace App\Controllers;

    class BookController {
        private $model;
        public function __construct() {
            $this->model = new BookModel();
        }

        public function listBooks() {
            requireRole(['admin', 'user']); //todos podem ver livros
            $books = $this->model->getAllBooks();
            include __DIR__ . '/../Views/books/list.php';
        }

        public function viewBook($isbn) {
            requireRole(['admin', 'user']); //todos podem ver livros
            $book = $this->model->getBookByisbn($isbn);
            if ($book) {
                include __DIR__ . '/../Views/books/view.php';
            } else {
                echo "Livro não encontrado.";
            }
        }

        public function createBook() {
            requireRole(['admin']); //somente admins podem criar livros
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $isbn = $_POST['isbn'] ?? '';
                $titulo = $_POST['titulo'] ?? '';
                $autor = $_POST['autor'] ?? '';
                $ano_publicado = $_POST['ano_publicado'] ?? '';
                $categoria = $_POST['categoria'] ?? '';
                $quantidade_estoque = $_POST['quantidade_estoque'] ?? '';
                $capa_url = $_POST['capa_url'] ?? '';

                if ($this->model->createBook($isbn, $titulo, $autor, $ano_publicado, $categoria, $quantidade_estoque, $capa_url)) {
                    header('Location: index.php?page=books');
                    exit();
                } else {
                    echo "Erro ao criar livro.";
                }
            } else {
                include __DIR__ . '/../Views/books/create.php';
            }
        }

        public function editBook($isbn) {
            requireRole(['admin']); //somente admins podem editar livros
            $book = $this->model->getBookByisbn($isbn);
            if (!$book) {
                echo "Livro não encontrado.";
                return;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $titulo = $_POST['titulo'] ?? '';
                $autor = $_POST['autor'] ?? '';
                $ano_publicado = $_POST['ano_publicado'] ?? '';
                $categoria = $_POST['categoria'] ?? '';
                $quantidade_estoque = $_POST['quantidade_estoque'] ?? '';
                $capa_url = $_POST['capa_url'] ?? '';

                if ($this->model->updateBook($isbn, $titulo, $autor, $ano_publicado, $categoria, $quantidade_estoque, $capa_url)) {
                    header('Location: index.php?page=books');
                    exit();
                } else {
                    echo "Erro ao atualizar livro.";
                }
            } else {
                include __DIR__ . '/../Views/books/edit.php';
            }
        }

        public function deleteBook($isbn) {
            requireRole(['admin']); //somente admins podem deletar livros
            if ($this->model->deleteBook($isbn)) {
                header('Location: index.php?page=books');
                exit();
            } else {
                echo "Erro ao deletar livro.";
            }
        }

        public function getBookByisbn($isbn) {
            return $this->model->getBookByisbn($isbn);
        }

        public function getAllBooks() {
            return $this->model->getAllBooks();
        }

        public function searchBooks($query) {
            return $this->model->searchBooks($query);
        }

        //Preciso testar depois se está funcionando
    }