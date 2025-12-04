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
        document.getElementById('nome').value = conta.nome;
        document.getElementById('cpf').value = conta.cpf;
        document.getElementById('data').value = conta.data_nascimento;
    } else {
        window.location.href = 'listagem.html';
    }
}

document.getElementById('formEditar').addEventListener('submit', async function(e) {
    e.preventDefault();

    const numeroConta = document.getElementById('numeroConta').value;
    const nome = document.getElementById('nome').value;
    const cpf = document.getElementById('cpf').value;
    const data = document.getElementById('data').value;

    const resultado = await atualizarConta(numeroConta, nome, cpf, data);

    if (resultado) {
        window.location.href = 'listagem.html';
    }
});
