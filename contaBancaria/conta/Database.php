<?php
class Database {
    private $connection;

    public function __construct() {
        $host = getenv('DB_HOST') ?: 'postgres';
        $dbname = getenv('DB_NAME') ?: 'banco';
        $username = getenv('DB_USER') ?: 'postgres';
        $password = getenv('DB_PASS') ?: 'postgres';
        $port = getenv('DB_PORT') ?: '5432';

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $this->connection = new PDO($dsn, $username, $password);
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        $this->connection = null;
    }
}