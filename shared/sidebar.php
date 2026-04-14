<?php
/*
 * =============================================================
 * sidebar.php — Menu lateral do Coffee Farm ERP
 *
 * Este arquivo renderiza o sidebar com os links de navegação
 * entre os módulos do sistema e o JavaScript que controla
 * o comportamento de abrir/fechar.
 *
 * COMO USAR:
 * Inclua este arquivo imediatamente após o header.php:
 *   include $root . 'shared/sidebar.php';
 *
 * A variável $root deve ter sido definida antes do header.php.
 * =============================================================
 */

/*
 * sidebarIsActive($module)
 * -------------------------
 * Verifica se o link de navegação corresponde ao módulo
 * atualmente aberto, para aplicar o estilo "ativo".
 *
 * Funciona comparando o módulo com a URL da página atual
 * ($PHP_SELF contém o caminho do script em execução).
 */
function sidebarIsActive(string $module): bool {
    return strpos($_SERVER['PHP_SELF'], '/' . $module . '/') !== false;
}
?>

<!-- ============================================================
     SIDEBAR — Menu lateral de navegação
     A classe .sidebar--collapsed é adicionada pelo JavaScript
     para recolher o menu. A transição de largura é feita por CSS.
     ============================================================ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-inner">

        <!-- Título da seção de módulos -->
        <p class="sidebar-section-title">Módulos</p>

        <!-- Lista de links de navegação -->
        <!-- Cada <a> verifica se está ativo via sidebarIsActive() -->
        <ul class="sidebar-nav">

            <li>
                <a href="<?= $root ?>modules/estoque/frontend/index.php"
                   class="sidebar-link <?= sidebarIsActive('estoque') ? 'active' : '' ?>">
                    <!-- Ícone: caixas empilhadas (estoque) -->
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 7l10-5 10 5-10 5L2 7z"/>
                        <path d="M22 7v10l-10 5V12"/>
                        <path d="M2 7v10l10 5V12"/>
                    </svg>
                    <span class="sidebar-label">Estoque</span>
                </a>
            </li>

            <li>
                <a href="<?= $root ?>modules/compras/frontend/index.php"
                   class="sidebar-link <?= sidebarIsActive('compras') ? 'active' : '' ?>">
                    <!-- Ícone: carrinho de compras -->
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="9"  cy="21" r="1"/>
                        <circle cx="20" cy="21" r="1"/>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                    </svg>
                    <span class="sidebar-label">Compras</span>
                </a>
            </li>

            <li>
                <a href="<?= $root ?>modules/financeiro/frontend/index.php"
                   class="sidebar-link <?= sidebarIsActive('financeiro') ? 'active' : '' ?>">
                    <!-- Ícone: cifrão / financeiro -->
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                    <span class="sidebar-label">Financeiro</span>
                </a>
            </li>

            <li>
                <a href="<?= $root ?>modules/faturamento/frontend/index.php"
                   class="sidebar-link <?= sidebarIsActive('faturamento') ? 'active' : '' ?>">
                    <!-- Ícone: documento / nota fiscal -->
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                        <polyline points="10 9 9 9 8 9"/>
                    </svg>
                    <span class="sidebar-label">Faturamento</span>
                </a>
            </li>

            <li>
                <a href="<?= $root ?>modules/comercial/frontend/index.php"
                   class="sidebar-link <?= sidebarIsActive('comercial') ? 'active' : '' ?>">
                    <!-- Ícone: aperto de mão / comercial -->
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <span class="sidebar-label">Comercial</span>
                </a>
            </li>

            <li>
                <a href="<?= $root ?>modules/pcp/frontend/index.php"
                   class="sidebar-link <?= sidebarIsActive('pcp') ? 'active' : '' ?>">
                    <!-- Ícone: planta / produção -->
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22V12"/>
                        <path d="M12 12C12 12 7 10 7 5a5 5 0 0 1 10 0c0 5-5 7-5 7z"/>
                        <path d="M12 12c0 0-3 2-3 6"/>
                        <path d="M12 12c0 0 3 2 3 6"/>
                    </svg>
                    <span class="sidebar-label">PCP</span>
                </a>
            </li>

            <li>
                <a href="<?= $root ?>modules/folha/frontend/index.php"
                   class="sidebar-link <?= sidebarIsActive('folha') ? 'active' : '' ?>">
                    <!-- Ícone: pessoa / folha de pagamento -->
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                    <span class="sidebar-label">Folha de Pagamento</span>
                </a>
            </li>

        </ul>
        <!-- /sidebar-nav -->

    </div>
    <!-- /sidebar-inner -->
