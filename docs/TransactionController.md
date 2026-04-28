# TransactionController

**Namespace:** `WpEcommerceApi\Controllers`  
**Tipo:** `final class`

A classe `TransactionController` trata as requisições HTTP REST provenientes da API voltadas para o fluxo de compra e para a visualização do histórico de transações do usuário.

## Dependências

- `WpEcommerceApi\Services\TransactionService`: Injetado através do construtor. Contém e processa a lógica central de validação, checkout e resgate do histórico de transações.

## Métodos

### `checkout`

Endpoint acionado pelo frontend no momento em que um usuário realiza a compra final do item.

```php
public function checkout(WP_REST_Request $request): WP_REST_Response
```

**Fluxo:**
1. Busca automaticamente o ID do usuário (comprador) na sessão logada da API via `get_current_user_id()`.
2. Verifica se o `shippingAddress` fornecido é um `array` válido, uma vez que será serializado em JSON pela repository.
3. Empacota os parâmetros num `TransactionCreateDTO` e o encaminha para o `TransactionService::checkout()`.

**Retorno:**
- `WP_REST_Response`:
    - Em caso de sucesso, Status 201 (`Created`) devolvendo um array com a propriedade `transactionId`.
    - Em caso de exceções no fluxo (Ex: item já vendido, etc), retorna Status 400 (`Bad Request`) contendo a mensagem do erro capturado.

---

### `myPurchases`

Endpoint para buscar o histórico de transações e visualizar as compras já efetuadas pelo usuário atual.

```php
public function myPurchases(WP_REST_Request $request): WP_REST_Response
```

**Retorno:**
- `WP_REST_Response`: Array das compras no formato de sucesso padrão (Status 200), ou Status 500 (`Internal Server Error`) caso ocorra falha.

---

### `mySales`

Endpoint para buscar o histórico e os dados das vendas efetuadas pelos produtos do usuário atual (compras onde os produtos dele foram vendidos para outros clientes).

```php
public function mySales(WP_REST_Request $request): WP_REST_Response
```

**Retorno:**
- `WP_REST_Response`: Array contendo as transações das vendas (Status 200) ou Status 500 no caso de erro inexperado.
