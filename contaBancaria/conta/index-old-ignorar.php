<?php

require_once 'ContaBancaria.php';

$conta = new ContaBancaria(6000.00);

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $valor = $_POST['valor'];
    $acao  = $_POST['acao'];
    if($acao === 'depositar') {
        $conta->depositar($valor);
    } else {
        $retorno = $conta->sacar($valor);
        if(!$retorno){
            echo "<script>alert('Não foi possível sacar!');</script>";        
        }
    }

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
            Saldo Atual: R$ <?php echo number_format($conta->getSaldo(), 2, ',', '.'); ?>
        </div>
        
        <hr>

        <form method="POST" action="index.php">
            <h3>Fazer um Depósito ou Saque</h3>
            <input type="number" name="valor" placeholder="Digite o valor" step="0.01" required>
            <button type="submit" name="acao" value="depositar">Depositar</button>
            <button type="submit" name="acao" value="sacar">Sacar</button>
        </form>

    </div>

</body>
</html>