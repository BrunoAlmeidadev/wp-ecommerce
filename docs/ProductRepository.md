# ProductRepository

**Namespace:** `WpEcommerceApi\Repositories`  
**Tipo:** `final class`

A classe `ProductRepository` encapsula todas as interações diretas com o banco de dados referentes à entidade Produto e suas imagens associadas. Ela gerencia o acesso às tabelas customizadas (ex: tabela com prefixo dinâmico `_ec_products` e `_ec_product_images`), utilizando a classe global de abstração de dados do WordPress (`wpdb`).

## Dependências

- `wpdb`: Injetado via construtor para possibilitar a interação direta e segura com o banco de dados SQL (via `$this->db->prepare`, `$this->db->insert`, etc.).

## Construtor

```php
public function __construct(private readonly wpdb $db)
```

## Métodos Públicos

### `create`

Insere um novo produto no banco de dados, configurando o status inicial como `available` (disponível), e sincroniza suas imagens caso sejam fornecidas via DTO.

```php
public function create(ProductCreateDTO $dto): int
```

**Parâmetros:**
- `$dto` (`ProductCreateDTO`): O DTO contendo os detalhes básicos do produto e as imagens.

**Retorno:**
- `int`: O ID numérico do produto recém-criado na base.

**Exceções (`Exception`):**
- Lança exceção se a inserção do registro principal do produto falhar (`'Failed to insert product into database.'`).

---

### `getById`

Busca os detalhes completos de um produto pelo seu ID, anexando também as informações referentes às imagens vinculadas a ele.

```php
public function getById(int $id): ?object
```

**Parâmetros:**
- `$id` (`int`): O ID do produto no banco.

**Retorno:**
- `?object`: Um objeto representando a linha do banco de dados (retorno do `$this->db->get_row()`), incluindo uma propriedade dinamicamente injetada `images` com a lista de imagens, ou `null` caso o produto não exista.

---

### `delete`

Deleta permanentemente um produto e todas as suas associações de imagens da base de dados nas tabelas customizadas.

```php
public function delete(int $id): void
```

**Parâmetros:**
- `$id` (`int`): O ID do produto a ser deletado.

---

### `listProducts`

Retorna uma listagem paginada de produtos, podendo aplicar filtros de busca por nome ou por ID do vendedor. Apenas produtos com o status `available` são retornados.

```php
public function listProducts(int $page = 1, int $limit = 10, string $search = '', int $sellerId = 0): array
```

**Parâmetros:**
- `$page` (`int`): A página atual de listagem (1-index).
- `$limit` (`int`): Quantidade máxima de resultados (limite da query).
- `$search` (`string`): Termo opcional que será pesquisado usando o operador `LIKE` no campo `name` do produto.
- `$sellerId` (`int`): ID do vendedor; se for maior que `0`, filtra a lista retornando apenas os produtos daquele vendedor.

**Retorno:**
- `array`: Um array associativo contendo duas propriedades:
  - `data`: Array com os objetos dos produtos.
  - `total`: Total absoluto de resultados possíveis, ignorando a paginação (`SQL_CALC_FOUND_ROWS`).

---

### `getImagesIds`

Recupera um array simples de inteiros com os IDs de imagens (anexos) relacionados ao produto, lendo da tabela de junção `_ec_product_images`.

```php
public function getImagesIds(int $productId): array
```

**Parâmetros:**
- `$productId` (`int`): O ID do produto pai.

**Retorno:**
- `array`: Um array de IDs inteiros (ex: `[12, 18, 55]`).

---

### `markAsSold`

Atualiza o status de um produto específico para `sold` (vendido), indicando que ele não está mais disponível para novas compras, e atualiza sua data de modificação (`updated_at`).

```php
public function markAsSold(int $id): void
```

**Parâmetros:**
- `$id` (`int`): O ID numérico do produto a ser marcado como vendido.

## Métodos Privados

### `syncImages`

Responsável por sincronizar (vincular) IDs de imagens a um produto. A estratégia adotada é deletar todas as relações existentes e inserir as novas com base no array repassado, respeitando a sua ordem.

```php
private function syncImages(int $productId, array $imageIds): void
```

---

### `getImagesData`

Recupera uma lista de objetos contendo os dados das imagens atreladas a um produto (`wp_attachment_id` e `image_order`), trazendo-os devidamente ordenados pela coluna de ordenação.

```php
private function getImagesData(int $productId): array
```
