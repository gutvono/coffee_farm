<?php
// Página para registrar saída de estoque
include '../../../shared/header.php';
echo '<link rel="stylesheet" href="style.css">'; // CSS específico do módulo
include '../../../shared/menu.php';

// Incluir o controller
require_once '../backend/estoque_controller.php';

// Processar o formulário se enviado
$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new EstoqueController();
    $resultado = $controller->registrarSaidaEstoque($_POST);
    $mensagem = $resultado['mensagem'];
}
?>
<main>
    <h1>Registrar Saída de Estoque</h1>

    <?php if ($mensagem): ?>
        <p><?php echo htmlspecialchars($mensagem); ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="id_produto">ID do Produto:</label>
        <input type="number" id="id_produto" name="id_produto" required><br><br>

        <label for="quantidade">Quantidade:</label>
        <input type="number" step="0.01" id="quantidade" name="quantidade" required><br><br>

        <label for="motivo">Motivo (opcional):</label>
        <input type="text" id="motivo" name="motivo"><br><br>

        <button type="submit">Registrar Saída</button>
    </form>

    <p><a href="index.php">Voltar ao Estoque</a></p>
</main>
<?php
include '../../../shared/footer.php';
?>