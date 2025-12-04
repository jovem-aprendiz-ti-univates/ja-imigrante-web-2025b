// Carrega as contas quando a página abre
carregarContas();

async function carregarContas() {
    const contas = await listarContas();
    const tbody = document.getElementById('corpoTabela');
    const mensagemVazia = document.getElementById('mensagemVazia');

    tbody.innerHTML = '';

    if (contas.length === 0) {
        mensagemVazia.style.display = 'block';
        return;
    }

    mensagemVazia.style.display = 'none';

    contas.forEach(conta => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${conta.numero_conta}</td>
            <td>${conta.nome}</td>
            <td>${conta.cpf}</td>
            <td>${conta.data_nascimento}</td>
            <td>${conta.saldo}</td>
            <td>${conta.limite}</td>
            <td>
                <a href="movimentacao.html?id=${conta.numero_conta}">
                    <button class="roxo" type="button">Movimentar</button>
                </a>
                <a href="editar.html?id=${conta.numero_conta}">
                    <button class="amarelo" type="button">Editar</button>
                </a>
                <button type="button" onclick="confirmarExclusao(${conta.numero_conta})">Excluir</button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

async function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir esta conta?')) {
        const resultado = await excluirConta(id);
        if (resultado) {
            carregarContas();
        }
    }
}
