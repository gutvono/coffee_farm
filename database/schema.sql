-- Script SQL para criação do banco de dados Coffee Farm ERP
-- Este script cria o banco de dados e todas as tabelas necessárias para o sistema ERP de uma fazenda de café arábica

-- Criar o banco de dados se não existir
CREATE DATABASE IF NOT EXISTS coffee_farm_erp;

-- Usar o banco de dados
USE coffee_farm_erp;

-- Tabela: produto
-- Armazena informações sobre os produtos (café e outros itens)
CREATE TABLE produto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    unidade VARCHAR(20) DEFAULT 'kg',  -- Ex: kg, saca, unidade
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela: cliente
-- Armazena dados dos clientes que compram o café
CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(255),
    telefone VARCHAR(20),
    email VARCHAR(100),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela: fornecedor
-- Armazena dados dos fornecedores de insumos ou outros produtos
CREATE TABLE fornecedor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(255),
    telefone VARCHAR(20),
    email VARCHAR(100),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela: estoque
-- Controla o estoque atual de cada produto
CREATE TABLE estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT NOT NULL,
    quantidade DECIMAL(10,2) NOT NULL DEFAULT 0,
    localizacao VARCHAR(50),  -- Ex: armazém 1, prateleira A
    FOREIGN KEY (id_produto) REFERENCES produto(id) ON DELETE CASCADE
);

-- Tabela: movimentacao_estoque
-- Registra entradas e saídas do estoque
CREATE TABLE movimentacao_estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT NOT NULL,
    tipo ENUM('entrada', 'saida') NOT NULL,
    quantidade DECIMAL(10,2) NOT NULL,
    data_movimentacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    motivo VARCHAR(255),  -- Ex: compra, venda, perda
    FOREIGN KEY (id_produto) REFERENCES produto(id) ON DELETE CASCADE
);

-- Tabela: pedido_compra
-- Registra pedidos de compra feitos aos fornecedores
CREATE TABLE pedido_compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_fornecedor INT NOT NULL,
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_entrega DATE,
    status ENUM('pendente', 'aprovado', 'entregue', 'cancelado') DEFAULT 'pendente',
    valor_total DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (id_fornecedor) REFERENCES fornecedor(id) ON DELETE CASCADE
);

-- Tabela: pedido_compra_item
-- Itens de cada pedido de compra
CREATE TABLE pedido_compra_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido_compra INT NOT NULL,
    id_produto INT NOT NULL,
    quantidade DECIMAL(10,2) NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pedido_compra) REFERENCES pedido_compra(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produto) REFERENCES produto(id) ON DELETE CASCADE
);

-- Tabela: pedido_venda
-- Registra pedidos de venda feitos aos clientes
CREATE TABLE pedido_venda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_entrega DATE,
    status ENUM('pendente', 'aprovado', 'entregue', 'cancelado') DEFAULT 'pendente',
    valor_total DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (id_cliente) REFERENCES cliente(id) ON DELETE CASCADE
);

-- Tabela: pedido_venda_item
-- Itens de cada pedido de venda
CREATE TABLE pedido_venda_item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido_venda INT NOT NULL,
    id_produto INT NOT NULL,
    quantidade DECIMAL(10,2) NOT NULL,
    preco_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pedido_venda) REFERENCES pedido_venda(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produto) REFERENCES produto(id) ON DELETE CASCADE
);

-- Tabela: conta_receber
-- Contas a receber (faturas de vendas)
CREATE TABLE conta_receber (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido_venda INT NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    data_vencimento DATE NOT NULL,
    data_pagamento DATE,
    status ENUM('pendente', 'pago', 'atrasado') DEFAULT 'pendente',
    FOREIGN KEY (id_pedido_venda) REFERENCES pedido_venda(id) ON DELETE CASCADE
);

-- Tabela: conta_pagar
-- Contas a pagar (faturas de compras)
CREATE TABLE conta_pagar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido_compra INT NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    data_vencimento DATE NOT NULL,
    data_pagamento DATE,
    status ENUM('pendente', 'pago', 'atrasado') DEFAULT 'pendente',
    FOREIGN KEY (id_pedido_compra) REFERENCES pedido_compra(id) ON DELETE CASCADE
);

-- Tabela: area_plantio
-- Áreas de plantio de café na fazenda
CREATE TABLE area_plantio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    tamanho DECIMAL(10,2),  -- Em hectares
    localizacao VARCHAR(255),
    tipo_solo VARCHAR(50),
    data_plantio DATE
);

-- Tabela: ordem_producao
-- Ordens de produção para colheita
CREATE TABLE ordem_producao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_area INT NOT NULL,
    data_inicio DATE NOT NULL,
    data_fim DATE,
    status ENUM('planejada', 'em_andamento', 'concluida', 'cancelada') DEFAULT 'planejada',
    quantidade_estimada DECIMAL(10,2),
    FOREIGN KEY (id_area) REFERENCES area_plantio(id) ON DELETE CASCADE
);

-- Tabela: colheita
-- Registros de colheitas realizadas
CREATE TABLE colheita (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_ordem_producao INT NOT NULL,
    quantidade DECIMAL(10,2) NOT NULL,
    data_colheita DATE NOT NULL,
    qualidade VARCHAR(50),  -- Ex: premium, standard
    FOREIGN KEY (id_ordem_producao) REFERENCES ordem_producao(id) ON DELETE CASCADE
);

-- Tabela: funcionario
-- Dados dos funcionários da fazenda
CREATE TABLE funcionario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cargo VARCHAR(50),
    salario DECIMAL(10,2),
    data_admissao DATE,
    telefone VARCHAR(20),
    endereco VARCHAR(255)
);

-- Tabela: folha_pagamento
-- Registros de folha de pagamento mensal
CREATE TABLE folha_pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_funcionario INT NOT NULL,
    mes INT NOT NULL,  -- 1-12
    ano INT NOT NULL,
    salario_bruto DECIMAL(10,2) NOT NULL,
    descontos DECIMAL(10,2) DEFAULT 0,
    salario_liquido DECIMAL(10,2) NOT NULL,
    data_pagamento DATE,
    FOREIGN KEY (id_funcionario) REFERENCES funcionario(id) ON DELETE CASCADE
);

-- Tabela: ativo
-- Ativos da fazenda (máquinas, equipamentos, etc.)
CREATE TABLE ativo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    valor DECIMAL(10,2) NOT NULL,
    data_aquisicao DATE NOT NULL,
    vida_util_anos INT,
    depreciacao_anual DECIMAL(10,2)
);