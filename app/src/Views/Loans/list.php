<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Empréstimos</title>
    <style>
        // Adicionar algum CSS básico para a tabela 
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Gerenciamento de Empréstimos</h1>
    <a href="/loans/create">Criar Novo Empréstimo</a>
    <br><br>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>CPF do Usuário</th>
                <th>ISBN do Livro</th>
                <th>Data do Empréstimo</th>
                <th>Data da Devolução</th>
                <th>Devolvido</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($loans as $loan): ?>
            <tr>
                <td><?php echo htmlspecialchars($loan['id']); ?></td>
                <td><?php echo htmlspecialchars($loan['user_cpf']); ?></td>
                <td><?php echo htmlspecialchars($loan['book_ISBN']); ?></td>
                <td><?php echo htmlspecialchars($loan['loan_date']); ?></td>
                <td><?php echo htmlspecialchars($loan['return_date']); ?></td>
                <td><?php echo $loan['returned'] ? 'Sim' : 'Não'; ?></td>
                <td>
                    <a href="/loans/edit/<?php echo $loan['id']; ?>">Editar</a>
                    <a href="/loans/delete/<?php echo $loan['id']; ?>" onclick="return confirm('Tem certeza?');">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>