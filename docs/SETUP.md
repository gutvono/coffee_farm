# Guia de Configuração do Projeto Coffee Farm ERP

## 1. Objetivo do Projeto

O projeto **Coffee Farm ERP** é um sistema simples de gerenciamento empresarial (ERP) desenvolvido para auxiliar no controle da produção e venda de café arábica. Ele permite que estudantes universitários pratiquem o desenvolvimento de software modular, trabalhando em equipe para criar diferentes módulos do sistema. O foco é em um sistema monolítico (tudo em uma única aplicação), mas organizado de forma modular, onde cada módulo fica em sua própria pasta e funciona de maneira relativamente independente.

Os módulos principais incluem: estoque, compras, financeiro, faturamento, comercial, PCP (Planejamento e Controle da Produção) e folha de pagamento. O objetivo é simular um ambiente real de desenvolvimento colaborativo, ensinando conceitos como modularidade, integração de módulos e boas práticas de programação.

## 2. Tecnologias Utilizadas

Este projeto utiliza tecnologias básicas e acessíveis para estudantes iniciantes:

- **PHP puro**: Linguagem de programação do lado do servidor, sem frameworks (como Laravel ou Symfony). Usaremos apenas PHP nativo para manter a simplicidade.
- **HTML**: Para estruturar as páginas web.
- **CSS**: Para estilizar as páginas e torná-las visualmente agradáveis.
- **MySQL**: Banco de dados relacional para armazenar os dados do sistema.
- **Estrutura modular em monolito**: O sistema é uma única aplicação, mas dividido em módulos independentes dentro de pastas separadas.

Essas tecnologias foram escolhidas porque são fundamentais para o desenvolvimento web e fáceis de aprender. Não usaremos frameworks para que vocês possam entender o código desde o básico.

## 3. Como Instalar o Ambiente Local

Para executar o projeto localmente, você precisa de um servidor local que inclua Apache (servidor web), PHP e MySQL. Recomendamos usar uma das opções abaixo, que são fáceis de instalar e configurar:

