<?php
/*
 * modules/estoque/frontend/entrada.php
 * Formulário para registrar uma entrada de produtos no estoque.
 */

$root       = '../../../';
$page_title = 'Registrar Entrada — Estoque';
$module_css = 'style.css';

include $root . 'shared/header.php';
include $root . 'shared/sidebar.php';

require_once '../backend/estoque_controller.php';
$controller = new EstoqueController();

// Variáveis de controle do formulário
$mensagem = '';
$tipo_alerta = '';

// Processa o formulário quando enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // O controller valida e chama o service, retornando ['sucesso', 'mensagem']
    $resultado   = $controller->registrarEntrada($_POST);
    $mensagem    = $resultado['mensagem'];
    $tipo_alerta = $resultado['sucesso'] ? 'success' : 'error';
}

// Busca a lista de depósitos para o campo <select>
$depositos = $controller->listarDepositos();
?>

<main class="page-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Registrar Entrada</h1>
            <p class="page-subtitle">Adicione quantidade de um produto ao estoque</p>
        </div>
        <a href="index.php" class="btn btn-secondary">← Voltar ao Estoque</a>
    </div>

    <?php if ($mensagem): ?>
        <!-- Alerta de feedback: exibido após o envio do formulário -->
        <div class="alert alert-<?= $tipo_alerta ?>">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <h2 class="card-title">Dados da Entrada</h2>

        <!-- Formulário de entrada -->
        <!-- method="post": envia os dados de forma segura pelo corpo da requisição -->
        <form method="post" action="">

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="id_produto">ID do Produto *</label>
                    <input
                        class="form-input"
                        type="number"
                        id="id_produto"
                        name="id_produto"
                        min="1"
                        required
                        placeholder="Ex: 1"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label" for="quantidade">Quantidade *</label>
                    <input
                        class="form-input"
                        type="number"
                        id="quantidade"
                        name="quantidade"
                        min="0.01"
                        step="0.01"
                        required
                        placeholder="Ex: 50.00"
                    >
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="id_deposito">Depósito *</label>
                    <select class="form-select" id="id_deposito" name="id_deposito" required>
                        <option value="">Selecione um depósito</option>
                        <?php foreach ($depositos as $deposito): ?>
                            <option value="<?= $deposito['id'] ?>">
                                <?= htmlspecialchars($deposito['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="motivo">Motivo</label>
                    <input
                        class="form-input"
                        type="text"
                        id="motivo"
                        name="motivo"
                        placeholder="Ex: Compra de insumos, colheita..."
                    >
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-primary">Confirmar Entrada</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>

</main>

<?php include $root . 'shared/footer.php'; ?>
