<?php

class ContaBancaria
{
    // Atributos privados da conta (encapsulamento)
    private $numeroConta;
    private $nome;
    private $cpf;
    private $dataNascimento;
    private $saldo;
    private $limite;

    /**
     * Construtor da classe
     * Inicializa os atributos da conta bancária
     */
    public function __construct($nome, $cpf, $dataNascimento, $limite = 1000, $saldo = 0, $numeroConta = 0)
    {
        $this->numeroConta = $numeroConta;
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->dataNascimento = $dataNascimento;
        $this->saldo = $saldo;
        $this->limite = $limite;
    }

    // ===== GETTERS (métodos para acessar os atributos) =====
    
    public function getNumeroConta() { return $this->numeroConta; }
    public function getNome() { return $this->nome; }
    public function getCpf() { return $this->cpf; }
    public function getDataNascimento() { return $this->dataNascimento; }
    public function getSaldo() { return $this->saldo; }
    public function getLimite() { return $this->limite; }

    // ===== SETTERS (métodos para modificar os atributos) =====
    
    public function setNumeroConta($numeroConta) { $this->numeroConta = $numeroConta; }
    public function setNome($nome) { $this->nome = $nome; }
    public function setCpf($cpf) { $this->cpf = $cpf; }
    public function setDataNascimento($dataNascimento) { $this->dataNascimento = $dataNascimento; }
    /**
     * Realiza um depósito na conta
     * @param float $valor - Valor a ser depositado
     * @return bool - Retorna true se o depósito foi realizado com sucesso
     */
    public function depositar($valor)
    {
        if ($valor > 0) {
            $this->saldo += $valor;
            return true;
        }
        return false;
    }

    /**
     * Realiza um saque na conta
     * @param float $valor - Valor a ser sacado
     * @return bool - Retorna true se o saque foi realizado com sucesso
     */
    public function sacar($valor)
    {
        if ($valor > 0 && $valor <= $this->saldo) {
            $this->saldo -= $valor;
            return true;
        }
        return false;
    }

    /**
     * Converte o objeto para um array (útil para retornar em JSON)
     * @return array
     */
    public function toArray()
    {
        return [
            'numero_conta' => $this->numeroConta,
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'data_nascimento' => $this->dataNascimento,
            'saldo' => $this->saldo,
            'limite' => $this->limite
        ];
    }
}
