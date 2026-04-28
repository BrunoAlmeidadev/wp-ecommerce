# TransactionService

**Namespace:** `WpEcommerceApi\Services`  
**Tipo:** `final class`

A classe `TransactionService` é responsável pela lógica de negócios envolvendo as transações (compras). Ela orquestra chamadas entre o repositório de transações e o repositório de produtos, mantendo a coerência dos dados e regras aplicáveis.

## Dependências

- `WpEcommerceApi\Repositories\TransactionRepository`: Necessário para persistir os registros de transações no banco de dados.
- `WpEcommerceApi\Repositories\ProductRepository`: Necessário para verificar o estado (disponibilidade) do produto e atualizar o seu status no momento em que é comprado.

## Construtor

```php
public function __construct(
    private readonly TransactionRepository $transactionRepository,
    private readonly ProductRepository $productRepository
)
```

## Métodos

### `checkout`

Realiza o processo de compra de um produto. Valida as regras de negócio associadas à venda, registra a transação com os dados do comprador e do vendedor e marca o produto como vendido.

```php
public function checkout(TransactionCreateDTO $dto): int
```

**Fluxo de Validação:**
1. Recupera as informações do produto pelo ID informado. Se não existir, aborta com erro.
2. Verifica se o status do produto é estritamente `available`. Se for diferente (ex: `sold`), significa que o produto não pode mais ser comprado.
3. Certifica que o usuário comprador não está tentando comprar um produto onde ele mesmo seja o vendedor.

**Parâmetros:**
- `$dto` (`TransactionCreateDTO`): O Objeto contendo os dados essenciais da nova transação (comprador, produto, endereço).

**Retorno:**
- `int`: O ID numérico da transação criada com sucesso na base.

**Exceções (`Exception`):**
- `'Product not found.'`: Produto inválido.
- `'This product is already sold.'`: Tentativa de compra de um produto já vendido.
- `'You cannot buy your own product.'`: Fraude ou ação não permitida pelo mesmo usuário.

---

### `getBuyerHistory`

Retorna o histórico de compras de um determinado usuário.

```php
public function getBuyerHistory(int $buyerId): array
```

---

### `getSellerHistory`

Retorna o histórico de vendas de um determinado usuário.

```php
public function getSellerHistory(int $sellerId): array
```
