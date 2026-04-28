# TransactionCreateDTO

**Namespace:** `WpEcommerceApi\DTOs`  
**Tipo:** `readonly class`

O `TransactionCreateDTO` é um Objeto de Transferência de Dados imutável utilizado para transportar os dados necessários durante a criação de uma nova transação (compra) no sistema.

## Propriedades

| Nome | Tipo | Descrição |
| :--- | :--- | :--- |
| `$buyerId` | `int` | O ID numérico do usuário (comprador) que está efetuando a transação. |
| `$productId` | `int` | O ID do produto que está sendo comprado. |
| `$shippingAddress` | `array` | Um array contendo as informações detalhadas do endereço de entrega. |

## Construtor

```php
public function __construct(
    public int $buyerId,
    public int $productId,
    public array $shippingAddress
)
```

Inicializa o DTO com os dados básicos da transação de compra.
