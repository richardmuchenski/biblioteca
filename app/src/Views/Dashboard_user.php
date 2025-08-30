<?php
// Garante que a sessão foi iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard do Usuário</title>
</head>
<body>
    <h1>Bem-vindo ao seu Dashboard, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
    <p>Aqui você pode ver seus empréstimos ativos e seu histórico.</p>
    <a href="/logout">Sair</a>

    <hr>

    <h2>Meus Empréstimos</h2>
    <?php if (!empty($loans)): ?>
        <table border="1" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Livro</th>
                    <th>Data do Empréstimo</th>
                    <th>Data de Devolução</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loans as $loan): ?>
                <tr>
                    <td><?php echo htmlspecialchars($loan['book_title']); ?></td>
                    <td><?php echo htmlspecialchars($loan['data_emprestimo']); ?></td>
                    <td><?php echo htmlspecialchars($loan['data_retorno']); ?></td>
                    <td><?php echo $loan['returned'] ? 'Devolvido' : 'Emprestado'; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Você não possui nenhum empréstimo no momento.</p>
    <?php endif; ?>

</body>
</html>