<?php
// =============================================================
// EstoqueRepository
// Responsável por todas as consultas SQL do módulo de estoque.
//
// IMPORTANTE: Esta classe é privada ao módulo.
// Outros módulos NÃO devem instanciá-la diretamente.
// Use sempre o EstoqueService para acessar dados de estoque.
// =============================================================

class EstoqueRepository {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // -------------------------------------------------------------
    // Retorna todos os produtos ativos com o saldo total de estoque.
    // Usa LEFT JOIN para incluir produtos que ainda não têm saldo
    // registrado na tabela estoque (saldo será NULL → tratado no Service).
    // -------------------------------------------------------------
    public function findAllProdutos() {
        $sql = "SELECT p.id, p.nome, p.tipo, p.unidade,
                       COALESCE(SUM(e.quantidade), 0) AS quantidade
                FROM produto p
                LEFT JOIN estoque e ON e.id_produto = p.id
                WHERE p.ativo = 1
                GROUP BY p.id, p.nome, p.tipo, p.unidade
                ORDER BY p.nome";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // -------------------------------------------------------------
    // Retorna um único produto ativo pelo ID com o saldo total.
    // Retorna false se o produto não existir ou estiver inativo.
    // -------------------------------------------------------------
    public function findProdutoById($id) {
        $sql = "SELECT p.id, p.nome, p.tipo, p.unidade,
                       COALESCE(SUM(e.quantidade), 0) AS quantidade
                FROM produto p
                LEFT JOIN estoque e ON e.id_produto = p.id
                WHERE p.id = :id AND p.ativo = 1
                GROUP BY p.id, p.nome, p.tipo, p.unidade";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    // -------------------------------------------------------------
    // Retorna o saldo total de um produto somando todos os depósitos.
    // COALESCE garante 0 quando não há linha na tabela estoque.
    // -------------------------------------------------------------
    public function findSaldoProduto($produtoId) {
        $sql = "SELECT COALESCE(SUM(quantidade), 0) AS saldo
                FROM estoque
                WHERE id_produto = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $produtoId]);
        return $stmt->fetch();
    }

    // -------------------------------------------------------------
    // Retorna o saldo de um produto em um depósito específico.
    // Retorna false se não houver registro para essa combinação.
    // -------------------------------------------------------------
    public function findSaldoPorDeposito($produtoId, $depositoId) {
        $sql = "SELECT COALESCE(quantidade, 0) AS saldo
                FROM estoque
                WHERE id_produto = :produtoId AND id_deposito = :depositoId";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':produtoId'  => $produtoId,
            ':depositoId' => $depositoId,
        ]);
        return $stmt->fetch();
    }

    // -------------------------------------------------------------
    // Retorna o histórico de movimentações de um produto,
    // ordenado do mais recente para o mais antigo.
    // -------------------------------------------------------------
    public function findMovimentacoes($produtoId) {
        $sql = "SELECT id, tipo, quantidade, motivo AS origem,
                       data_movimentacao AS data
                FROM movimentacao_estoque
                WHERE id_produto = :id
                ORDER BY data_movimentacao DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $produtoId]);
        return $stmt->fetchAll();
    }

    // -------------------------------------------------------------
    // Retorna todos os depósitos ativos cadastrados.
    // -------------------------------------------------------------
    public function findAllDepositos() {
        $sql = "SELECT id, nome, localizacao
                FROM deposito
                WHERE ativo = 1
                ORDER BY nome";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    // -------------------------------------------------------------
    // Verifica se um produto existe e está ativo.
    // Usado pelo Service para validações antes de consultas.
    // -------------------------------------------------------------
    public function produtoExiste($id) {
        $sql  = "SELECT id FROM produto WHERE id = :id AND ativo = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() !== false;
    }

    // -------------------------------------------------------------
    // Verifica se um depósito existe e está ativo.
    // -------------------------------------------------------------
    public function depositoExiste($id) {
        $sql  = "SELECT id FROM deposito WHERE id = :id AND ativo = 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() !== false;
    }
}
?>
