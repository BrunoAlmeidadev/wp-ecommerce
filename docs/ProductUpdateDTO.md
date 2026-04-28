# ProductUpdateDTO

**Namespace:** `WpEcommerceApi\DTOs`  
**Tipo:** `readonly class`

O `ProductUpdateDTO` é um Objeto de Transferência de Dados imutável utilizado para transportar os dados para atualização parcial ou total de um produto existente.

## Propriedades

| Nome | Tipo | Descrição |
| :--- | :--- | :--- |
| `$id` | `int` | O ID único do produto a ser atualizado. |
| `$sellerId` | `int` | O ID do vendedor associado ao produto, utilizado para validação de posse daquele item. |
| `$name` | `?string` | O novo nome do produto. |
| `$price` | `?float` | O novo preço do produto. |
| `$description` | `?string` | A nova descrição do produto. |
| `$imageIds` | `?array` | O novo array de IDs de imagens a serem vinculadas ao produto. |

> **Nota:** Todas as propriedades, exceto `$id` e `$sellerId`, são opcionais (`null`), indicando que apenas os campos que forem fornecidos na requisição deverão ser atualizados.

## Construtor

```php
public function __construct(
    public int $id,
    public int $sellerId,
    public ?string $name = null,
    public ?float $price = null,
    public ?string $description = null,
    public ?array $imageIds = null
)
```
