document.getElementById('formCadastro').addEventListener('submit', async function(e) {
    e.preventDefault();

    const nome = document.getElementById('nome').value;
    const cpf = document.getElementById('cpf').value;
    const data = document.getElementById('data').value;

    const resultado = await criarConta(nome, cpf, data);

    if (resultado) {
        window.location.href = 'listagem.html';
    }
});
