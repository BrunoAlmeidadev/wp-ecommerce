# TransactionRepository

**Namespace:** `WpEcommerceApi\Repositories`  
**Tipo:** `final class`

A classe `TransactionRepository` gerencia as interações diretas com o banco de dados referentes à entidade de Transação. Ela interage com a tabela customizada (prefixo dinâmico + `_ec_transactions`) utilizando a abstração nativa do banco do WordPress (`wpdb`).

## Dependências

- `wpdb`: Injetado pelo construtor para interação direta, sanitizada e segura com a base de dados MySQL.

## Construtor

```php
public function __construct(private readonly wpdb $db)
```

## Métodos

### `create`

Insere um novo registro de transação no banco de dados. O endereço de entrega (fornecido através de um array) é serializado com `wp_json_encode` antes da inserção.

```php
public function create(TransactionCreateDTO $dto, int $sellerId): int
```

**Parâmetros:**
- `$dto` (`TransactionCreateDTO`): O objeto de transferência contendo ID do comprador, ID do produto e o array do endereço de entrega.
- `$sellerId` (`int`): O ID do vendedor (dono original do produto). Passado explicitamente no momento da criação para o registro no banco.

**Retorno:**
- `int`: O ID numérico da transação criada (resgatado via `$this->db->insert_id`).

**Exceções (`Exception`):**
- Lança exceção se a inserção da transação no banco de dados falhar (`'Failed to insert transaction into database.'`).

---

### `getHistoryByRole`

Recupera todo o histórico de transações de um usuário específico, selecionando a coluna a ser verificada com base no "papel" que o usuário exerceu durante a transação (ou ele foi o `buyer` ou ele foi o `seller`).

```php
public function getHistoryByRole(int $userId, string $role): array
```

**Parâmetros:**
- `$userId` (`int`): O ID do usuário.
- `$role` (`string`): A regra exercida pelo usuário para essa busca (Por exemplo, string exata `'buyer'` ou `'seller'`). Se for `'buyer'`, a consulta usará a coluna `buyer_id`. Qualquer outro valor utilizará `seller_id`.

**Retorno:**
- `array`: Um array de objetos, onde cada objeto representa as informações de uma transação daquele usuário. O resultado é sempre ordenado pelas compras/vendas mais recentes (`created_at DESC`). Retorna um array vazio `[]` caso não existam resultados.
