<?php
// =============================================================================
// Arquivo  : estoque_controller.php
// Camada   : Controller
// Módulo   : Estoque
// -----------------------------------------------------------------------------
// O CONTROLLER é a ponte entre o frontend (páginas HTML/PHP) e o service.
// Ele recebe os dados enviados pelo usuário via formulário ou URL, faz uma
// validação básica de formato (ex.: campo obrigatório preenchido?) e repassa
// para o service tomar as decisões de negócio.
//
// O controller NÃO deve conter regras de negócio. Exemplo:
//   ✅ Controller verifica: "o campo quantidade foi preenchido?"
//   ❌ Controller NÃO verifica: "há saldo suficiente para a saída?"
//      → essa verificação é responsabilidade do EstoqueService.
//
// Fluxo geral:
//   Frontend → Controller → EstoqueService → EstoqueRepository → Banco
// =============================================================================

require_once __DIR__ . '/../../../../config/database.php';
require_once __DIR__ . '/../repository/estoque_repository.php';
require_once __DIR__ . '/../service/EstoqueService.php';
require_once __DIR__ . '/../service/MovimentacoesService.php';

class EstoqueController
{
    // Instâncias dos services utilizados por este controller
    private EstoqueService $estoqueService;
    private MovimentacoesService $movimentacoesService;

    // Construtor: monta as dependências na ordem correta.
    // Repository → Service → Controller (cada camada conhece apenas a de baixo).
    public function __construct()
    {
        global $pdo; // conexão criada em config/database.php

        $repository = new EstoqueRepository($pdo);
        $this->estoqueService      = new EstoqueService($repository);
        $this->movimentacoesService = new MovimentacoesService($repository);
    }

    // -------------------------------------------------------------------------
    // Ação: listar estoque
    // Chamado pela página principal do módulo (ex.: frontend/index.php).
    // Retorna todos os produtos com saldo atual.
    // -------------------------------------------------------------------------
    public function listarEstoque(): array
    {
        return $this->estoqueService->listarEstoque();
    }

    // -------------------------------------------------------------------------
    // Ação: registrar entrada
    // Recebe os dados do formulário de entrada (POST).
    // Valida campos obrigatórios antes de chamar o service.
    // Retorna array com 'sucesso' e 'mensagem' para exibir no frontend.
    // -------------------------------------------------------------------------
    public function registrarEntrada(array $dados): array
    {
        // Validação básica de campos obrigatórios
        if (empty($dados['id_produto']) || empty($dados['quantidade'])) {
            return ['sucesso' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
        }

        $id_produto = (int)   $dados['id_produto'];
        $quantidade = (float) $dados['quantidade'];
        $motivo     = $dados['motivo'] ?? '';

        // Delega ao service, que aplicará as regras de negócio
        return $this->estoqueService->registrarEntrada($id_produto, $quantidade, $motivo);
    }

    // -------------------------------------------------------------------------
    // Ação: registrar saída
    // Recebe os dados do formulário de saída (POST).
    // Valida campos obrigatórios antes de chamar o service.
    // Retorna array com 'sucesso' e 'mensagem' para exibir no frontend.
    // -------------------------------------------------------------------------
    public function registrarSaida(array $dados): array
    {
        // Validação básica de campos obrigatórios
        if (empty($dados['id_produto']) || empty($dados['quantidade'])) {
            return ['sucesso' => false, 'mensagem' => 'Preencha todos os campos obrigatórios.'];
        }

        $id_produto = (int)   $dados['id_produto'];
        $quantidade = (float) $dados['quantidade'];
        $motivo     = $dados['motivo'] ?? '';

        // Delega ao service, que verificará saldo e aplicará as regras
        return $this->estoqueService->registrarSaida($id_produto, $quantidade, $motivo);
    }

    // -------------------------------------------------------------------------
    // Ação: listar movimentações de um produto
    // Chamado pela página de histórico do módulo.
    // Retorna o histórico de entradas e saídas do produto informado.
    // -------------------------------------------------------------------------
    public function listarMovimentacoes(int $id_produto): array
    {
        return $this->movimentacoesService->listarPorProduto($id_produto);
    }
}
?>
