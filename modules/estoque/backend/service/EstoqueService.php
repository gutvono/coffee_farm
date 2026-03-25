<?php
// =============================================================================
// Arquivo  : EstoqueService.php
// Camada   : Service
// Módulo   : Estoque
// -----------------------------------------------------------------------------
// O SERVICE é o "cérebro" do módulo. Ele contém as REGRAS DE NEGÓCIO —
// ou seja, as decisões que o sistema precisa tomar antes de gravar algo no
// banco (ex.: verificar se há saldo suficiente antes de registrar uma saída).
//
// O EstoqueService também é a porta de entrada para outros módulos.
// Compras, Faturamento, PCP — qualquer módulo que precisar mexer no estoque
// deve chamar um método deste service. Nunca deve acessar o banco diretamente.
//
// Fluxo geral:
//   Frontend → Controller → EstoqueService → EstoqueRepository → Banco
// =============================================================================

require_once __DIR__ . '/../repository/estoque_repository.php';

class EstoqueService
{
    // Instância do repository que cuida do acesso ao banco
    private EstoqueRepository $repository;

    // Construtor: recebe o repository por injeção de dependência.
    // Isso facilita testes e substituição futura do repository.
    public function __construct(EstoqueRepository $repository)
    {
        $this->repository = $repository;
    }

    // -------------------------------------------------------------------------
    // Registrar entrada de produto no estoque
    // Regras aplicadas antes de chamar o repository:
    //   - quantidade deve ser maior que zero
    //   - id_produto deve ser um inteiro positivo
    // Retorna array com 'sucesso' (bool) e 'mensagem' (string).
    // Pode ser chamado por outros módulos (ex.: Compras ao receber mercadoria).
    // -------------------------------------------------------------------------
    public function registrarEntrada(int $id_produto, float $quantidade, string $motivo = ''): array
    {
        // Regra: quantidade inválida
        if ($quantidade <= 0) {
            return ['sucesso' => false, 'mensagem' => 'A quantidade de entrada deve ser maior que zero.'];
        }

        // Regra: id do produto deve ser positivo
        if ($id_produto <= 0) {
            return ['sucesso' => false, 'mensagem' => 'ID de produto inválido.'];
        }

        // Delega a gravação ao repository
        $sucesso = $this->repository->registrarEntrada($id_produto, $quantidade, $motivo);

        if ($sucesso) {
            return ['sucesso' => true, 'mensagem' => 'Entrada registrada com sucesso.'];
        }

        return ['sucesso' => false, 'mensagem' => 'Erro ao registrar entrada. Tente novamente.'];
    }

    // -------------------------------------------------------------------------
    // Registrar saída de produto do estoque
    // Regras aplicadas antes de chamar o repository:
    //   - quantidade deve ser maior que zero
    //   - saldo atual deve ser suficiente para cobrir a saída
    // Retorna array com 'sucesso' (bool) e 'mensagem' (string).
    // Pode ser chamado por outros módulos (ex.: Faturamento ao emitir nota).
    // -------------------------------------------------------------------------
    public function registrarSaida(int $id_produto, float $quantidade, string $motivo = ''): array
    {
        // Regra: quantidade inválida
        if ($quantidade <= 0) {
            return ['sucesso' => false, 'mensagem' => 'A quantidade de saída deve ser maior que zero.'];
        }

        // Regra: verificar saldo disponível antes de autorizar a saída
        $saldoAtual = $this->repository->consultarSaldo($id_produto);

        if ($saldoAtual === null) {
            return ['sucesso' => false, 'mensagem' => 'Produto não encontrado no estoque.'];
        }

        if ($saldoAtual < $quantidade) {
            return [
                'sucesso'  => false,
                'mensagem' => "Saldo insuficiente. Disponível: {$saldoAtual}, solicitado: {$quantidade}."
            ];
        }

        // Saldo suficiente: delega a gravação ao repository
        $sucesso = $this->repository->registrarSaida($id_produto, $quantidade, $motivo);

        if ($sucesso) {
            return ['sucesso' => true, 'mensagem' => 'Saída registrada com sucesso.'];
        }

        return ['sucesso' => false, 'mensagem' => 'Erro ao registrar saída. Tente novamente.'];
    }

    // -------------------------------------------------------------------------
    // Consultar saldo atual de um produto
    // Retorna a quantidade disponível ou null se o produto não existir.
    // Método público — outros módulos podem consultar o saldo sem alterar nada.
    // -------------------------------------------------------------------------
    public function consultarSaldo(int $id_produto): float|null
    {
        return $this->repository->consultarSaldo($id_produto);
    }

    // -------------------------------------------------------------------------
    // Listar todo o estoque atual
    // Retorna um array com todos os produtos e suas quantidades disponíveis.
    // -------------------------------------------------------------------------
    public function listarEstoque(): array
    {
        return $this->repository->listarEstoque();
    }
}
?>
