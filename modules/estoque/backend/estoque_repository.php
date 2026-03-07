<?php
// Arquivo: EstoqueRepository
// Responsável pelo acesso ao banco de dados para o módulo de estoque
// Contém queries SQL para interagir com as tabelas produto, estoque e movimentacao_estoque

class EstoqueRepository {
    private $pdo;

    // Construtor: Recebe a conexão PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Função: Listar todos os produtos em estoque
    // Retorna um array com id_produto, nome, quantidade, localizacao
    public function listarEstoque() {
        $sql = "SELECT e.id_produto, p.nome, e.quantidade, e.localizacao
                FROM estoque e
                JOIN produto p ON e.id_produto = p.id
                ORDER BY p.nome";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Função: Registrar entrada de estoque
    // Insere na movimentacao_estoque e atualiza a quantidade no estoque
    public function registrarEntradaEstoque($id_produto, $quantidade, $motivo = '') {
        // Iniciar transação para garantir consistência
        $this->pdo->beginTransaction();
        try {
            // Inserir movimentação
            $sqlMov = "INSERT INTO movimentacao_estoque (id_produto, tipo, quantidade, motivo)
                       VALUES (:id_produto, 'entrada', :quantidade, :motivo)";
            $stmtMov = $this->pdo->prepare($sqlMov);
            $stmtMov->execute([
                ':id_produto' => $id_produto,
                ':quantidade' => $quantidade,
                ':motivo' => $motivo
            ]);

            // Atualizar estoque: aumentar quantidade
            $sqlEst = "UPDATE estoque SET quantidade = quantidade + :quantidade WHERE id_produto = :id_produto";
            $stmtEst = $this->pdo->prepare($sqlEst);
            $stmtEst->execute([
                ':quantidade' => $quantidade,
                ':id_produto' => $id_produto
            ]);

            // Confirmar transação
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            // Reverter em caso de erro
            $this->pdo->rollBack();
            return false;
        }
    }

    // Função: Registrar saída de estoque
    // Insere na movimentacao_estoque e atualiza a quantidade no estoque
    public function registrarSaidaEstoque($id_produto, $quantidade, $motivo = '') {
        // Verificar se há quantidade suficiente
        $sqlCheck = "SELECT quantidade FROM estoque WHERE id_produto = :id_produto";
        $stmtCheck = $this->pdo->prepare($sqlCheck);
        $stmtCheck->execute([':id_produto' => $id_produto]);
        $estoqueAtual = $stmtCheck->fetchColumn();

        if ($estoqueAtual < $quantidade) {
            return false; // Quantidade insuficiente
        }

        // Iniciar transação
        $this->pdo->beginTransaction();
        try {
            // Inserir movimentação
            $sqlMov = "INSERT INTO movimentacao_estoque (id_produto, tipo, quantidade, motivo)
                       VALUES (:id_produto, 'saida', :quantidade, :motivo)";
            $stmtMov = $this->pdo->prepare($sqlMov);
            $stmtMov->execute([
                ':id_produto' => $id_produto,
                ':quantidade' => $quantidade,
                ':motivo' => $motivo
            ]);

            // Atualizar estoque: diminuir quantidade
            $sqlEst = "UPDATE estoque SET quantidade = quantidade - :quantidade WHERE id_produto = :id_produto";
            $stmtEst = $this->pdo->prepare($sqlEst);
            $stmtEst->execute([
                ':quantidade' => $quantidade,
                ':id_produto' => $id_produto
            ]);

            // Confirmar transação
            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            // Reverter em caso de erro
            $this->pdo->rollBack();
            return false;
        }
    }
}
?>