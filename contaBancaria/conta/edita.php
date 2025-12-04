<?php

require_once 'ContaBancaria.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $acao = $_POST['acao'];
    if ($acao === 'editar') {
        $numeroConta = $_POST['numero_conta'];
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $dataNasc = $_POST['data'];
        $conta = new ContaBancaria($nome, $cpf, $dataNasc, 1000, 0, $numeroConta);
        $conta->atualizar();
        header("Location: listagem.php");
        exit(); 
    }
}

if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['editar'])) {
    $numeroConta = $_GET['editar'];
    $contaEditar = ContaBancaria::buscarPorNumero($numeroConta);
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor de contas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="caixa">

        <form method="POST">
            <h2>Editar Conta</h2>

            <input type="hidden" name="acao" value="editar" />
            <input type="hidden" name="numero_conta" value="<?= $contaEditar->getNumeroConta() ?>" />


            <label>Digite seu nome</label>
            <input type="text" name="nome" value="<?= $contaEditar->getNome() ?>" required />

            <label>Digite seu CPF</label>
            <input type="text" name="cpf" maxlength="11" placeholder="Digite apenas números" value="<?= $contaEditar->getCpf() ?>" required />

            <label>Data de Nascimento</label>
            <input type="date" name="data" value="<?= $contaEditar->getDataNascimento() ?>" required />

            <button type="submit">Atualizar</button>
            <a href="listagem.php"><button type="button">Cancelar</button></a>

        </form>
    </div>
</body>

</html>
