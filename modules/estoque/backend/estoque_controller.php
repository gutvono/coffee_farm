<?php
// Arquivo: EstoqueController
// Responsável por intermediar o frontend e o repository
// Recebe requisições, chama métodos do repository e retorna resultados

require_once __DIR__ . '/estoque_repository.php'; // Incluir o repository
require_once __DIR__ . '/../../../config/database.php'; // Incluir a conexão PDO

class EstoqueController {
    private $repository;

    // Construtor: Inicializa o repository com a conexão PDO
    public function __construct() {
        global $pdo; // Usar a variável global do database.php
        $this->repository = new EstoqueRepository($pdo);
    }

    // Função: Listar estoque
    // Chama o repository e retorna os dados
    public function listarEstoque() {
        return $this->repository->listarEstoque();
    }

    // Função: Registrar entrada de estoque
    // Recebe dados do frontend, valida e chama o repository
    public function registrarEntradaEstoque($dados) {
        // Validar dados básicos
        if (!isset($dados['id_produto']) || !isset($dados['quantidade']) || $dados['quantidade'] <= 0) {
            return ['sucesso' => false, 'mensagem' => 'Dados inválidos para entrada de estoque.'];
        }

        $id_produto = (int) $dados['id_produto'];
        $quantidade = (float) $dados['quantidade'];
        $motivo = $dados['motivo'] ?? '';

        // Chamar repository
        $sucesso = $this->repository->registrarEntradaEstoque($id_produto, $quantidade, $motivo);

        if ($sucesso) {
            return ['sucesso' => true, 'mensagem' => 'Entrada de estoque registrada com sucesso.'];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Erro ao registrar entrada de estoque.'];
        }
    }

    // Função: Registrar saída de estoque
    // Recebe dados do frontend, valida e chama o repository
    public function registrarSaidaEstoque($dados) {
        // Validar dados básicos
        if (!isset($dados['id_produto']) || !isset($dados['quantidade']) || $dados['quantidade'] <= 0) {
            return ['sucesso' => false, 'mensagem' => 'Dados inválidos para saída de estoque.'];
        }

        $id_produto = (int) $dados['id_produto'];
        $quantidade = (float) $dados['quantidade'];
        $motivo = $dados['motivo'] ?? '';

        // Chamar repository
        $sucesso = $this->repository->registrarSaidaEstoque($id_produto, $quantidade, $motivo);

        if ($sucesso) {
            return ['sucesso' => true, 'mensagem' => 'Saída de estoque registrada com sucesso.'];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Erro ao registrar saída de estoque (quantidade insuficiente ou erro interno).'];
        }
    }
}
?>