<?php

require_once 'ContaBancaria.php';
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $acao = $_POST['acao'];
    if ($acao === 'cadastrar') {
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $dataNasc = $_POST['data'];
        $conta = new ContaBancaria($nome, $cpf, $dataNasc);
        $conta->inserirNovaConta();
        header("Location: listagem.php");
        exit(); 
    }
}
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
            <h2>Cadastrar Conta</h2>

            <input type="hidden" name="acao" value="cadastrar" />

            <label>Digite seu nome</label>
            <input type="text" name="nome" value="" required />

            <label>Digite seu CPF</label>
            <input type="text" name="cpf" maxlength="11" placeholder="Digite apenas números" value="" required />

            <label>Data de Nascimento</label>
            <input type="date" name="data" value="" required />

            <button type="submit">Cadastrar</button>
            <a href="listagem.php"><button type="button">Voltar</button></a>
        </form>
    </div>
</body>

</html>
