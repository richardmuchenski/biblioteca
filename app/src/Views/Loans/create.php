<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Criar Empréstimo</title>
</head>
<body>
    <h1>Registrar Novo Empréstimo</h1>
    <form action="/loans/create" method="POST">
        <label for="user_cpf">CPF do Usuário:</label><br>
        <input type="text" id="user_cpf" name="user_cpf" required><br><br>

        <label for="book_ISBN">ISBN do Livro:</label><br>
        <input type="text" id="book_ISBN" name="book_ISBN" required><br><br>

        <label for="loan_date">Data do Empréstimo:</label><br>
        <input type="date" id="loan_date" name="loan_date" required><br><br>

        <label for="return_date">Data de Devolução Prevista:</label><br>
        <input type="date" id="return_date" name="return_date" required><br><br>

        <button type="submit">Salvar Empréstimo</button>
    </form>
</body>
</html>