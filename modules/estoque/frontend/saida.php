<?php
/*
 * modules/estoque/frontend/saida.php
 * Formulário para registrar uma saída de produtos do estoque.
 */

$root       = '../../../';
$page_title = 'Registrar Saída — Estoque';
$module_css = 'style.css';

include $root . 'shared/header.php';
include $root . 'shared/sidebar.php';

require_once '../backend/estoque_controller.php';
$controller = new EstoqueController();

$mensagem = '';
$tipo_alerta = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado   = $controller->registrarSaida($_POST);
    $mensagem    = $resultado['mensagem'];
    $tipo_alerta = $resultado['sucesso'] ? 'success' : 'error';
}

$depositos = $controller->listarDepositos();
?>

<main class="page-content">

    <div class="page-header">
        <div>
            <h1 class="page-title">Registrar Saída</h1>
            <p class="page-subtitle">Remova quantidade de um produto do estoque</p>
        </div>
        <a href="index.php" class="btn btn-secondary">← Voltar ao Estoque</a>
    </div>

    <?php if ($mensagem): ?>
        <div class="alert alert-<?= $tipo_alerta ?>">
            <?= htmlspecialchars($mensagem) ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <h2 class="card-title">Dados da Saída</h2>

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
                        placeholder="Ex: 10.00"
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
                        placeholder="Ex: Venda, consumo interno..."
                    >
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" class="btn btn-danger">Confirmar Saída</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </div>

        </form>
    </div>

</main>

<?php include $root . 'shared/footer.php'; ?>
