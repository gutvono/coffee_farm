-- Script SQL para criação do banco de dados Coffee Farm ERP
-- Execute este script uma única vez para criar todas as tabelas necessárias

CREATE DATABASE IF NOT EXISTS coffee_farm_erp;
USE coffee_farm_erp;

-- ============================================================
-- TABELA: deposito
-- Armazena os locais físicos onde os produtos são guardados
-- Ex: Armazém Principal, Câmara Fria, Galpão 2
-- ============================================================
CREATE TABLE deposito (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(100) NOT NULL,
    localizacao VARCHAR(255),
    ativo      TINYINT(1) NOT NULL DEFAULT 1  -- 1 = ativo, 0 = inativo
);

-- ============================================================
-- TABELA: produto
-- Armazena os produtos e insumos gerenciados pelo estoque
-- tipo: PRODUTO = café e derivados | INSUMO = fertilizante, embalagem, etc.
-- ============================================================
CREATE TABLE produto (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    nome          VARCHAR(100) NOT NULL,
    descricao     TEXT,
    tipo          ENUM('PRODUTO', 'INSUMO') NOT NULL DEFAULT 'PRODUTO',
    unidade       VARCHAR(20) NOT NULL DEFAULT 'kg',  -- Ex: kg, saca, unidade
    preco         DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    ativo         TINYINT(1) NOT NULL DEFAULT 1,       -- 1 = ativo, 0 = inativo
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- TABELA: estoque
-- Registra o saldo atual de cada produto por depósito
-- Um produto pode ter saldo em múltiplos depósitos
-- ============================================================
CREATE TABLE estoque (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    id_produto  INT NOT NULL,
    id_deposito INT NOT NULL,
    quantidade  DECIMAL(10,2) NOT NULL DEFAULT 0,
    FOREIGN KEY (id_produto)  REFERENCES produto(id)  ON DELETE CASCADE,
    FOREIGN KEY (id_deposito) REFERENCES deposito(id) ON DELETE CASCADE
);

-- ============================================================
-- TABELA: movimentacao_estoque
-- Histórico de todas as movimentações de estoque
-- tipo:
--   ENTRADA      = recebimento de produtos (compra, colheita)
--   SAIDA        = saída de produtos (venda, consumo)
--   AJUSTE       = correção manual de saldo
--   TRANSFERENCIA = movimentação entre depósitos
-- ============================================================
CREATE TABLE movimentacao_estoque (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    id_produto       INT NOT NULL,
    tipo             ENUM('ENTRADA', 'SAIDA', 'AJUSTE', 'TRANSFERENCIA') NOT NULL,
    quantidade       DECIMAL(10,2) NOT NULL,
    motivo           VARCHAR(255),
    data_movimentacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produto) REFERENCES produto(id) ON DELETE CASCADE
);

-- ============================================================
-- TABELA: cliente
-- ============================================================
CREATE TABLE cliente (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    nome          VARCHAR(100) NOT NULL,
    endereco      VARCHAR(255),
    telefone      VARCHAR(20),
    email         VARCHAR(100),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- TABELA: fornecedor
-- ============================================================
CREATE TABLE fornecedor (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    nome          VARCHAR(100) NOT NULL,
    endereco      VARCHAR(255),
    telefone      VARCHAR(20),
    email         VARCHAR(100),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- TABELA: pedido_compra / pedido_compra_item
-- ============================================================
CREATE TABLE pedido_compra (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    id_fornecedor  INT NOT NULL,
    data_pedido    DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_entrega   DATE,
    status         ENUM('pendente', 'aprovado', 'entregue', 'cancelado') DEFAULT 'pendente',
    valor_total    DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (id_fornecedor) REFERENCES fornecedor(id) ON DELETE CASCADE
);

CREATE TABLE pedido_compra_item (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido_compra INT NOT NULL,
    id_produto       INT NOT NULL,
    quantidade       DECIMAL(10,2) NOT NULL,
    preco_unitario   DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pedido_compra) REFERENCES pedido_compra(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produto)       REFERENCES produto(id)       ON DELETE CASCADE
);

-- ============================================================
-- TABELA: pedido_venda / pedido_venda_item
-- ============================================================
CREATE TABLE pedido_venda (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente    INT NOT NULL,
    data_pedido   DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_entrega  DATE,
    status        ENUM('pendente', 'aprovado', 'entregue', 'cancelado') DEFAULT 'pendente',
    valor_total   DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (id_cliente) REFERENCES cliente(id) ON DELETE CASCADE
);

CREATE TABLE pedido_venda_item (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido_venda INT NOT NULL,
    id_produto      INT NOT NULL,
    quantidade      DECIMAL(10,2) NOT NULL,
    preco_unitario  DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_pedido_venda) REFERENCES pedido_venda(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produto)      REFERENCES produto(id)      ON DELETE CASCADE
);

