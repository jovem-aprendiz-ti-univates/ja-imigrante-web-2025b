-- Criação da tabela contas
CREATE TABLE IF NOT EXISTS contas (
    numero_conta SERIAL PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    cpf VARCHAR(11) NOT NULL,
    data_nascimento DATE NOT NULL,
    saldo DECIMAL(10, 2) DEFAULT 0,
    limite DECIMAL(10, 2) DEFAULT 1000
);

-- Inserir alguns dados de exemplo (opcional)
INSERT INTO contas (nome, cpf, data_nascimento, saldo, limite) VALUES
('João Silva', '12345678901', '1990-05-15', 1000.00, 1000.00),
('Maria Santos', '98765432109', '1985-08-22', 2500.50, 1000.00);
