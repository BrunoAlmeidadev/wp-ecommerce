# ProductCreateDTO

**Namespace:** `WpEcommerceApi\DTOs`  
**Tipo:** `readonly class`

O `ProductCreateDTO` é um Objeto de Transferência de Dados imutável utilizado para transportar os dados necessários durante o processo de criação de um novo produto no e-commerce.

## Propriedades

| Nome | Tipo | Descrição |
| :--- | :--- | :--- |
| `$sellerId` | `int` | O ID do usuário (vendedor) dono do produto. |
| `$name` | `string` | O nome/título do produto. |
| `$price` | `float` | O preço do produto. |
| `$description` | `string` | A descrição detalhada do produto. |
| `$imageIds` | `array` | Um array contendo os IDs dos anexos do WordPress (imagens) associados ao produto. (Opcional, padrão `[]`). |

## Construtor

```php
public function __construct(
    public int $sellerId,
    public string $name,
    public float $price,
    public string $description,
    public array $imageIds = []
)
```

Inicializa o DTO com os dados básicos do produto para criação.
