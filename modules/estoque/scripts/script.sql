-- =============================================================================
-- Script  : script.sql
-- Módulo  : Estoque
-- Banco   : coffee_farm_erp
-- -----------------------------------------------------------------------------
-- Este script cria as tabelas necessárias para o funcionamento do módulo de
-- estoque. Execute-o uma única vez no banco de dados coffee_farm_erp antes
-- de usar o sistema.
--
-- Tabelas criadas:
--   1. produto           → cadastro dos produtos gerenciados pelo estoque
--   2. estoque           → saldo atual de cada produto no depósito
--   3. movimentacao_estoque → histórico de todas as entradas e saídas
--
-- Ordem de criação importa! Tabelas com chaves estrangeiras (estoque e
-- movimentacao_estoque) devem ser criadas depois da tabela pai (produto).
-- =============================================================================

-- Garante que estamos usando o banco correto
USE coffee_farm_erp;

-- =============================================================================
-- Tabela: produto
-- Armazena o cadastro de todos os produtos que podem estar em estoque.
-- Exemplos: "Saca de Café Arábica", "Fertilizante NPK", "Embalagem 1kg".
-- Esta tabela é usada como referência (chave estrangeira) pelas demais.
-- =============================================================================
CREATE TABLE IF NOT EXISTS produto (
    id          INT AUTO_INCREMENT PRIMARY KEY,   -- identificador único do produto
    nome        VARCHAR(150) NOT NULL,            -- nome do produto (obrigatório)
    descricao   TEXT,                             -- descrição detalhada (opcional)
    unidade     VARCHAR(20)  NOT NULL DEFAULT 'un', -- unidade de medida (ex.: kg, saca, litro)
    criado_em   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP -- data de cadastro
);

-- =============================================================================
-- Tabela: estoque
-- Registra o SALDO ATUAL de cada produto no depósito.
-- Cada produto deve ter exatamente uma linha nesta tabela.
-- A quantidade aqui é sempre o resultado acumulado de todas as entradas
-- menos todas as saídas registradas em movimentacao_estoque.
--
-- ATENÇÃO: nunca atualize esta tabela diretamente via SQL manual.
--          Use sempre o EstoqueService para garantir consistência.
-- =============================================================================
CREATE TABLE IF NOT EXISTS estoque (
    id          INT AUTO_INCREMENT PRIMARY KEY,   -- identificador do registro de estoque
    id_produto  INT           NOT NULL UNIQUE,    -- um produto tem apenas um saldo (UNIQUE)
    quantidade  DECIMAL(10,3) NOT NULL DEFAULT 0, -- saldo atual (aceita decimais, ex.: 2.5 sacas)
    localizacao VARCHAR(100),                     -- local físico no depósito (ex.: "Galpão A - Prateleira 3")
    atualizado_em TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Chave estrangeira: garante que o produto existe antes de criar o saldo
    CONSTRAINT fk_estoque_produto
        FOREIGN KEY (id_produto) REFERENCES produto(id)
        ON DELETE RESTRICT   -- impede exclusão de produto com saldo em estoque
        ON UPDATE CASCADE    -- atualiza referência se o id do produto mudar
);

-- =============================================================================
-- Tabela: movimentacao_estoque
-- Registra o HISTÓRICO de todas as entradas e saídas do estoque.
-- Cada linha representa uma movimentação (uma entrada ou uma saída).
-- Este histórico nunca deve ser apagado — serve como trilha de auditoria.
-- =============================================================================
CREATE TABLE IF NOT EXISTS movimentacao_estoque (
    id          INT AUTO_INCREMENT PRIMARY KEY,   -- identificador da movimentação
    id_produto  INT           NOT NULL,           -- produto movimentado
    tipo        ENUM('entrada', 'saida') NOT NULL, -- direção da movimentação
    quantidade  DECIMAL(10,3) NOT NULL,           -- quantidade movimentada (sempre positivo)
    motivo      VARCHAR(255),                     -- motivo ou observação (ex.: "Compra NF 1234")
    criado_em   TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP, -- data/hora da movimentação

    -- Chave estrangeira: garante que o produto existe
    CONSTRAINT fk_movimentacao_produto
        FOREIGN KEY (id_produto) REFERENCES produto(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);
