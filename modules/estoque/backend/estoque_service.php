<?php
// =============================================================
// EstoqueService — camada pública do módulo de Estoque
//
// Esta é a única classe que outros módulos devem usar para
// interagir com o estoque. Ela aplica as regras de negócio
// e garante que os dados retornados sejam sempre consistentes.
//
// Exemplo de uso em outro módulo:
//   require_once __DIR__ . '/../../estoque/backend/estoque_service.php';
//   $saldo = EstoqueService::getSaldo($produtoId);
// =============================================================

require_once __DIR__ . '/estoque_repository.php';
require_once __DIR__ . '/../../../config/database.php';

class EstoqueService {

    // -------------------------------------------------------------
    // Cria e retorna uma instância do repository.
    // Centraliza o acesso ao $pdo para que os métodos públicos
    // não precisem se preocupar com a conexão.
    // -------------------------------------------------------------
    private static function getRepository() {
        global $pdo;
        return new EstoqueRepository($pdo);
    }

    // -------------------------------------------------------------
    // ESTOQUE.GET.PRODUTOS
    // Retorna todos os produtos ativos com seu saldo atual.
    //
    // Retorno: array de produtos ou array vazio se não houver nenhum.
    //   [['id', 'nome', 'tipo', 'quantidade', 'unidade_medida'], ...]
    // -------------------------------------------------------------
    public static function getProdutos() {
        $repository = self::getRepository();
        $rows = $repository->findAllProdutos();

        // Formata cada linha garantindo os tipos corretos
        return array_map(function ($row) {
            return [
                'id'             => (int)   $row['id'],
                'nome'           =>         $row['nome'],
                'tipo'           =>         $row['tipo'],
                'quantidade'     => (float) $row['quantidade'],
                'unidade_medida' =>         $row['unidade'],
            ];
        }, $rows);
    }

    // -------------------------------------------------------------
    // ESTOQUE.GET.PRODUTO
    // Retorna um único produto ativo pelo ID com seu saldo atual.
    //
    // Retorno: array com os dados do produto, ou null se não encontrado.
    //   ['id', 'nome', 'tipo', 'quantidade', 'unidade_medida']
    // -------------------------------------------------------------
    public static function getProduto($id) {
        $repository = self::getRepository();
        $row = $repository->findProdutoById((int) $id);

        // Retorna null quando o produto não existe ou está inativo
        if (!$row) {
            return null;
        }

        return [
            'id'             => (int)   $row['id'],
            'nome'           =>         $row['nome'],
            'tipo'           =>         $row['tipo'],
            'quantidade'     => (float) $row['quantidade'],
            'unidade_medida' =>         $row['unidade'],
        ];
    }

    // -------------------------------------------------------------
    // ESTOQUE.GET.SALDO
    // Retorna o saldo total de um produto somando todos os depósitos.
    //
    // Retorno: ['produtoId' => int, 'saldo' => float]
    // Retorna saldo 0 se o produto não existir.
    // -------------------------------------------------------------
    public static function getSaldo($produtoId) {
        $repository = self::getRepository();

        // Verifica existência antes de consultar
        if (!$repository->produtoExiste((int) $produtoId)) {
            return ['produtoId' => (int) $produtoId, 'saldo' => 0.0];
        }

        $row   = $repository->findSaldoProduto((int) $produtoId);
        $saldo = (float) $row['saldo'];

        // Regra de negócio: saldo nunca pode ser negativo
        $saldo = max(0.0, $saldo);

        return [
            'produtoId' => (int) $produtoId,
            'saldo'     => $saldo,
        ];
    }

    // -------------------------------------------------------------
    // ESTOQUE.GET.SALDO.POR_DEPOSITO
    // Retorna o saldo de um produto em um depósito específico.
    //
    // Retorno: ['produtoId' => int, 'depositoId' => int, 'saldo' => float]
    // Retorna saldo 0 se o produto ou depósito não existirem.
    // -------------------------------------------------------------
    public static function getSaldoPorDeposito($produtoId, $depositoId) {
        $repository = self::getRepository();

        // Valida produto e depósito antes de consultar
        if (!$repository->produtoExiste((int) $produtoId) || !$repository->depositoExiste((int) $depositoId)) {
            return [
                'produtoId'  => (int) $produtoId,
                'depositoId' => (int) $depositoId,
                'saldo'      => 0.0,
            ];
        }

        $row   = $repository->findSaldoPorDeposito((int) $produtoId, (int) $depositoId);
        $saldo = $row ? max(0.0, (float) $row['saldo']) : 0.0;

        return [
            'produtoId'  => (int) $produtoId,
            'depositoId' => (int) $depositoId,
            'saldo'      => $saldo,
        ];
    }

    // -------------------------------------------------------------
    // ESTOQUE.GET.MOVIMENTACOES
    // Retorna o histórico de movimentações de um produto,
    // do mais recente para o mais antigo.
    //
    // Retorno: array de movimentações ou array vazio.
    //   [['id', 'tipo', 'quantidade', 'data', 'origem'], ...]
    // -------------------------------------------------------------
    public static function getMovimentacoes($produtoId) {
        $repository = self::getRepository();

        // Retorna vazio se o produto não existir
        if (!$repository->produtoExiste((int) $produtoId)) {
            return [];
        }

        $rows = $repository->findMovimentacoes((int) $produtoId);

        return array_map(function ($row) {
            return [
                'id'         => (int)   $row['id'],
                'tipo'       =>         $row['tipo'],
                'quantidade' => (float) $row['quantidade'],
                'data'       =>         $row['data'],
                'origem'     =>         $row['origem'],
            ];
        }, $rows);
    }

    // -------------------------------------------------------------
    // ESTOQUE.GET.DEPOSITOS
    // Retorna todos os depósitos ativos cadastrados.
    //
    // Retorno: array de depósitos ou array vazio.
    //   [['id', 'nome', 'localizacao'], ...]
    // -------------------------------------------------------------
    public static function getDepositos() {
        $repository = self::getRepository();
        $rows = $repository->findAllDepositos();

        return array_map(function ($row) {
            return [
                'id'          => (int) $row['id'],
                'nome'        =>       $row['nome'],
                'localizacao' =>       $row['localizacao'],
            ];
        }, $rows);
    }
}
?>
