<?php

require_once __DIR__ . '/Database.php';

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
        foreach ($linhas as $linha) {
            $contas[] = new ContaBancaria(
                $linha['nome'],
                $linha['cpf'],
                $linha['data_nascimento'],
                $linha['limite'],
                $linha['saldo'],
                $linha['numero_conta']
            );
        }

        return $contas;
    }

    public function getNumeroConta() { return $this->numeroConta; }
    public function getSaldo() { return $this->saldo; }
    public function getNome() { return $this->nome; }
    public function getLimite() { return $this->limite; }
    public function getCpf() { return $this->cpf; }
    public function getDataNascimento() { return $this->dataNascimento; }

    public function depositar($valor)
    {
        if ($valor > 0) {
            $this->saldo += $valor;
            $this->atualizarSaldo();
            return true;
        }
        return false;
    }

    public function sacar($valor)
    {
        if ($valor > 0 && $valor <= $this->saldo) {
            $this->saldo -= $valor;
            $this->atualizarSaldo();
            return true;
        }
        return false;
    }

    private function atualizarSaldo()
    {
        $conexaoTmp = new Database();
        $this->conexao = $conexaoTmp->getConnection();
        $sql = "UPDATE contas SET saldo = ? WHERE numero_conta = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$this->saldo, $this->numeroConta]);
        $conexaoTmp->closeConnection();
    }
}
