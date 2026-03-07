# Coffee Farm ERP

## 1. Descrição do Projeto

O **Coffee Farm ERP** é um sistema simples de gerenciamento empresarial (ERP) desenvolvido especificamente para uma fazenda de café arábica. Ele permite controlar todo o ciclo de produção e venda do café, desde o plantio até a comercialização, de forma integrada e modular. O sistema é construído como um monolito modular, onde cada módulo funciona de maneira relativamente independente, facilitando o desenvolvimento colaborativo por estudantes.

## 2. Objetivo Educacional

Este projeto tem como objetivo principal ensinar conceitos de desenvolvimento de software em equipe, utilizando tecnologias web básicas. Estudantes podem praticar:

- Desenvolvimento modular em PHP.
- Integração com banco de dados MySQL.
- Estruturação de aplicações web (frontend e backend).
- Boas práticas de programação, versionamento e colaboração.

É ideal para cursos de programação, engenharia de software ou sistemas de informação, permitindo que grupos de estudantes desenvolvam módulos específicos e integrem seus trabalhos.

## 3. Tecnologias Utilizadas

- **PHP**: Linguagem de programação do lado servidor, usada para lógica de negócio e interação com o banco.
- **HTML**: Estrutura das páginas web.
- **CSS**: Estilização das interfaces.
- **MySQL**: Banco de dados relacional para armazenamento de dados.

Nenhuma framework é utilizada, mantendo o foco em conceitos fundamentais.

## 4. Estrutura de Pastas do Projeto

```
coffee_farm/
├── config/
│   └── database.php          # Configuração da conexão com o banco MySQL
├── database/
│   └── schema.sql            # Script SQL para criação das tabelas
├── docs/
│   └── SETUP.md              # Documentação de configuração e instalação
├── modules/                  # Módulos do sistema
│   ├── estoque/
│   │   ├── backend/
│   │   │   ├── controller.php
│   │   │   └── repository.php
│   │   └── frontend/
│   │       ├── index.php
│   │       ├── entrada.php
│   │       ├── saida.php
│   │       └── style.css
│   ├── compras/
│   │   ├── backend/
│   │   │   ├── controller.php
│   │   │   └── repository.php
│   │   └── frontend/
│   │       ├── index.php
│   │       └── style.css
│   ├── financeiro/
│   │   ├── backend/
│   │   │   ├── controller.php
│   │   │   └── repository.php
│   │   └── frontend/
│   │       ├── index.php
│   │       └── style.css
│   ├── faturamento/
│   │   ├── backend/
│   │   │   ├── controller.php
│   │   │   └── repository.php
│   │   └── frontend/
│   │       ├── index.php
│   │       └── style.css
│   ├── comercial/
│   │   ├── backend/
│   │   │   ├── controller.php
│   │   │   └── repository.php
│   │   └── frontend/
│   │       ├── index.php
│   │       └── style.css
│   ├── pcp/
│   │   ├── backend/
│   │   │   ├── controller.php
│   │   │   └── repository.php
│   │   └── frontend/
│   │       ├── index.php
│   │       └── style.css
│   └── folha/
│       ├── backend/
│       │   ├── controller.php
│       │   │   └── repository.php
│       └── frontend/
│           ├── index.php
│           └── style.css
├── shared/                   # Arquivos compartilhados
│   ├── header.php            # Cabeçalho HTML
│   ├── menu.php              # Menu de navegação
│   ├── footer.php            # Rodapé HTML
│   └── style.css             # Estilos globais
└── index.php                 # Página inicial do sistema
```

## 5. Módulos do Sistema

O sistema é dividido em 7 módulos independentes:

- **Estoque**: Controle de entrada e saída de produtos (café e insumos).
- **Compras**: Gerenciamento de pedidos de compra a fornecedores.
- **Financeiro**: Controle de contas a pagar e receber.
- **Faturamento**: Emissão e controle de faturas de vendas.
- **Comercial**: Gestão de vendas e clientes.
- **PCP (Planejamento e Controle da Produção)**: Controle do ciclo de produção do café (plantio, colheita).
- **Folha de Pagamento**: Gestão de salários e funcionários.

Cada módulo tem sua própria pasta com backend (controller e repository) e frontend (páginas HTML/PHP e CSS).

## 6. Como Rodar o Projeto Localmente

1. **Instale um servidor local**:
   - Recomendado: XAMPP, Laragon ou WAMP.
   - Certifique-se de que Apache e MySQL estejam ativos.

2. **Clone ou baixe o projeto**:
   - Coloque a pasta `coffee_farm` na raiz do servidor (ex: `htdocs` no XAMPP).

3. **Configure o PHP**:
   - Certifique-se de que o PHP está configurado para conectar ao MySQL.

4. **Acesse o sistema**:
   - Abra o navegador e vá para `http://localhost/coffee_farm/index.php`.

Para mais detalhes, consulte `docs/SETUP.md`.

## 7. Como Criar o Banco de Dados

1. Abra o painel de administração do MySQL (ex: phpMyAdmin em `http://localhost/phpmyadmin`).

2. Crie um banco de dados chamado `coffee_farm_erp` (ou ajuste em `config/database.php`).

3. Execute o script `database/schema.sql` no banco criado. Isso criará todas as tabelas necessárias.

4. Insira dados de exemplo manualmente via phpMyAdmin, se necessário (ex: produtos, clientes).

## 8. Como Acessar os Módulos

- Na página inicial (`index.php`), use o menu para navegar entre os módulos.
- Cada módulo tem uma página principal (ex: `modules/estoque/frontend/index.php`).
- O menu global permite acesso rápido a todos os módulos.

Exemplo: Para acessar Estoque, clique em "Estoque" no menu.

## 9. Regras para Contribuição dos Estudantes

- **Versionamento**: Use Git para controle de versão. Crie branches para cada módulo (ex: `feature/estoque`).
- **Commits**: Faça commits descritivos (ex: "Adiciona funcionalidade de entrada no estoque").
- **Código**: Mantenha o código simples, comentado e seguindo a estrutura (backend/frontend).
- **Testes**: Teste localmente antes de commitar. Evite quebrar funcionalidades existentes.
- **Colaboração**: Discuta mudanças em grupo. Cada estudante pode focar em um módulo.
- **Pull Requests**: Use para integrar mudanças, com revisões.

## 10. Exemplo de Fluxo do Sistema (Produção de Café até Venda)

1. **Planejamento (PCP)**: Registre áreas de plantio e ordens de produção.
2. **Produção**: Acompanhe o crescimento e registre colheitas.
3. **Estoque**: Armazene o café colhido e controle quantidades.
4. **Vendas (Comercial)**: Cadastre clientes e crie pedidos de venda.
5. **Faturamento**: Emita faturas para os pedidos.
6. **Financeiro**: Controle contas a receber (pagamentos dos clientes) e a pagar (compras de insumos).
7. **Compras**: Solicite insumos necessários para a produção.
8. **Folha de Pagamento**: Gerencie salários dos funcionários envolvidos no processo.

Esse fluxo integrado permite um controle completo da fazenda, do plantio à venda final.

---

**Contato/Suporte**: Para dúvidas, consulte a documentação em `docs/` ou entre em contato com o orientador do projeto.