<?php

require_once 'ContaBancaria.php';

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $valor = $_POST['valor'];
    $acao  = $_POST['acao'];
    $numeroConta  = $_POST['numero_conta'];
    $conta = ContaBancaria::buscarPorNumero($numeroConta);
    
    if($acao === 'depositar') {
        $conta->depositar($valor);
    } else {
        $conta->sacar($valor);
    }
    
    $conta = ContaBancaria::buscarPorNumero($numeroConta);
}

if (isset($_GET['id'])) {
    $numeroConta = $_GET['id'];
    $conta = ContaBancaria::buscarPorNumero($numeroConta);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Caixa Eletrônico Digital</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="caixa">
        <h1>Caixa Eletrônico</h1>

        <div class="saldo">
            Conta de <?= $conta->getNome() ?> tem saldo atual de: R$ <?php echo number_format($conta->getSaldo(), 2, ',', '.'); ?>
        </div>
        
        <hr>

        <form method="POST" action="movimentacao.php">
            <h3>Fazer um Depósito ou Saque</h3>
            <input type="hidden" name="numero_conta" value="<?= $conta->getNumeroConta() ?>" />
            <input type="number" name="valor" placeholder="Digite o valor" step="0.01" required>
            <button type="submit" name="acao" value="depositar">Depositar</button>
            <button type="submit" name="acao" value="sacar">Sacar</button>
            <a href="listagem.php"><button type="button">Cancelar</button></a>
        </form>

    </div>

</body>
</html>
