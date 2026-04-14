<?php
/*
 * modules/compras/frontend/index.php
 * Página principal do módulo Compras.
 *
 * PADRÃO DE INCLUSÃO (igual em todos os módulos):
 *   1. Definir $root, $page_title e opcionalmente $module_css
 *   2. Incluir header.php e sidebar.php
 *   3. Escrever o <main class="page-content">
 *   4. Incluir footer.php
 */

$root       = '../../../';
$page_title = 'Compras';
$module_css = 'style.css';

include $root . 'shared/header.php';
include $root . 'shared/sidebar.php';
?>

<main class="page-content">

    <h1 class="page-title">Compras</h1>
    <p class="page-subtitle">Gerenciamento de pedidos de compra a fornecedores</p>

    <div class="card">
        <h2 class="card-title">Em desenvolvimento</h2>
        <p>O conteúdo deste módulo será implementado em breve.</p>
    </div>

</main>

<?php include $root . 'shared/footer.php'; ?>
