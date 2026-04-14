# Módulo de Planejamento e Controle de Produção (PCP)

O módulo de PCP é responsável por gerenciar e coordenar toda a cadeia de produção da fábrica para garantir que produtos sejam fabricados no prazo, com custo e qualidade planejados.

Neste projeto, o PCP foi estruturado como um módulo independente dentro de um monolito modular, expondo seus métodos através de uma camada de **service**, que funciona como um contrato interno para comunicação entre os módulos.

Isso significa que:

- Nenhum módulo deve acessar diretamente as tabelas de PCP no banco de dados  
- Todas as operações devem ser feitas através do **PcpService**  
- O módulo é responsável por garantir integridade, validações e regras de negócio relacionadas ao PCP  

A seguir, estão documentados os métodos disponíveis para consulta de dados de PCP, que servirão como base para as demais funcionalidades do sistema.

# Métodos do módulo PCP

<details>
<summary><strong>PCP.GET.ORDENS_PRODUCAO</strong></summary>

### Descrição
Retorna a lista completa de todas as ordens de produção existentes.

Esse método é utilizado para exibir a visão geral das ordens de produção, sendo normalmente usado em telas de listagem.

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
    "quantidade": float,
	"consumido": array?,
	"data_inicio": datetime,
	"data_conclusao": datetime,
	"status": string (PLANEJADA | PROCESSANDO | EMBALANDO | CONCLUIDA)
  }
]
```

---

### Regras de negócio

- Caso não existam ordens de produção, o array retornará vazio

---

### Exemplo de uso

```php
$ordensProducao = PcpService::getOrdensProducao();
```
</details>

<br>

<details>
<summary><strong>PCP.GET.ORDEM_PRODUCAO</strong></summary>

### Descrição
Retorna uma determinada ordem de produção.

Esse método é utilizado para exibir uma única ordens de produção, para que suas informações possam ser atualizadas.

---

### Parâmetros

- id (int) → Identificador da Ordem de Produção

---

### Retorno

```json
{
    "id": int,
    "quantidade": float,
	"consumido": array?,
	"data_inicio": datetime,
	"data_conclusao": datetime,
	"status": string (PLANEJADA | PROCESSANDO | EMBALANDO | CONCLUIDA)
}
```

---

### Regras de negócio

- Caso a ordem de produção determinada não exista, será retornado um erro

---

### Exemplo de uso

```php
$ordemProducao = PcpService::getOrdemProducao(id);
```
</details>
