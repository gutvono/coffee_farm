# Módulo de Estoque

O módulo de estoque é responsável pelo controle centralizado de produtos, quantidades disponíveis e movimentações dentro do sistema.

Ele atua como uma base para diversos outros módulos, como compras, vendas e produção, garantindo que todas as operações que impactam o estoque sejam realizadas de forma consistente e controlada.

Neste projeto, o estoque foi estruturado como um módulo independente dentro de um monolito modular, expondo seus métodos através de uma camada de **service**, que funciona como um contrato interno para comunicação entre os módulos.

Isso significa que:

- Nenhum módulo deve acessar diretamente as tabelas de estoque no banco de dados  
- Todas as operações devem ser feitas através do **EstoqueService**  
- O módulo é responsável por garantir integridade, validações e regras de negócio relacionadas ao estoque  

A seguir, estão documentados os métodos disponíveis para consulta de dados de estoque, que servirão como base para as demais funcionalidades do sistema.

# Métodos do módulo ESTOQUE

<details>
<summary><strong>ESTOQUE.GET.PRODUTOS</strong></summary>

### Descrição
Retorna a lista completa de produtos cadastrados no sistema com suas respectivas informações de estoque.

Esse método é utilizado para exibir a visão geral do estoque, sendo normalmente usado em telas de listagem.

---

### Parâmetros
Nenhum.

---

### Retorno

Array de objetos contendo:

```json
[
  {
    "id": int,
    "nome": string,
    "tipo": string (INSUMO | PRODUTO),
    "quantidade": float,
    "unidade_medida": string
  }
]
```

---

### Regras de negócio

- Apenas produtos ativos devem ser retornados
- A quantidade deve refletir o saldo atual do estoque
- Caso não existam produtos, o array retornará vazio

---

### Exemplo de uso

```php
$produtos = EstoqueService::getProdutos();
```
</details>

<br>

<details>
<summary><strong>ESTOQUE.GET.PRODUTO</strong></summary>

### Descrição
Retorna a lista completa de produtos cadastrados no sistema com suas respectivas informações de estoque.

Esse método é utilizado para exibir a visão geral do estoque, sendo normalmente usado em telas de listagem.

---

### Parâmetros
Nenhum.

---

### Retorno

Array de objetos contendo:

```json
[
  {
    "id": int,
    "nome": string,
    "tipo": string (INSUMO | PRODUTO),
    "quantidade": float,
    "unidade_medida": string
  }
]
```

---

### Regras de negócio

- Apenas produtos ativos devem ser retornados
- A quantidade deve refletir o saldo atual do estoque
- Caso não existam produtos, retornar array vazio

---

### Exemplo de uso

```php
$produtos = EstoqueService::getProdutos();
```
</details>

<br>

<details>
<summary><strong>ESTOQUE.GET.SALDO</strong></summary>

### Descrição
Retorna o saldo atual disponível em estoque para um determinado produto.

Esse método é essencial para validações antes de movimentações como saída ou venda.

---

### Parâmetros

- produtoId (int) → Identificador do produto

---

### Retorno

```json
{
  "produtoId": int,
  "saldo": float
}
```

---

### Regras de negócio

- O saldo deve considerar todas as movimentações (entrada e saída)
- Não pode retornar valores negativos
- Caso o produto não exista, retornar erro ou saldo zero (definir padrão)

---

### Exemplo de uso

```php
$saldo = EstoqueService::getSaldo(1);
```
</details>

<br>

<details>
<summary><strong>ESTOQUE.GET.SALDO.POR_DEPOSITO</strong></summary>

### Descrição
Retorna o saldo de um produto em um depósito específico.

Utilizado quando há controle de estoque por localização.

---

### Parâmetros

- produtoId (int)
- depositoId (int)

---

### Retorno

```json
{
  "produtoId": int,
  "depositoId": int,
  "saldo": float
}
```

---

### Regras de negócio

- O depósito deve existir
- O produto deve existir
- Se não houver saldo, retornar 0

---

### Exemplo de uso

```php
$saldo = EstoqueService::getSaldoPorDeposito(1, 2);
```
</details>

<br>

<details>
<summary><strong>ESTOQUE.GET.MOVIMENTACOES</strong></summary>

### Descrição
Retorna o histórico de movimentações de um produto.

Permite visualizar entradas, saídas, ajustes e transferências.

---

### Parâmetros

- produtoId (int)

---

### Retorno

Array:

```json
[
  {
    "id": int,
    "tipo": string (ENTRADA | SAIDA | AJUSTE | TRANSFERENCIA),
    "quantidade": float,
    "data": datetime,
    "origem": string
  }
]
```

---

### Regras de negócio

- Ordenar por data (mais recente primeiro)
- Deve retornar todas as movimentações do produto
- Pode ser filtrado futuramente por período

---

### Exemplo de uso

```php
$movimentacoes = EstoqueService::getMovimentacoes(1);
```
</details>

<br>

<details>
<summary><strong>ESTOQUE.GET.DEPOSITOS</strong></summary>

### Descrição
Retorna todos os depósitos cadastrados no sistema.

Utilizado para seleção de localização de estoque.

---

### Parâmetros
Nenhum.

---

### Retorno

Array:

```json
[
  {
    "id": int,
    "nome": string,
    "localizacao": string
  }
]
```

---

### Regras de negócio

- Retornar apenas depósitos ativos
- Caso não existam, retornar lista vazia

---

### Exemplo de uso

```php
$depositos = EstoqueService::getDepositos();
```