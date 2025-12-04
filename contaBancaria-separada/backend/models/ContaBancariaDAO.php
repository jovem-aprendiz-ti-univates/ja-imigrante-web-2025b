<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/ContaBancaria.php';

class ContaBancariaDAO
{
    private $conexao;

    /**
     * Construtor - Inicializa a conexão com o banco
     */
    public function __construct()
    {
        $db = new Database();
        $this->conexao = $db->getConnection();
    }

    /**
     * Lista todas as contas do banco de dados
     * @return array - Array de objetos ContaBancaria
     */
    public function listarTodas()
    {
        $sql = "SELECT * FROM contas ORDER BY numero_conta";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        $linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $contas = [];

        foreach ($linhas as $linha) {
            $contas[] = $this->linhaParaObjeto($linha);
        }

        return $contas;
    }

    /**
     * Busca uma conta pelo número
     * @param int $numeroConta - Número da conta
     * @return ContaBancaria|null - Retorna a conta ou null se não encontrar
     */
    public function buscarPorNumero($numeroConta)
    {
        $sql = "SELECT * FROM contas WHERE numero_conta = ?";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([$numeroConta]);

        $linha = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($linha) {
            return $this->linhaParaObjeto($linha);
        }
        return null;
    }

    /**
     * Insere uma nova conta no banco de dados
     * @param ContaBancaria $conta - Objeto conta a ser inserido
     * @return int - Retorna o ID da conta inserida
     */
    public function inserir(ContaBancaria $conta)
    {
        $sql = "INSERT INTO contas (nome, cpf, data_nascimento, saldo, limite) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute([
            $conta->getNome(),
            $conta->getCpf(),
            $conta->getDataNascimento(),
            $conta->getSaldo(),
            $conta->getLimite()
        ]);

        return $this->conexao->lastInsertId();
    }

    /**
     * Atualiza os dados de uma conta existente
     * @param ContaBancaria $conta - Objeto conta com os dados atualizados
     * @return bool - Retorna true se a atualização foi bem-sucedida
     */
    public function atualizar(ContaBancaria $conta)
    {
        $sql = "UPDATE contas SET nome = ?, cpf = ?, data_nascimento = ? WHERE numero_conta = ?";
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([
            $conta->getNome(),
            $conta->getCpf(),
            $conta->getDataNascimento(),
            $conta->getNumeroConta()
        ]);
    }

    /**
     * Atualiza apenas o saldo de uma conta
     * @param int $numeroConta - Número da conta
     * @param float $novoSaldo - Novo valor do saldo
     * @return bool
     */
    public function atualizarSaldo($numeroConta, $novoSaldo)
    {
        $sql = "UPDATE contas SET saldo = ? WHERE numero_conta = ?";
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([$novoSaldo, $numeroConta]);
    }

    /**
     * Exclui uma conta do banco de dados
     * @param int $numeroConta - Número da conta a ser excluída
     * @return bool - Retorna true se a exclusão foi bem-sucedida
     */
    public function excluir($numeroConta)
    {
        $sql = "DELETE FROM contas WHERE numero_conta = ?";
        $stmt = $this->conexao->prepare($sql);
        return $stmt->execute([$numeroConta]);
    }

    /**
     * Converte uma linha do banco de dados em um objeto ContaBancaria
     * @param array $linha - Linha do banco de dados
     * @return ContaBancaria
     */
    private function linhaParaObjeto($linha)
    {
        return new ContaBancaria(
            $linha['nome'],
            $linha['cpf'],
            $linha['data_nascimento'],
            $linha['limite'],
            $linha['saldo'],
            $linha['numero_conta']
        );
    }
}
