<?php
/*
 * =============================================================
 * header.php — Cabeçalho HTML global do Coffee Farm ERP
 *
 * Este arquivo abre a estrutura HTML da página, carrega os
 * estilos globais e renderiza a barra de topo com o logo.
 *
 * COMO USAR:
 * Antes de incluir este arquivo, defina a variável $root com o
 * caminho relativo até a raiz do projeto:
 *
 *   Páginas na raiz:                $root = '';
 *   Páginas em modules/x/frontend:  $root = '../../../';
 *
 * Opcionalmente, defina também:
 *   $page_title  — título da aba do navegador (string)
 *   $module_css  — caminho para o CSS específico do módulo (string)
 *
 * Exemplo de uso em um módulo:
 *   <?php
 *   $root       = '../../../';
 *   $page_title = 'Estoque';
 *   $module_css = 'style.css';
 *   include $root . 'shared/header.php';
 *   include $root . 'shared/sidebar.php';
 *   ?>
 *   <main class="page-content"> ... </main>
 *   <?php include $root . 'shared/footer.php'; ?>
 * =============================================================
 */

// Garante que $root está definido. Se não foi definido pela página,
// usa string vazia (assume que está na raiz).
if (!isset($root)) {
    $root = '';
}

// Título padrão caso a página não defina um
if (!isset($page_title)) {
    $page_title = 'Coffee Farm ERP';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> — Coffee Farm ERP</title>

    <!-- 1. Variáveis de design (cores, espaços, tipografia) -->
    <link rel="stylesheet" href="<?= $root ?>shared/variables.css">

    <!-- 2. Estilos globais (layout, componentes reutilizáveis) -->
    <link rel="stylesheet" href="<?= $root ?>shared/style.css">

    <?php if (isset($module_css)): ?>
    <!-- 3. CSS específico do módulo — carregado por último para sobrescrever se necessário -->
    <link rel="stylesheet" href="<?= htmlspecialchars($module_css) ?>">
    <?php endif; ?>
</head>
<body>

<!-- ============================================================
     .app-wrapper — Contêiner raiz que envolve toda a página.
     O footer.php fecha esta div.
     ============================================================ -->
<div class="app-wrapper">

    <!-- ========================================================
         HEADER — Barra de topo fixa
         Contém: botão de toggle do sidebar + logo do sistema
         ======================================================== -->
    <header class="app-header">

        <!-- Botão hambúrguer: abre e fecha o sidebar lateral -->
        <!-- O JavaScript em sidebar.php controla o comportamento -->
        <button class="sidebar-toggle" id="sidebar-toggle" aria-label="Abrir ou fechar menu">
            <!-- Ícone de três linhas (hambúrguer) desenhado em SVG -->
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <line x1="3" y1="6"  x2="21" y2="6"/>
                <line x1="3" y1="12" x2="21" y2="12"/>
                <line x1="3" y1="18" x2="21" y2="18"/>
            </svg>
        </button>

        <!-- Logo: clicável, leva à página inicial -->
        <a href="<?= $root ?>index.php" class="app-logo">
            <img
                src="<?= $root ?>shared/assets/logo.svg"
                alt="Coffee Farm ERP logo"
            >
        </a>

    </header>
    <!-- /app-header -->

    <!-- ========================================================
         .app-body — Contêiner que posiciona o sidebar ao lado
         do conteúdo da página. Aberto aqui, fechado no footer.
         ======================================================== -->
    <div class="app-body">
