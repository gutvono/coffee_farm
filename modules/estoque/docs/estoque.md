# Módulo de Estoque

## 1. Objetivo do Módulo

O módulo de **Estoque** é responsável por controlar todos os produtos e insumos disponíveis na fazenda. Ele registra entradas (quando um produto chega) e saídas (quando um produto é consumido ou vendido), mantendo sempre atualizado o saldo de cada item em estoque.

Em termos simples: o módulo de estoque é o "depósito digital" do sistema. Qualquer movimentação de produto passa por ele.

---

## 2. Responsabilidade do Estoque dentro do Sistema

Dentro do ERP Coffee Farm, o módulo de estoque tem as seguintes responsabilidades:

- **Cadastrar produtos**: Registrar os itens que compõem o estoque (ex.: sacas de café, fertilizantes, embalagens).
- **Controlar quantidades**: Manter o saldo atualizado de cada produto após cada entrada ou saída.
- **Registrar movimentações**: Guardar um histórico de todas as entradas e saídas, com data, quantidade e motivo.
- **Fornecer informações para outros módulos**: Outros módulos (como Compras, Faturamento e PCP) dependem do estoque para saber se há produto disponível antes de realizar operações.

O estoque é um dos módulos centrais do sistema. Sem ele funcionando corretamente, outros módulos não conseguem operar de forma confiável.

---

## 3. Regra Principal: O Estoque Não Pode Ser Alterado Diretamente no Banco

> ⚠️ **Regra fundamental**: nunca atualize o estoque diretamente no banco de dados (por exemplo, com um `UPDATE` ou `INSERT` manual). **Toda alteração no estoque deve passar obrigatoriamente pelo `EstoqueService`.**

### Por que essa regra existe?

Quando você altera o banco diretamente, você pula todas as verificações e regras de negócio que o sistema precisa aplicar. Por exemplo:

- Verificar se há saldo suficiente antes de uma saída.
- Registrar o histórico da movimentação.
- Notificar outros módulos que dependem do estoque.

Se cada parte do sistema fizer alterações diretas no banco, o estoque fica inconsistente e incontrolável.

### Como deve ser feito?

Toda operação que altera o estoque (entrada ou saída) deve chamar um método do `EstoqueService`. É ele quem aplica as regras, valida os dados e então grava no banco de forma segura e rastreável.

Essa abordagem é chamada de **camada de serviço** (*service layer*) e é uma boa prática de programação que mantém o código organizado e seguro.

---

## 4. Métodos Reutilizáveis do Módulo

O módulo de estoque foi projetado para ser **reutilizável por outros módulos**. Isso significa que ele expõe métodos públicos que qualquer outro módulo pode chamar para consultar ou movimentar o estoque.

Os principais métodos disponibilizados pelo `EstoqueService` são:

| Método                              | Descrição                                                  |
|-------------------------------------|------------------------------------------------------------|
| `registrarEntrada($produtoId, $qtd)` | Registra a entrada de uma quantidade de produto no estoque |
| `registrarSaida($produtoId, $qtd)`   | Registra a saída de uma quantidade de produto do estoque   |
| `consultarSaldo($produtoId)`         | Retorna o saldo atual de um produto no estoque             |
| `listarMovimentacoes($produtoId)`    | Lista o histórico de entradas e saídas de um produto       |

Outros módulos não precisam saber como o estoque funciona internamente. Eles apenas chamam esses métodos e recebem os resultados — isso é o que chamamos de **encapsulamento**.

---

## 5. Exemplo de Uso do EstoqueService em Outro Módulo

Imagine que o módulo de **Compras** acabou de confirmar o recebimento de 50 sacas de café. Ele precisa avisar o estoque para registrar essa entrada. Veja como isso seria feito:

```php
<?php
// Arquivo: modules/compras/backend/compras_service.php

// Inclui o serviço do módulo de estoque
require_once __DIR__ . '/../../estoque/backend/service/EstoqueService.php';

class ComprasService
{
    public function confirmarRecebimento(int $produtoId, int $quantidade): void
    {
        // Cria uma instância do EstoqueService
        $estoqueService = new EstoqueService();

        // Registra a entrada no estoque via service (nunca direto no banco!)
        $estoqueService->registrarEntrada($produtoId, $quantidade);

        echo "Recebimento confirmado e estoque atualizado com sucesso!";
    }
}
```

### O que está acontecendo aqui?

1. O módulo de Compras **inclui** o arquivo do `EstoqueService` usando `require_once`.
2. Cria uma **instância** do serviço: `new EstoqueService()`.
3. Chama o método `registrarEntrada()` passando o ID do produto e a quantidade recebida.
4. O `EstoqueService` é quem cuida de **verificar as regras** e **gravar no banco**.

Repare que o módulo de Compras **não acessa o banco de dados do estoque diretamente**. Ele apenas "pede" ao EstoqueService para fazer o trabalho. Essa separação de responsabilidades torna o código mais fácil de manter e menos propenso a erros.

---

## Resumo

| Conceito                  | Explicação rápida                                                    |
|---------------------------|----------------------------------------------------------------------|
| Objetivo                  | Controlar entradas e saídas de produtos do estoque da fazenda        |
| Responsabilidade          | Manter saldo atualizado e fornecer dados para outros módulos         |
| Regra principal           | Nunca altere o estoque direto no banco — use sempre o EstoqueService |
| Métodos disponíveis       | registrarEntrada, registrarSaida, consultarSaldo, listarMovimentacoes|
| Integração com módulos    | Outros módulos chamam o EstoqueService para movimentar o estoque     |

> 💡 **Dica para iniciantes**: pense no `EstoqueService` como um "caixa de banco". Você não pode abrir o cofre sozinho — precisa pedir ao caixa, que segue os procedimentos corretos antes de liberar qualquer operação.
