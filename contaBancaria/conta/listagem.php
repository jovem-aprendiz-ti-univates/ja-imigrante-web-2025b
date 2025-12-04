<?php

require_once 'ContaBancaria.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $acao = $_POST['acao'];
    if ($acao === 'excluir') {
        $numeroConta = $_POST['numero_conta'];
        $conta = ContaBancaria::buscarPorNumero($numeroConta);
        $conta->excluir();
    }
}

$contas = ContaBancaria::listarTodos();
?>

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
    <a href="cadastra.php"><button type="button">Cadastrar nova conta</button></a>
    <a href="index.html "><button type="button">Voltar</button></a>

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
                        <td>
                            <a href="movimentacao.php?id=<?= $c->getNumeroConta() ?>">
                                <button class="roxo" type="button">Movimentar</button>
                            </a>
                            <a href="edita.php?editar=<?= $c->getNumeroConta() ?>">
                                <button class="amarelo" type="button">Editar</button>
                            </a>
                            <form method="POST" style="display: inline;">
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
