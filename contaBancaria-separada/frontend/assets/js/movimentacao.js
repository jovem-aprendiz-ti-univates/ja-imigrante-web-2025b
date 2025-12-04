const params = new URLSearchParams(window.location.search);
const id = params.get('id');

carregarDadosConta();

async function carregarDadosConta() {
    if (!id) {
        window.location.href = 'listagem.html';
        return;
    }

    const conta = await buscarConta(id);

    if (conta) {
        document.getElementById('numeroConta').value = conta.numero_conta;
        document.getElementById('nomeConta').textContent = conta.nome;
        document.getElementById('saldoConta').textContent = formatarMoeda(conta.saldo);
    } else {
        window.location.href = 'listagem.html';
    }
}

async function fazerDeposito() {
    const numeroConta = document.getElementById('numeroConta').value;
    const valor = document.getElementById('valor').value;

    if (!valor || valor <= 0) {
        return;
    }

    const resultado = await depositar(numeroConta, parseFloat(valor));

    if (resultado.sucesso) {
        document.getElementById('saldoConta').textContent = formatarMoeda(resultado.saldo);
        document.getElementById('valor').value = '';
    }
}

async function fazerSaque() {
    const numeroConta = document.getElementById('numeroConta').value;
    const valor = document.getElementById('valor').value;

    if (!valor || valor <= 0) {
        return;
    }

    const resultado = await sacar(numeroConta, parseFloat(valor));

    if (resultado.sucesso) {
        document.getElementById('saldoConta').textContent = formatarMoeda(resultado.saldo);
        document.getElementById('valor').value = '';
    }
}

function formatarMoeda(valor) {
    return parseFloat(valor).toFixed(2).replace('.', ',');
}
