<?php

require_once 'Database.php';

class ContaBancaria
{
    private $numeroConta;
    private $saldo;
    private $nome;
    private $limite;
    private $cpf;
    private $dataNascimento;
    private $conexao;

    public function __construct($nome, $cpf, $dataNascimento, $limite = 1000, $saldo = 0, $numeroConta = 0)
    {
        $this->numeroConta = $numeroConta;
        $this->saldo = $saldo;
        $this->nome = $nome;
        $this->limite = $limite;
        $this->cpf = $cpf;
        $this->dataNascimento = $dataNascimento;
    }

    public function inserirNovaConta()
    {
        $conexaoTmp = new Database();
        $this->conexao = $conexaoTmp->getConnection();
        $sql = "INSERT INTO contas (nome, saldo, cpf, limite, data_nascimento) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$this->nome, $this->saldo, $this->cpf, $this->limite, $this->dataNascimento]);
        $conexaoTmp->closeConnection();
    }

    public function atualizar()
    {
        $conexaoTmp = new Database();
        $this->conexao = $conexaoTmp->getConnection();
        $sql = "UPDATE contas SET nome = ?, cpf = ?, data_nascimento = ? WHERE numero_conta = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$this->nome, $this->cpf, $this->dataNascimento, $this->numeroConta]);
        $conexaoTmp->closeConnection();
    }

    public function excluir()
    {
        $conexaoTmp = new Database();
        $this->conexao = $conexaoTmp->getConnection();
        $sql = "DELETE FROM contas WHERE numero_conta = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$this->numeroConta]);
        $conexaoTmp->closeConnection();
    }

    public static function buscarPorNumero($numeroConta)
    {
        $conexaoTmp = new Database();
        $conexao = $conexaoTmp->getConnection();

        $sql = "SELECT * FROM contas WHERE numero_conta = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$numeroConta]);
        $linha = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $conexaoTmp->closeConnection();

        if ($linha) {
            return new ContaBancaria(
                $linha['nome'],
                $linha['cpf'],
                $linha['data_nascimento'],
                $linha['limite'],
                $linha['saldo'],
                $linha['numero_conta']
            );
        }
        return null;
    }

    public static function listarTodos()
    {
        $conexaoTmp = new Database();
        $conexao = $conexaoTmp->getConnection();

        $sql = "SELECT * FROM contas";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        $linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $conexaoTmp->closeConnection();

        $contas = [];
        for ($i = 0; $i < count($linhas); $i++) {
            $conta = new ContaBancaria(
                $linhas[$i]['nome'],
                $linhas[$i]['cpf'],
                $linhas[$i]['data_nascimento'],
                $linhas[$i]['limite'],
                $linhas[$i]['saldo'],
                $linhas[$i]['numero_conta']
            );
            $contas[] = $conta;
        }

        return $contas;
    }

    public function getNumeroConta()
    {
        return $this->numeroConta;
    }

    public function getSaldo()
    {
        return $this->saldo;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function getLimite()
    {
        return $this->limite;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getDataNascimento()
    {
        return $this->dataNascimento;
    }

    public function depositar($valor)
    {
        if ($valor > 0) {
            $this->saldo += $valor;
        }
    }

    public function sacar($valor)
    {
        if ($valor > 0) {
            if ($valor <= $this->saldo) {
                $this->saldo -= $valor;
                return true;
            }
        }
        return false;
    }
}
