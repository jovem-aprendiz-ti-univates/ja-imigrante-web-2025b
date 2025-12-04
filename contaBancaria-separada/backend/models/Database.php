<?php
class Database
{
    private $connection;

    /**
     * Construtor - Estabelece a conexão com o banco de dados
     */
    public function __construct()
    {
        // Pega as configurações do ambiente ou usa valores padrão
        $host = getenv('DB_HOST') ?: 'postgres';
        $dbname = getenv('DB_NAME') ?: 'banco';
        $username = getenv('DB_USER') ?: 'postgres';
        $password = getenv('DB_PASS') ?: 'postgres';
        $port = getenv('DB_PORT') ?: '5432';

        // Cria a string de conexão (DSN)
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        
        // Cria a conexão PDO
        $this->connection = new PDO($dsn, $username, $password);
        
        // Configura para lançar exceções em caso de erro
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Retorna a conexão com o banco de dados
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Fecha a conexão com o banco de dados
     */
    public function closeConnection()
    {
        $this->connection = null;
    }
}