-- ============================================================
-- TABELA: conta_receber / conta_pagar
-- ============================================================
CREATE TABLE conta_receber (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido_venda INT NOT NULL,
    valor           DECIMAL(10,2) NOT NULL,
    data_vencimento DATE NOT NULL,
    data_pagamento  DATE,
    status          ENUM('pendente', 'pago', 'atrasado') DEFAULT 'pendente',
    FOREIGN KEY (id_pedido_venda) REFERENCES pedido_venda(id) ON DELETE CASCADE
);

CREATE TABLE conta_pagar (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido_compra INT NOT NULL,
    valor            DECIMAL(10,2) NOT NULL,
    data_vencimento  DATE NOT NULL,
    data_pagamento   DATE,
    status           ENUM('pendente', 'pago', 'atrasado') DEFAULT 'pendente',
    FOREIGN KEY (id_pedido_compra) REFERENCES pedido_compra(id) ON DELETE CASCADE
);

-- ============================================================
-- TABELA: area_plantio / ordem_producao / colheita  (módulo PCP)
-- ============================================================
CREATE TABLE area_plantio (
    id           INT AUTO_INCREMENT PRIMARY KEY,
    nome         VARCHAR(100) NOT NULL,
    tamanho      DECIMAL(10,2),  -- em hectares
    localizacao  VARCHAR(255),
    tipo_solo    VARCHAR(50),
    data_plantio DATE
);

CREATE TABLE ordem_producao (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    id_area             INT NOT NULL,
    data_inicio         DATE NOT NULL,
    data_fim            DATE,
    status              ENUM('planejada', 'em_andamento', 'concluida', 'cancelada') DEFAULT 'planejada',
    quantidade_estimada DECIMAL(10,2),
    FOREIGN KEY (id_area) REFERENCES area_plantio(id) ON DELETE CASCADE
);

CREATE TABLE colheita (
    id                 INT AUTO_INCREMENT PRIMARY KEY,
    id_ordem_producao  INT NOT NULL,
    quantidade         DECIMAL(10,2) NOT NULL,
    data_colheita      DATE NOT NULL,
    qualidade          VARCHAR(50),  -- Ex: premium, standard
    FOREIGN KEY (id_ordem_producao) REFERENCES ordem_producao(id) ON DELETE CASCADE
);

-- ============================================================
-- TABELA: funcionario / folha_pagamento  (módulo Folha)
-- ============================================================
CREATE TABLE funcionario (
    id             INT AUTO_INCREMENT PRIMARY KEY,
    nome           VARCHAR(100) NOT NULL,
    cargo          VARCHAR(50),
    salario        DECIMAL(10,2),
    data_admissao  DATE,
    telefone       VARCHAR(20),
    endereco       VARCHAR(255)
);

CREATE TABLE folha_pagamento (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    id_funcionario  INT NOT NULL,
    mes             INT NOT NULL,  -- 1 a 12
    ano             INT NOT NULL,
    salario_bruto   DECIMAL(10,2) NOT NULL,
    descontos       DECIMAL(10,2) DEFAULT 0,
    salario_liquido DECIMAL(10,2) NOT NULL,
    data_pagamento  DATE,
    FOREIGN KEY (id_funcionario) REFERENCES funcionario(id) ON DELETE CASCADE
);

-- ============================================================
-- TABELA: ativo  (módulo Financeiro)
-- ============================================================
CREATE TABLE ativo (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    nome             VARCHAR(100) NOT NULL,
    descricao        TEXT,
    valor            DECIMAL(10,2) NOT NULL,
    data_aquisicao   DATE NOT NULL,
    vida_util_anos   INT,
    depreciacao_anual DECIMAL(10,2)
);
