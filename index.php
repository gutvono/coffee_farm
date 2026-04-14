<?php
/*
 * index.php — Página inicial do Coffee Farm ERP
 *
 * Esta é a primeira página que o usuário vê ao acessar o sistema.
 * Ela serve como painel de entrada (dashboard) e direciona para
 * os módulos disponíveis.
 */

// Caminho relativo até a raiz do projeto.
// Como este arquivo JÁ ESTÁ na raiz, $root é uma string vazia.
$root       = '';
$page_title = 'Início';

// Carrega o cabeçalho HTML (abre <html>, <head>, <body> e .app-body)
include 'shared/header.php';

// Carrega o sidebar com os links de navegação
include 'shared/sidebar.php';
?>

<main class="page-content">

    <h1 class="page-title">Bem-vindo ao Coffee Farm ERP</h1>
    <p class="page-subtitle">Sistema de gestão para fazenda de café arábica</p>

    <!-- Grade de cards de acesso rápido aos módulos -->
    <div class="module-grid">

        <a href="modules/estoque/frontend/index.php" class="module-card">
            <div class="module-card__icon">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 7l10-5 10 5-10 5L2 7z"/>
                    <path d="M22 7v10l-10 5V12"/>
                    <path d="M2 7v10l10 5V12"/>
                </svg>
            </div>
            <span class="module-card__name">Estoque</span>
            <span class="module-card__desc">Controle de produtos e movimentações</span>
        </a>

        <a href="modules/compras/frontend/index.php" class="module-card">
            <div class="module-card__icon">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="9"  cy="21" r="1"/>
                    <circle cx="20" cy="21" r="1"/>
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                </svg>
            </div>
            <span class="module-card__name">Compras</span>
            <span class="module-card__desc">Pedidos de compra a fornecedores</span>
        </a>

        <a href="modules/financeiro/frontend/index.php" class="module-card">
            <div class="module-card__icon">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"/>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
            <span class="module-card__name">Financeiro</span>
            <span class="module-card__desc">Contas a pagar e a receber</span>
        </a>

        <a href="modules/faturamento/frontend/index.php" class="module-card">
            <div class="module-card__icon">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
            </div>
            <span class="module-card__name">Faturamento</span>
            <span class="module-card__desc">Emissão e controle de faturas</span>
        </a>

        <a href="modules/comercial/frontend/index.php" class="module-card">
            <div class="module-card__icon">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <span class="module-card__name">Comercial</span>
            <span class="module-card__desc">Vendas e gestão de clientes</span>
        </a>

        <a href="modules/pcp/frontend/index.php" class="module-card">
            <div class="module-card__icon">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22V12"/>
                    <path d="M12 12C12 12 7 10 7 5a5 5 0 0 1 10 0c0 5-5 7-5 7z"/>
                </svg>
            </div>
            <span class="module-card__name">PCP</span>
            <span class="module-card__desc">Planejamento e controle da produção</span>
        </a>

        <a href="modules/folha/frontend/index.php" class="module-card">
            <div class="module-card__icon">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                </svg>
            </div>
            <span class="module-card__name">Folha de Pagamento</span>
            <span class="module-card__desc">Gestão de funcionários e salários</span>
        </a>

    </div>
    <!-- /module-grid -->

</main>

<!-- Estilos específicos da página inicial (grade de cards) -->
<style>
.module-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: var(--space-lg);
    margin-top: var(--space-lg);
}

.module-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: var(--space-sm);
    padding: var(--space-xl) var(--space-md);
    background-color: var(--color-surface);
    border: 1px solid var(--color-border);
    border-radius: var(--radius-lg);
    text-decoration: none;
    text-align: center;
    box-shadow: var(--shadow-sm);
    transition: box-shadow var(--transition), border-color var(--transition), transform var(--transition);
}

.module-card:hover {
    text-decoration: none;
    box-shadow: var(--shadow-md);
    border-color: var(--color-primary-light);
    transform: translateY(-2px);
}

/*
  Tamanho padrão de containers de ícone em dashboards: 40–44px.
  Usamos 40px — ícone interno de 20px (metade do container).
*/
.module-card__icon {
    width: 40px;
    height: 40px;
    background-color: var(--green-faint);
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.module-card__icon svg {
    width: 20px;
    height: 20px;
    color: var(--color-primary);
}

.module-card__name {
    font-size: var(--font-size-base);
    font-weight: var(--font-weight-bold);
    color: var(--color-text);
}

.module-card__desc {
    font-size: var(--font-size-xs);
    color: var(--color-text-muted);
    line-height: 1.4;
}
</style>

<?php
// Fecha as divs do app-body e app-wrapper abertas pelo header.php
include 'shared/footer.php';
?>
