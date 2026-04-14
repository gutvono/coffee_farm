<?php
/*
 * modules/estoque/frontend/index.php
 * Página principal do módulo Estoque.
 * Exibe a lista de produtos com seus saldos atuais.
 */

// Caminho relativo até a raiz do projeto.
// Este arquivo está 3 níveis abaixo da raiz (modules/estoque/frontend/),
// por isso usamos '../../../'.
$root       = '../../../';
$page_title = 'Estoque';
$module_css = 'style.css'; // CSS específico deste módulo (carregado pelo header)

// Carrega o cabeçalho e o sidebar
include $root . 'shared/header.php';
include $root . 'shared/sidebar.php';

// Carrega o controller do módulo para buscar os dados
require_once '../backend/estoque_controller.php';
$controller = new EstoqueController();
$produtos   = $controller->listarProdutos();
?>

<main class="page-content">

    <!-- Cabeçalho da página com título e botões de ação -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Estoque</h1>
            <p class="page-subtitle">Saldo atual de produtos e insumos</p>
        </div>
        <div class="btn-group">
            <a href="entrada.php" class="btn btn-primary">+ Registrar Entrada</a>
            <a href="saida.php"   class="btn btn-secondary">Registrar Saída</a>
        </div>
    </div>

    <!-- Card com a tabela de produtos -->
    <div class="card">
        <h2 class="card-title">Produtos em Estoque</h2>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Tipo</th>
                    <th>Quantidade</th>
                    <th>Unidade</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($produtos)): ?>
                    <!-- Linha exibida quando não há dados -->
                    <tr class="empty-row">
                        <td colspan="4">Nenhum produto cadastrado no estoque.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?= htmlspecialchars($produto['nome']) ?></td>
                            <td>
                                <!-- Badge visual para o tipo do produto -->
                                <span class="badge <?= $produto['tipo'] === 'PRODUTO' ? 'badge-success' : 'badge-neutral' ?>">
                                    <?= htmlspecialchars($produto['tipo']) ?>
                                </span>
                            </td>
                            <td><?= number_format($produto['quantidade'], 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars($produto['unidade_medida']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- /card -->

</main>

<?php include $root . 'shared/footer.php'; ?>
