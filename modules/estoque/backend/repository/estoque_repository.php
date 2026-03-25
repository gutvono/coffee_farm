<?php
// =============================================================================
// Arquivo  : estoque_repository.php
// Camada   : Repository
// Módulo   : Estoque
// -----------------------------------------------------------------------------
// O REPOSITORY é a única parte do sistema que fala diretamente com o banco de
// dados. Ele contém as queries SQL (SELECT, INSERT, UPDATE) necessárias para
// ler e gravar dados nas tabelas produto, estoque e movimentacao_estoque.
//
// Nenhuma regra de negócio fica aqui — o repository só se preocupa com
// "como buscar ou salvar dados", e não com "se aquilo deve ou não ser feito".
// As regras ficam no EstoqueService.
// =============================================================================

class EstoqueRepository
{
    // Conexão PDO com o banco de dados
    private PDO $pdo;

    // Construtor: recebe a conexão PDO já criada em config/database.php
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // -------------------------------------------------------------------------
    // Listar todos os itens em estoque
    // Retorna um array associativo com id_produto, nome do produto,
    // quantidade disponível e localização no depósito.
    // -------------------------------------------------------------------------
    public function listarEstoque(): array
    {
        // TODO: implementar a query de listagem
        return [];
    }

    // -------------------------------------------------------------------------
    // Consultar o saldo atual de um produto específico
    // Recebe o id do produto e retorna a quantidade disponível (int/float)
    // ou null se o produto não existir no estoque.
    // -------------------------------------------------------------------------
    public function consultarSaldo(int $id_produto): float|null
    {
        // TODO: implementar a query de consulta de saldo
        return null;
    }

    // -------------------------------------------------------------------------
    // Registrar entrada de estoque
    // Insere uma linha em movimentacao_estoque (tipo = 'entrada') e
    // incrementa a quantidade na tabela estoque.
    // Usa transação para garantir que as duas operações sejam atômicas
    // (as duas acontecem juntas ou nenhuma acontece).
    // -------------------------------------------------------------------------
    public function registrarEntrada(int $id_produto, float $quantidade, string $motivo = ''): bool
    {
        // TODO: implementar transação de entrada
        return false;
    }

    // -------------------------------------------------------------------------
    // Registrar saída de estoque
    // Insere uma linha em movimentacao_estoque (tipo = 'saida') e
    // decrementa a quantidade na tabela estoque.
    // Deve ser chamado apenas após o EstoqueService verificar que há saldo
    // suficiente — o repository não faz essa verificação.
    // -------------------------------------------------------------------------
    public function registrarSaida(int $id_produto, float $quantidade, string $motivo = ''): bool
    {
        // TODO: implementar transação de saída
        return false;
    }

    // -------------------------------------------------------------------------
    // Listar movimentações de um produto
    // Retorna o histórico de entradas e saídas de um produto, ordenado por
    // data decrescente (mais recente primeiro).
    // -------------------------------------------------------------------------
    public function listarMovimentacoes(int $id_produto): array
    {
        // TODO: implementar a query de histórico
        return [];
    }
}
?>
