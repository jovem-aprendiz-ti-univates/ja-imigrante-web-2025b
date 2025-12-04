/**
 * api.js - Funções para comunicar com a API (backend)
 * 
 * Este arquivo contém todas as funções que fazem requisições
 * para o servidor backend usando fetch().
 */

// URL base da API
const API_URL = 'http://localhost:8080/api/';

/**
 * Lista todas as contas
 * @returns {Array} - Array com todas as contas
 */
async function listarContas() {
    try {
        const resposta = await fetch(API_URL);
        const dados = await resposta.json();

        if (dados.sucesso) {
            return dados.dados;
        }
        return [];
    } catch (erro) {
        console.error('Erro ao listar contas:', erro);
        return [];
    }
}

/**
 * Busca uma conta pelo número
 * @param {number} id - Número da conta
 * @returns {Object|null} - Dados da conta ou null
 */
async function buscarConta(id) {
    try {
        const resposta = await fetch(API_URL + '?id=' + id);
        const dados = await resposta.json();

        if (dados.sucesso) {
            return dados.dados;
        }
        return null;
    } catch (erro) {
        console.error('Erro ao buscar conta:', erro);
        return null;
    }
}

/**
 * Cria uma nova conta
 * @param {string} nome - Nome do titular
 * @param {string} cpf - CPF do titular
 * @param {string} dataNascimento - Data de nascimento
 * @returns {boolean} - true se criou, false se deu erro
 */
async function criarConta(nome, cpf, dataNascimento) {
    try {
        const resposta = await fetch(API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                nome: nome,
                cpf: cpf,
                data_nascimento: dataNascimento
            })
        });

        const dados = await resposta.json();
        return dados.sucesso;
    } catch (erro) {
        console.error('Erro ao criar conta:', erro);
        return false;
    }
}

/**
 * Atualiza uma conta existente
 * @param {number} id - Número da conta
 * @param {string} nome - Nome do titular
 * @param {string} cpf - CPF do titular
 * @param {string} dataNascimento - Data de nascimento
 * @returns {boolean} - true se atualizou, false se deu erro
 */
async function atualizarConta(id, nome, cpf, dataNascimento) {
    try {
        const resposta = await fetch(API_URL + '?id=' + id, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                nome: nome,
                cpf: cpf,
                data_nascimento: dataNascimento
            })
        });

        const dados = await resposta.json();
        return dados.sucesso;
    } catch (erro) {
        console.error('Erro ao atualizar conta:', erro);
        return false;
    }
}

/**
 * Exclui uma conta
 * @param {number} id - Número da conta
 * @returns {boolean} - true se excluiu, false se deu erro
 */
async function excluirConta(id) {
    try {
        const resposta = await fetch(API_URL + '?id=' + id, {
            method: 'DELETE'
        });

        const dados = await resposta.json();
        return dados.sucesso;
    } catch (erro) {
        console.error('Erro ao excluir conta:', erro);
        return false;
    }
}

/**
 * Faz um depósito na conta
 * @param {number} id - Número da conta
 * @param {number} valor - Valor a depositar
 * @returns {Object} - { sucesso: boolean, saldo: number, mensagem: string }
 */
async function depositar(id, valor) {
    try {
        const resposta = await fetch(API_URL + '?acao=depositar&id=' + id, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ valor: valor })
        });

        const dados = await resposta.json();
        return dados;
    } catch (erro) {
        console.error('Erro ao depositar:', erro);
        return { sucesso: false, mensagem: 'Erro de conexão' };
    }
}

/**
 * Faz um saque na conta
 * @param {number} id - Número da conta
 * @param {number} valor - Valor a sacar
 * @returns {Object} - { sucesso: boolean, saldo: number, mensagem: string }
 */
async function sacar(id, valor) {
    try {
        const resposta = await fetch(API_URL + '?acao=sacar&id=' + id, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ valor: valor })
        });

        const dados = await resposta.json();
        return dados;
    } catch (erro) {
        console.error('Erro ao sacar:', erro);
        return { sucesso: false, mensagem: 'Erro de conexão' };
    }
}
