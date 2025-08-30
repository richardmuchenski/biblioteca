<?php

namespace App\Controllers;

use App\Models\LoanModel;

class LoanController {
    private $model;

    public function __construct() {
        $this->model = new LoanModel();
    }

    public function listLoans() {
        requireRole(['admin']); //somente admins podem ver empréstimos
        $loans = $this->model->getAllLoans();
        include __DIR__ . '/../Views/loans/list.php';
    }

    public function viewLoan($id) {
        requireRole(['admin']); //somente admins podem ver empréstimos
        $loan = $this->model->getLoanById($id);
        if ($loan) {
            include __DIR__ . '/../Views/loans/view.php';
        } else {
            echo "Empréstimo não encontrado.";
        }
    }

    public function createLoan() {
        requireRole(['admin']); //somente admins podem criar empréstimos
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_cpf = $_POST['user_cpf'] ?? '';
            $book_isbn = $_POST['book_isbn'] ?? '';
            $loan_date = $_POST['loan_date'] ?? '';
            $return_date = $_POST['return_date'] ?? '';

            if ($this->model->createLoan($user_cpf, $book_isbn, $loan_date, $return_date)) {
                header('Location: index.php?page=loans');
                exit();
            } else {
                echo "Erro ao criar empréstimo.";
            }
        } else {
            include __DIR__ . '/../Views/loans/create.php';
        }
    }

    public function editLoan($id) {
        requireRole(['admin']); //somente admins podem editar empréstimos
        $loan = $this->model->getLoanById($id);
        if (!$loan) {
            echo "Empréstimo não encontrado.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_cpf = $_POST['user_cpf'] ?? '';
            $book_isbn = $_POST['book_isbn'] ?? '';
            $loan_date = $_POST['loan_date'] ?? '';
            $return_date = $_POST['return_date'] ?? '';
            $returned = isset($_POST['returned']) ? 1 : 0;
            if ($this->model->updateLoan($id, $user_cpf, $book_isbn, $loan_date, $return_date, $returned)) {
                header('Location: index.php?page=loans');
                exit();
            } else {
                echo "Erro ao atualizar empréstimo.";
            }
        } else {
            include __DIR__ . '/../Views/loans/edit.php';
        }
    }
    public function deleteLoan($id) {
        requireRole(['admin']); //somente admins podem deletar empréstimos
        if ($this->model->deleteLoan($id)) {
            header('Location: index.php?page=loans');
            exit();
        } else {
            echo "Erro ao deletar empréstimo.";
        }
    }

    public  function getLoanById($id) {
        return $this->model->getLoanById($id);
    }

    public function getLoanByUser($user_cpf) {
        return $this->model->getLoanByUser($user_cpf);
    }

    public function getLoanByBook($book_isbn) {
        return $this->model->getLoanByBook($book_isbn);
    }
}