# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

**Coffee Farm ERP** is an educational PHP ERP system for managing arabica coffee farm operations — from planting through commercialization. It is intentionally built without frameworks (pure PHP, HTML, CSS, MySQL) to teach fundamentals.

## Running the Project

Requires a local server stack (XAMPP, Laragon, or WAMP) with Apache and MySQL running.

1. Place the `coffee_farm/` folder inside the server's web root (e.g., `htdocs/` for XAMPP).
2. Create the database and tables: run `database/schema.sql` via phpMyAdmin or MySQL CLI:
   ```
   mysql -u root -p < database/schema.sql
   ```
3. Configure DB credentials in `config/database.php` (defaults: host=localhost, user=root, password=empty, db=coffee_farm_erp).
4. Access via browser: `http://localhost/coffee_farm/index.php`

There is no build step, no package manager, and no test runner — this is a plain PHP project.

## Architecture

### Module Structure

Each of the 7 modules follows a consistent layout:

```
modules/<module>/
  backend/
    controller.php    # Validates input, orchestrates calls to repository
    repository.php    # All SQL queries via PDO; returns data arrays
  frontend/
    index.php         # Entry page; instantiates controller directly
    style.css         # Module-specific styles
```

The frontend PHP files include the controller directly (`require_once '../backend/<module>_controller.php'`) and call controller methods inline — there is no routing layer or HTTP API. Pages call `include '../../../shared/header.php'` and `include '../../../shared/footer.php'` for layout.

### Database Connection

`config/database.php` creates a global `$pdo` PDO instance. Controllers access it via `global $pdo` in their constructors. All SQL goes through PDO prepared statements in repository classes.

### Shared Layout

`shared/header.php`, `shared/menu.php`, `shared/footer.php`, and `shared/style.css` are included by every page. The menu hardcodes links to each module's `frontend/index.php`.

### The 7 Modules

| Module | Folder | Purpose |
|---|---|---|
| Estoque | `modules/estoque/` | Inventory: entrada/saída of products |
| Compras | `modules/compras/` | Purchase orders to suppliers |
| Financeiro | `modules/financeiro/` | Accounts payable/receivable |
| Faturamento | `modules/faturamento/` | Sales invoices |
| Comercial | `modules/comercial/` | Sales orders and customers |
| PCP | `modules/pcp/` | Production planning: planting areas, harvest orders |
| Folha | `modules/folha/` | Payroll and employee management |

### Key Database Tables

Modules share one database. Cross-module relationships are handled via foreign keys:
- `produto`, `cliente`, `fornecedor` — core shared entities
- `estoque` + `movimentacao_estoque` — inventory state and history
- `pedido_compra` / `pedido_venda` + `_item` tables — purchase/sales orders
- `conta_pagar` / `conta_receber` — linked to orders for financial tracking
- `ordem_producao`, `area_plantio`, `colheita` — PCP production cycle
- `funcionario`, `folha_pagamento` — HR/payroll
- `ativo` — farm assets with depreciation

## Conventions

- Controller methods return `['sucesso' => bool, 'mensagem' => string]` for write operations.
- User-facing output always uses `htmlspecialchars()` to prevent XSS.
- The `estoque` module has two controller files: the stub `controller.php` and the full implementation `estoque_controller.php` — use `estoque_controller.php` as the reference for how controllers should be implemented.
- Branch naming convention: `feature/<module>` (e.g., `feature/estoque`).
