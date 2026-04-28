# UserCreateDTO

**Namespace:** `WpEcommerceApi\DTOs`  
**Tipo:** `readonly class`

O `UserCreateDTO` é um Objeto de Transferência de Dados (Data Transfer Object) imutável responsável por transportar os dados necessários para a criação de um novo usuário.

## Propriedades

| Nome | Tipo | Descrição |
| :--- | :--- | :--- |
| `$username` | `string` | O nome de usuário (login) do novo usuário. |
| `$email` | `string` | O endereço de e-mail do novo usuário. |
| `$password` | `string` | A senha do novo usuário em texto plano. |
| `$firstName` | `string` | O primeiro nome do usuário. |
| `$lastName` | `string` | O sobrenome do usuário. |

## Construtor

```php
public function __construct(
    public string $username,
    public string $email,
    public string $password,
    public string $firstName,
    public string $lastName
)
```

Inicializa o DTO com os dados obrigatórios para criação de um usuário.
