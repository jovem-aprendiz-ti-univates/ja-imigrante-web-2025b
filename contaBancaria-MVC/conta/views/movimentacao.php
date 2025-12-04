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
            Conta de <?= $conta->getNome() ?> tem saldo atual de: R$ <?= number_format($conta->getSaldo(), 2, ',', '.') ?>
        </div>
        
        <hr>

        <form method="POST">
            <h3>Fazer um Depósito ou Saque</h3>
            <input type="hidden" name="numero_conta" value="<?= $conta->getNumeroConta() ?>" />
            <input type="number" name="valor" placeholder="Digite o valor" step="0.01" required>
            <button type="submit" name="acao" value="depositar">Depositar</button>
            <button type="submit" name="acao" value="sacar">Sacar</button>
            <a href="index.php?acao=listar"><button type="button">Cancelar</button></a>
        </form>
    </div>
</body>
</html>
