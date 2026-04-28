# ProductService

**Namespace:** `WpEcommerceApi\Services`  
**Tipo:** `final class`

A classe `ProductService` atua como a camada de serviço (Service Layer) para lidar com a regra de negócio relacionada aos produtos do e-commerce. Ela coordena as ações usando o `ProductRepository`, processa o envio de arquivos (imagens) usando métodos nativos do WordPress e formata a resposta antes de enviá-la para o controller.

## Dependências

- `WpEcommerceApi\Repositories\ProductRepository`: Injetado pelo construtor. Responsável pelo acesso aos dados dos produtos no banco.

## Construtor

```php
public function __construct(private readonly ProductRepository $repository)
```

## Métodos Públicos

### `createProduct`

Cria um novo produto e imediatamente retorna os dados dele formatados.

```php
public function createProduct(ProductCreateDTO $dto): object
```

**Parâmetros:**
- `$dto` (`ProductCreateDTO`): O objeto contendo os dados básicos e o array de IDs de imagens.

**Retorno:**
- `object`: O produto formatado (incluindo as URLs das imagens resolvidas).

---

### `getProductById`

Busca um produto específico pelo ID e aplica a formatação para exposição na API.

```php
public function getProductById(int $id): object
```

**Parâmetros:**
- `$id` (`int`): O ID numérico do produto.

**Retorno:**
- `object`: Objeto do produto formatado.

**Exceções (`Exception`):**
- Lança exceção se o produto não for encontrado (`'Product not found.'`).

---

### `listProducts`

Retorna a lista paginada e opcionalmente filtrada de produtos, formatando também as imagens de cada resultado.

```php
public function listProducts(int $page, int $limit, string $search, int $sellerId): array
```

**Retorno:**
- `array`: Um array associativo contendo `data` (lista de produtos) e `total` (quantidade absoluta sem paginação).

---

### `deleteProduct`

Remove um produto do banco de dados e também exclui definitivamente todos os arquivos físicos e anexos (`posts` do tipo `attachment`) vinculados àquele produto usando a função wp_delete_attachment.

```php
public function deleteProduct(int $productId, int $currentUserId): void
```

**Parâmetros:**
- `$productId` (`int`): ID do produto.
- `$currentUserId` (`int`): ID do usuário tentando a exclusão.

**Exceções (`Exception`):**
- Lança exceção se o produto não existir.
- Lança exceção se o ID do dono do produto não corresponder ao `$currentUserId` (`'You do not have permission to delete this product.'`).

---

### `uploadImages`

Processa e faz upload de arquivos recebidos via formulário (`multipart/form-data`) através da superglobal `$_FILES`, utilizando os arquivos de administração de mídias (`media_handle_upload`) nativos do WordPress.

```php
public function uploadImages(): array
```

**Retorno:**
- `array`: Lista de inteiros correspondentes aos IDs dos anexos recém-criados.

## Métodos Privados

### `formatProductOutput`

Transforma a propriedade genérica `images` (que contêm apenas os IDs do repositório) gerando a URL real das imagens no tamanho `large` (`wp_get_attachment_image_url`), formatando sua saída de uma maneira adequada e amigável para retorno JSON.

```php
private function formatProductOutput(object $product): object
```
