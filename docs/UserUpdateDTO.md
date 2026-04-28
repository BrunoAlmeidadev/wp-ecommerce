# UserUpdateDTO

**Namespace:** `WpEcommerceApi\DTOs`  
**Tipo:** `readonly class`

O `UserUpdateDTO` é um Objeto de Transferência de Dados (Data Transfer Object) imutável responsável por transportar os dados necessários para a atualização de um usuário existente.

## Propriedades

| Nome | Tipo | Descrição |
| :--- | :--- | :--- |
| `$id` | `int` | O ID (identificador único) do usuário que será atualizado. |
| `$email` | `string` | O novo endereço de e-mail do usuário. |
| `$firstName` | `string` | O novo primeiro nome do usuário. |
| `$lastName` | `string` | O novo sobrenome do usuário. |
| `$password` | `?string` | A nova senha do usuário. Opcional (padrão `null`), indicando que se não fornecida, a senha não será alterada. |

## Construtor

```php
public function __construct(
    public int $id,
    public string $email,
    public string $firstName,
    public string $lastName,
    public ?string $password = null
)
```

Inicializa o DTO com os dados necessários para atualização, onde apenas a senha é opcional.
