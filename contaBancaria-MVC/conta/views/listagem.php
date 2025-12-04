<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de contas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Contas cadastradas</h2>
    <a href="index.php?acao=cadastrar"><button type="button">Cadastrar nova conta</button></a>
    <a href="index.php"><button type="button">Voltar</button></a>

    <?php if (empty($contas)): ?>
        <p>Nenhuma conta cadastrada.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Data Nasc.</th>
                    <th>Saldo</th>
                    <th>Limite</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contas as $c): ?>
                    <tr>
                        <td><?= $c->getNumeroConta() ?></td>
                        <td><?= $c->getNome() ?></td>
                        <td><?= $c->getCpf() ?></td>
                        <td><?= $c->getDataNascimento() ?></td>
                        <td><?= $c->getSaldo() ?></td>
                        <td><?= $c->getLimite() ?></td>
                        <td style="white-space: nowrap;">
                            <a href="index.php?acao=movimentar&id=<?= $c->getNumeroConta() ?>">
                                <button class="roxo" type="button">Movimentar</button>
                            </a>
                            <a href="index.php?acao=editar&id=<?= $c->getNumeroConta() ?>">
                                <button class="amarelo" type="button">Editar</button>
                            </a>
                            <form method="POST" style="display: inline-block;">
                                <input type="hidden" name="acao" value="excluir" />
                                <input type="hidden" name="numero_conta" value="<?= $c->getNumeroConta() ?>" />
                                <button type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
