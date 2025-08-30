<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Empréstimo</title>
</head>
<body>
    <h1>Editar Empréstimo #<?php echo htmlspecialchars($loan['id']); ?></h1>
    <form action="/loans/edit/<?php echo htmlspecialchars($loan['id']); ?>" method="POST">
        <label for="user_cpf">CPF do Usuário:</label><br>
        <input type="text" id="user_cpf" name="user_cpf" value="<?php echo htmlspecialchars($loan['user_cpf']); ?>" required><br><br>

        <label for="book_ISBN">ISBN do Livro:</label><br>
        <input type="text" id="book_ISBN" name="book_ISBN" value="<?php echo htmlspecialchars($loan['book_ISBN']); ?>" required><br><br>

        <label for="loan_date">Data do Empréstimo:</label><br>
        <input type="date" id="loan_date" name="loan_date" value="<?php echo htmlspecialchars($loan['loan_date']); ?>" required><br><br>

        <label for="return_date">Data de Devolução Prevista:</label><br>
        <input type="date" id="return_date" name="return_date" value="<?php echo htmlspecialchars($loan['return_date']); ?>" required><br><br>
        
        <label for="returned">Devolvido:</label><br>
        <input type="checkbox" id="returned" name="returned" <?php echo $loan['returned'] ? 'checked' : ''; ?>><br><br>

        <button type="submit">Atualizar Empréstimo</button>
    </form>
</body>
</html>