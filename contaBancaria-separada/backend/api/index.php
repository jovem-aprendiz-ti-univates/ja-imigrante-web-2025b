<?php
/**
 * API REST para Conta Bancária
 * 
 * Este arquivo é o ponto de entrada da API.
 * Recebe as requisições HTTP e direciona para as ações corretas.
 * 
 * Endpoints disponíveis:
 * GET    /api/             - Lista todas as contas
 * GET    /api/?id=X        - Busca uma conta específica
 * POST   /api/             - Cria uma nova conta
 * PUT    /api/?id=X        - Atualiza uma conta
 * DELETE /api/?id=X        - Exclui uma conta
 * POST   /api/?acao=depositar&id=X  - Faz um depósito
 * POST   /api/?acao=sacar&id=X      - Faz um saque
 */

// Permite requisições de qualquer origem (CORS)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

// Se for uma requisição OPTIONS (preflight), retorna apenas os headers
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Inclui as classes necessárias
require_once __DIR__ . '/../models/ContaBancariaDAO.php';

// Cria uma instância do DAO (Data Access Object)
$dao = new ContaBancariaDAO();

// Pega o método HTTP da requisição (GET, POST, PUT, DELETE)
$metodo = $_SERVER['REQUEST_METHOD'];

// Pega o ID da conta (se fornecido)
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

// Pega a ação especial (depositar ou sacar)
$acao = isset($_GET['acao']) ? $_GET['acao'] : null;

// Pega os dados enviados no corpo da requisição (para POST e PUT)
$dados = json_decode(file_get_contents('php://input'), true);

try {
    switch ($metodo) {
        // ===== GET - Buscar contas =====
        case 'GET':
            if ($id) {
                // Busca uma conta específica
                $conta = $dao->buscarPorNumero($id);
                if ($conta) {
                    echo json_encode(['sucesso' => true, 'dados' => $conta->toArray()]);
                } else {
                    http_response_code(404);
                    echo json_encode(['sucesso' => false, 'mensagem' => 'Conta não encontrada']);
                }
            } else {
                // Lista todas as contas
                $contas = $dao->listarTodas();
                $resultado = [];
                foreach ($contas as $conta) {
                    $resultado[] = $conta->toArray();
                }
                echo json_encode(['sucesso' => true, 'dados' => $resultado]);
            }
            break;

        // ===== POST - Criar conta ou fazer movimentação =====
        case 'POST':
            // Verifica se é uma ação de depósito ou saque
            if ($acao === 'depositar' && $id) {
                $conta = $dao->buscarPorNumero($id);
                if ($conta && isset($dados['valor'])) {
                    $valor = floatval($dados['valor']);
                    if ($conta->depositar($valor)) {
                        $dao->atualizarSaldo($id, $conta->getSaldo());
                        echo json_encode(['sucesso' => true, 'mensagem' => 'Depósito realizado', 'saldo' => $conta->getSaldo()]);
                    } else {
                        http_response_code(400);
                        echo json_encode(['sucesso' => false, 'mensagem' => 'Valor inválido para depósito']);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['sucesso' => false, 'mensagem' => 'Conta não encontrada ou valor não informado']);
                }
            } elseif ($acao === 'sacar' && $id) {
                $conta = $dao->buscarPorNumero($id);
                if ($conta && isset($dados['valor'])) {
                    $valor = floatval($dados['valor']);
                    if ($conta->sacar($valor)) {
                        $dao->atualizarSaldo($id, $conta->getSaldo());
                        echo json_encode(['sucesso' => true, 'mensagem' => 'Saque realizado', 'saldo' => $conta->getSaldo()]);
                    } else {
                        http_response_code(400);
                        echo json_encode(['sucesso' => false, 'mensagem' => 'Saldo insuficiente ou valor inválido']);
                    }
                } else {
                    http_response_code(400);
                    echo json_encode(['sucesso' => false, 'mensagem' => 'Conta não encontrada ou valor não informado']);
                }
            } else {
                // Cria uma nova conta
                if (isset($dados['nome']) && isset($dados['cpf']) && isset($dados['data_nascimento'])) {
                    $conta = new ContaBancaria(
                        $dados['nome'],
                        $dados['cpf'],
                        $dados['data_nascimento']
                    );
                    $novoId = $dao->inserir($conta);
                    http_response_code(201);
                    echo json_encode(['sucesso' => true, 'mensagem' => 'Conta criada', 'id' => $novoId]);
                } else {
                    http_response_code(400);
                    echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos. Informe: nome, cpf, data_nascimento']);
                }
            }
            break;

        // ===== PUT - Atualizar conta =====
        case 'PUT':
            if ($id && $dados) {
                $conta = $dao->buscarPorNumero($id);
                if ($conta) {
                    // Atualiza os dados da conta
                    if (isset($dados['nome'])) $conta->setNome($dados['nome']);
                    if (isset($dados['cpf'])) $conta->setCpf($dados['cpf']);
                    if (isset($dados['data_nascimento'])) $conta->setDataNascimento($dados['data_nascimento']);
                    
                    $dao->atualizar($conta);
                    echo json_encode(['sucesso' => true, 'mensagem' => 'Conta atualizada']);
                } else {
                    http_response_code(404);
                    echo json_encode(['sucesso' => false, 'mensagem' => 'Conta não encontrada']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['sucesso' => false, 'mensagem' => 'ID e dados são obrigatórios']);
            }
            break;

        // ===== DELETE - Excluir conta =====
        case 'DELETE':
            if ($id) {
                $conta = $dao->buscarPorNumero($id);
                if ($conta) {
                    $dao->excluir($id);
                    echo json_encode(['sucesso' => true, 'mensagem' => 'Conta excluída']);
                } else {
                    http_response_code(404);
                    echo json_encode(['sucesso' => false, 'mensagem' => 'Conta não encontrada']);
                }
            } else {
                http_response_code(400);
                echo json_encode(['sucesso' => false, 'mensagem' => 'ID é obrigatório']);
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Método não permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro interno: ' . $e->getMessage()]);
}
