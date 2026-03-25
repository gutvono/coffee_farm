<?php
// =============================================================================
// Arquivo  : MovimentacoesService.php
// Camada   : Service
// Módulo   : Estoque
// -----------------------------------------------------------------------------
// O MovimentacoesService é responsável exclusivamente pelo HISTÓRICO de
// movimentações do estoque. Enquanto o EstoqueService cuida de registrar
// entradas e saídas, este service cuida de consultar e filtrar o histórico
// gerado por essas operações.
//
// Separar essas responsabilidades em classes distintas segue o princípio
// de Responsabilidade Única (Single Responsibility Principle — SRP):
// cada classe faz apenas uma coisa e faz bem.
//
// Exemplos de uso:
//   - Exibir o histórico de um produto na tela do estoque
//   - Filtrar movimentações por período para relatórios
//   - Auditar quem movimentou o que e quando
// =============================================================================

require_once __DIR__ . '/../repository/estoque_repository.php';

class MovimentacoesService
{
    // Instância do repository que acessa o banco de dados
    private EstoqueRepository $repository;

    // Construtor: recebe o repository por injeção de dependência
    public function __construct(EstoqueRepository $repository)
    {
        $this->repository = $repository;
    }

    // -------------------------------------------------------------------------
    // Listar todas as movimentações de um produto específico
    // Retorna um array com o histórico completo (entradas e saídas),
    // ordenado da mais recente para a mais antiga.
    // Retorna array vazio se não houver movimentações ou produto não existir.
    // -------------------------------------------------------------------------
    public function listarPorProduto(int $id_produto): array
    {
        // Regra: id deve ser positivo
        if ($id_produto <= 0) {
            return [];
        }

        return $this->repository->listarMovimentacoes($id_produto);
    }

    // -------------------------------------------------------------------------
    // Listar movimentações de um produto filtradas por período
    // Recebe data de início e fim no formato 'YYYY-MM-DD'.
    // Útil para geração de relatórios mensais ou auditorias.
    // TODO: implementar filtro de período no repository e neste método.
    // -------------------------------------------------------------------------
    public function listarPorPeriodo(int $id_produto, string $dataInicio, string $dataFim): array
    {
        // TODO: validar formato das datas e chamar o repository com filtro
        return [];
    }
}
?>
