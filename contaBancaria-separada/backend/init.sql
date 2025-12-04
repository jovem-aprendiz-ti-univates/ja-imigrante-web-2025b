-- Script de inicialização do banco de dados
-- Este script cria a tabela de contas e insere alguns dados de exemplo

-- Criação da tabela contas
CREATE TABLE IF NOT EXISTS contas (
    numero_conta SERIAL PRIMARY KEY,        -- Número único da conta (auto-incremento)
    nome VARCHAR(255) NOT NULL,             -- Nome do titular
    cpf VARCHAR(11) NOT NULL,               -- CPF (apenas números)
    data_nascimento DATE NOT NULL,          -- Data de nascimento
    saldo DECIMAL(10, 2) DEFAULT 0,         -- Saldo atual da conta
    limite DECIMAL(10, 2) DEFAULT 1000      -- Limite de crédito
);

-- Inserir alguns dados de exemplo
INSERT INTO contas (nome, cpf, data_nascimento, saldo, limite) VALUES
('João Silva', '12345678901', '1990-05-15', 1000.00, 1000.00),
('Maria Santos', '98765432109', '1985-08-22', 2500.50, 1000.00),
('Pedro Oliveira', '11122233344', '2000-01-10', 500.00, 1000.00);