### Opções de Servidores Locais:
- **XAMPP**: Gratuito e multiplataforma (Windows, macOS, Linux). Baixe em [apachefriends.org](https://www.apachefriends.org/).
- **Laragon**: Rápido e leve, ideal para Windows. Baixe em [laragon.org](https://laragon.org/).
- **WAMP**: Específico para Windows. Baixe em [wampserver.com](https://www.wampserver.com/).
- **Apache + PHP + MySQL manualmente**: Para usuários avançados, instale separadamente via gerenciadores de pacotes (como apt no Linux).

### Passos Gerais para Instalação:
1. Baixe e instale o software escolhido (XAMPP, Laragon, etc.).
2. Inicie o servidor: Abra o painel de controle do software e clique em "Start" para Apache e MySQL.
3. Verifique se está funcionando: Abra o navegador e acesse `http://localhost`. Você deve ver uma página de boas-vindas do servidor.

Dica: Se você é iniciante, comece com XAMPP, pois é o mais simples e tem tutoriais abundantes na internet.

## 4. Como Criar o Banco de Dados MySQL

O banco de dados armazenará todas as informações do ERP, como produtos, vendas, funcionários, etc.

### Passos:
1. Abra o painel de administração do MySQL. Dependendo do software:
   - XAMPP: Clique em "Admin" ao lado de MySQL no painel de controle, ou acesse `http://localhost/phpmyadmin`.
   - Laragon: Clique em "Database" no painel.
   - WAMP: Acesse `http://localhost/phpmyadmin`.

2. Faça login (usuário padrão: `root`, senha: vazia ou "root", dependendo da instalação).

3. Crie um novo banco de dados:
   - Clique em "Novo" ou "Create database".
   - Nomeie como `coffee_farm_erp` (ou outro nome de sua escolha, mas anote para usar no código).

4. O banco começará vazio. As tabelas serão criadas automaticamente quando você executar o código PHP do projeto (usando scripts de migração ou inicialização que serão desenvolvidos nos módulos).

Dica: Sempre faça backup do banco antes de alterações. Para estudantes, pratique criando tabelas simples via phpMyAdmin primeiro.

## 5. Como Configurar o Projeto no Servidor Local

### Passos:
1. **Baixe ou clone o projeto**: Coloque a pasta do projeto em um local acessível. Por exemplo, no XAMPP, a pasta padrão é `htdocs` (geralmente em `C:\xampp\htdocs` no Windows ou `/opt/lampp/htdocs` no Linux).

2. **Estrutura de pastas**: Certifique-se de que a estrutura do projeto seja algo como:
   ```
   coffee_farm/
   ├── docs/
   ├── modules/
   │   ├── estoque/
   │   ├── compras/
   │   ├── financeiro/
   │   ├── faturamento/
   │   ├── comercial/
   │   ├── pcp/
   │   └── folha_pagamento/
   ├── public/
   │   ├── index.php
   │   ├── css/
   │   └── js/
   ├── config/
   │   └── database.php
   └── README.md
   ```
   - `modules/`: Cada módulo tem sua própria pasta com arquivos PHP, HTML e CSS.
   - `public/`: Arquivos públicos acessíveis via navegador (página inicial, estilos).
   - `config/`: Configurações, como conexão com o banco.

3. **Configure a conexão com o banco**: Edite o arquivo `config/database.php` (você precisará criá-lo) com as credenciais do MySQL:
   ```php
   <?php
   $host = 'localhost';
   $user = 'root';
   $password = ''; // Deixe vazio se não houver senha
   $database = 'coffee_farm_erp';
   $conn = new mysqli($host, $user, $password, $database);
   if ($conn->connect_error) {
       die("Erro na conexão: " . $conn->connect_error);
   }
   ?>
   ```

4. **Permissões**: Certifique-se de que o servidor tenha permissões para ler/escrever na pasta do projeto.

Dica: Teste a conexão abrindo `localhost/coffee_farm/config/database.php` no navegador – se não houver erros, está funcionando.

## 6. Como Acessar o Sistema pelo Navegador

Após configurar tudo:
1. Certifique-se de que o servidor esteja rodando (Apache e MySQL ativos).
2. Abra o navegador e digite: `http://localhost/coffee_farm/public/index.php` (ou apenas `http://localhost/coffee_farm` se o index estiver na raiz).
3. Você verá a página inicial do sistema. Navegue pelos módulos clicando em links ou menus.

Dica: Se aparecer erro 404, verifique se a pasta está no local correto e se o arquivo `index.php` existe.

## 7. Estrutura Geral do Sistema (Explicação Conceitual)

O sistema é organizado como um **monolito modular**, ou seja, uma única aplicação grande, mas dividida em partes menores (módulos) que podem ser desenvolvidas independentemente por grupos de estudantes.

### Conceitos Chave:
- **Monolito**: Tudo roda em um só lugar, facilitando o desenvolvimento inicial.
- **Modular**: Cada módulo (estoque, compras, etc.) fica em sua pasta própria, com seus próprios arquivos PHP, HTML e CSS. Isso permite que equipes trabalhem sem interferir umas nas outras.
- **Integração**: Os módulos compartilham o mesmo banco de dados e podem chamar funções uns dos outros quando necessário (ex.: o módulo financeiro pode acessar dados do comercial).

### Estrutura de Pastas Explicada:
- `docs/`: Documentação, como este arquivo.
- `modules/`: Aqui ficam os módulos. Cada um tem subpastas como `controllers/`, `views/`, `models/` (seguindo o padrão MVC básico, mas opcional).
- `public/`: Arquivos acessíveis publicamente, como a página inicial e estilos globais.
- `config/`: Configurações globais, como banco de dados.

### Como os Módulos Funcionam:
- Cada módulo é como um "mini-aplicativo". Por exemplo, o módulo "estoque" gerencia produtos e quantidades.
- Eles se comunicam via banco de dados compartilhado.
- Para adicionar um módulo, crie uma nova pasta em `modules/` e integre links na página principal.

Este projeto é uma excelente oportunidade para aprender desenvolvimento web colaborativo. Comece pequeno: implemente um módulo básico e expanda aos poucos. Boa sorte!