</aside>
<!-- /sidebar -->

<!-- Overlay escuro que aparece no mobile quando o sidebar está aberto.
     Clicar nele fecha o sidebar. -->
<div class="sidebar-overlay" id="sidebar-overlay"></div>

<!-- ============================================================
     JAVASCRIPT — Lógica de abrir/fechar o sidebar
     Colocado aqui (junto ao sidebar) para manter o código
     organizado: o JS e o elemento que ele controla ficam juntos.
     ============================================================ -->
<script>
// ------------------------------------------------------------
// DOMContentLoaded garante que todos os elementos HTML já foram
// criados antes de o script tentar acessá-los. Sem isso, o script
// pode rodar antes do botão de toggle existir no DOM.
// ------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');
    const toggle  = document.getElementById('sidebar-toggle');
    const overlay = document.getElementById('sidebar-overlay');

    // Proteção: se algum elemento não existir na página, para aqui
    if (!sidebar || !toggle || !overlay) return;

    // Chave do localStorage — persiste o estado entre navegações
    const STORAGE_KEY = 'cfarm_sidebar_collapsed';

    // Largura de corte que define o comportamento "mobile"
    // Deve coincidir com o breakpoint do CSS (768px)
    const MOBILE_BREAKPOINT = 768;

    // ------------------------------------------------------------
    // isMobile()
    // Retorna true se a viewport for menor que o breakpoint mobile.
    // ------------------------------------------------------------
    function isMobile() {
        return window.innerWidth <= MOBILE_BREAKPOINT;
    }

    // ------------------------------------------------------------
    // Estado inicial ao carregar a página:
    //   - Mobile: sidebar começa FECHADO (o usuário abre quando quiser)
    //   - Desktop: respeita o último estado salvo no localStorage
    // ------------------------------------------------------------
    if (isMobile()) {
        sidebar.classList.add('sidebar--collapsed');
    } else if (localStorage.getItem(STORAGE_KEY) === 'true') {
        sidebar.classList.add('sidebar--collapsed');
    }

    // ------------------------------------------------------------
    // toggleSidebar()
    // Usa a mesma classe .sidebar--collapsed tanto no desktop quanto
    // no mobile — o CSS cuida da diferença visual (overlay, position).
    // ------------------------------------------------------------
    function toggleSidebar() {
        const isNowCollapsed = sidebar.classList.toggle('sidebar--collapsed');

        // Overlay: visível quando o sidebar está ABERTO no mobile
        overlay.classList.toggle('sidebar-overlay--visible', !isNowCollapsed);

        // Persiste o estado para páginas seguintes (apenas no desktop;
        // no mobile sempre começa fechado, então não salvar evita confusão)
        if (!isMobile()) {
            localStorage.setItem(STORAGE_KEY, isNowCollapsed);
        }
    }

    // Clique no botão hambúrguer (header)
    toggle.addEventListener('click', toggleSidebar);

    // Clique no fundo escuro (mobile): fecha o sidebar
    overlay.addEventListener('click', function () {
        sidebar.classList.add('sidebar--collapsed');
        overlay.classList.remove('sidebar-overlay--visible');
    });

});
</script>
