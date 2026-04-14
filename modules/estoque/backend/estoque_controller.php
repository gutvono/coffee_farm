<?php
// =============================================================
// EstoqueController
// Responsável por processar as requisições vindas do frontend
// e repassá-las ao EstoqueService.
//
// O controller NÃO contém regras de negócio — ele apenas:
//   1. Lê os dados da requisição (GET/POST)
//   2. Chama o método correto do Service
//   3. Retorna os dados para a view
// =============================================================

require_once __DIR__ . '/estoque_service.php';

class EstoqueController {

    // -------------------------------------------------------------
    // Lista todos os produtos ativos com seus saldos.
    // Usado pela view principal do módulo (index.php).
    // -------------------------------------------------------------
    public function listarProdutos() {
        return EstoqueService::getProdutos();
    }

    // -------------------------------------------------------------
    // Busca um produto específico pelo ID.
    // Retorna null se o produto não existir.
    // -------------------------------------------------------------
    public function buscarProduto($id) {
        return EstoqueService::getProduto($id);
    }

    // -------------------------------------------------------------
    // Consulta o saldo total de um produto (todos os depósitos).
    // -------------------------------------------------------------
    public function consultarSaldo($produtoId) {
        return EstoqueService::getSaldo($produtoId);
    }

    // -------------------------------------------------------------
    // Consulta o saldo de um produto em um depósito específico.
    // -------------------------------------------------------------
    public function consultarSaldoPorDeposito($produtoId, $depositoId) {
        return EstoqueService::getSaldoPorDeposito($produtoId, $depositoId);
    }

    // -------------------------------------------------------------
    // Lista o histórico de movimentações de um produto.
    // -------------------------------------------------------------
    public function listarMovimentacoes($produtoId) {
        return EstoqueService::getMovimentacoes($produtoId);
    }

    // -------------------------------------------------------------
    // Lista todos os depósitos ativos.
    // Usado em selects/filtros do frontend.
    // -------------------------------------------------------------
    public function listarDepositos() {
        return EstoqueService::getDepositos();
    }
}
?>
