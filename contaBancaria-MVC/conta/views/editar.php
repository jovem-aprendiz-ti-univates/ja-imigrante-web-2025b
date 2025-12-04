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

            <input type="hidden" name="numero_conta" value="<?= $conta->getNumeroConta() ?>" />

            <label>Digite seu nome</label>
            <input type="text" name="nome" value="<?= $conta->getNome() ?>" required />

            <label>Digite seu CPF</label>
            <input type="text" name="cpf" maxlength="11" placeholder="Digite apenas números" value="<?= $conta->getCpf() ?>" required />

            <label>Data de Nascimento</label>
            <input type="date" name="data" value="<?= $conta->getDataNascimento() ?>" required />

            <button type="submit">Atualizar</button>
            <a href="index.php?acao=listar"><button type="button">Cancelar</button></a>
        </form>
    </div>
</body>
</html>
