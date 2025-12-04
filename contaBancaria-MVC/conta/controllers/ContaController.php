<?php

require_once __DIR__ . '/../models/ContaBancaria.php';

class ContaController
{
    public function listar()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['acao']) && $_POST['acao'] === 'excluir') {
            $conta = ContaBancaria::buscarPorNumero($_POST['numero_conta']);
            $conta->excluir();
        }
        $contas = ContaBancaria::listarTodos();
        require __DIR__ . '/../views/listagem.php';
    }

    public function cadastrar()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $conta = new ContaBancaria($_POST['nome'], $_POST['cpf'], $_POST['data']);
            $conta->inserirNovaConta();
            header("Location: index.php?acao=listar");
            exit();
        }
        require __DIR__ . '/../views/cadastrar.php';
    }

    public function editar()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $conta = new ContaBancaria($_POST['nome'], $_POST['cpf'], $_POST['data'], 1000, 0, $_POST['numero_conta']);
            $conta->atualizar();
            header("Location: index.php?acao=listar");
            exit();
        }

        $conta = ContaBancaria::buscarPorNumero($_GET['id']);
        require __DIR__ . '/../views/editar.php';
    }

    public function movimentar()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $conta = ContaBancaria::buscarPorNumero($_POST['numero_conta']);
            if ($_POST['acao'] === 'depositar') {
                $conta->depositar($_POST['valor']);
            } else {
                $conta->sacar($_POST['valor']);
            }
            $conta = ContaBancaria::buscarPorNumero($_POST['numero_conta']);
        }

        if (isset($_GET['id']) && !isset($conta)) {
            $conta = ContaBancaria::buscarPorNumero($_GET['id']);
        }
        require __DIR__ . '/../views/movimentacao.php';
    }
}
