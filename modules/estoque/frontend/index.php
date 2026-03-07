<?php
// Página inicial do módulo estoque - Listar produtos em estoque
include '../../../shared/header.php';
echo '<link rel="stylesheet" href="style.css">'; // CSS específico do módulo
include '../../../shared/menu.php';

// Incluir o controller do backend
require_once '../backend/estoque_controller.php';

// Instanciar o controller
$controller = new EstoqueController();

// Obter a lista de estoque
$estoque = $controller->listarEstoque();
?>
<main>
    <h1>Estoque de Produtos</h1>
    <p>Abaixo está a lista de produtos em estoque:</p>

    <?php if (empty($estoque)): ?>
        <p>Nenhum produto em estoque.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>ID Produto</th>
                    <th>Nome</th>
                    <th>Quantidade</th>
                    <th>Localização</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($estoque as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['id_produto']); ?></td>
                        <td><?php echo htmlspecialchars($item['nome']); ?></td>
                        <td><?php echo htmlspecialchars($item['quantidade']); ?></td>
                        <td><?php echo htmlspecialchars($item['localizacao'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p><a href="entrada.php">Registrar Entrada</a> | <a href="saida.php">Registrar Saída</a></p>
</main>
<?php
include '../../../shared/footer.php';
?>