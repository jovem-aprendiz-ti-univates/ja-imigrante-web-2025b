<?php

require_once 'ContaBancaria.php';

$contaEditar = null;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $acao = $_POST['acao'];

    if ($acao === 'cadastrar') {
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $dataNasc = $_POST['data'];
        $conta = new ContaBancaria($nome, $cpf, $dataNasc);
        $conta->inserirNovaConta();
    } else if ($acao === 'editar') {
        $numeroConta = $_POST['numero_conta'];
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $dataNasc = $_POST['data'];
        $conta = new ContaBancaria($nome, $cpf, $dataNasc, 1000, 0, $numeroConta);
        $conta->atualizar();
    } else if ($acao === 'excluir') {
        $numeroConta = $_POST['numero_conta'];
        $conta = ContaBancaria::buscarPorNumero($numeroConta);
        $conta->excluir();
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['editar'])) {
    $numeroConta = $_GET['editar'];
    $contaEditar = ContaBancaria::buscarPorNumero($numeroConta);
}

$contas = ContaBancaria::listarTodos();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de contas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="caixa">

        <form method="POST">
            <h2><?= $contaEditar ? 'Editar Conta' : 'Cadastrar Conta' ?></h2>
            
            <input type="hidden" name="acao" value="<?= $contaEditar ? 'editar' : 'cadastrar' ?>" />
            <?php if ($contaEditar): ?>
                <input type="hidden" name="numero_conta" value="<?= $contaEditar->getNumeroConta() ?>" />
            <?php endif; ?>

            <label>Digite seu nome</label>
            <input type="text" name="nome" value="<?= $contaEditar ? $contaEditar->getNome() : '' ?>" required />
            
            <label>Digite seu CPF</label>
            <input type="text" name="cpf" maxlength="11" placeholder="Digite apenas números" value="<?= $contaEditar ? $contaEditar->getCpf() : '' ?>" required />
            
            <label>Data de Nascimento</label>
            <input type="date" name="data" value="<?= $contaEditar ? $contaEditar->getDataNascimento() : '' ?>" required />
            
            <button type="submit"><?= $contaEditar ? 'Atualizar' : 'Cadastrar' ?></button>
            <?php if ($contaEditar): ?>
                <a href="index.php"><button type="button">Cancelar</button></a>
            <?php endif; ?>
        </form>
    </div>

    <h2>Contas cadastradas</h2>

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
                            <a href="?editar=<?= $c->getNumeroConta() ?>">
                                <button type="button">Editar</button>
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