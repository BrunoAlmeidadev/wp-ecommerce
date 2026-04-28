# UserService

**Namespace:** `WpEcommerceApi\Services`  
**Tipo:** `final class`

A classe `UserService` atua como a camada de serviço (Service Layer) para lidar com as regras de negócio relacionadas aos usuários. Ela coordena as ações usando o `UserRepository` e aplica validações antes de persistir os dados.

## Dependências

- `WpEcommerceApi\Repositories\UserRepository`: Injetado através do construtor. Usado para operações de leitura e persistência de dados no banco.

## Construtor

```php
public function __construct(private readonly UserRepository $repository)
```

## Métodos

### `registerUser`

Registra um novo usuário no sistema, aplicando as validações de regra de negócio, como verificação de e-mail e nome de usuário duplicados.

```php
public function registerUser(UserCreateDTO $dto): int
```

**Parâmetros:**
- `$dto` (`UserCreateDTO`): Objeto contendo os dados do novo usuário a ser criado.

**Retorno:**
- `int`: O ID numérico do usuário recém-criado.

**Exceções (`Exception`):**
- Lança exceção se o e-mail informado já existir no banco de dados (`'Email is already in use.'`).
- Lança exceção se o nome de usuário informado já existir (`'Username is already in use.'`).

---

### `getProfile`

Retorna os dados do perfil de um usuário específico, formatado como um array associativo.

```php
public function getProfile(int $userId): array
```

**Parâmetros:**
- `$userId` (`int`): O ID do usuário.

**Retorno:**
- `array`: Um array com os campos `id`, `username`, `email`, `firstName`, e `lastName`.

**Exceções (`Exception`):**
- Lança exceção se o usuário correspondente ao ID não for encontrado (`'User not found.'`).

---

### `updateProfile`

Atualiza os dados de perfil de um usuário. Verifica se o usuário que está sendo atualizado é o próprio usuário solicitante e garante que o novo e-mail (caso alterado) não esteja sendo usado por outra conta.

```php
public function updateProfile(UserUpdateDTO $dto, int $currentUserId): void
```

**Parâmetros:**
- `$dto` (`UserUpdateDTO`): DTO contendo os dados para atualização.
- `$currentUserId` (`int`): O ID do usuário que está autenticado e realizando a requisição, usado para garantia de segurança.

**Retorno:**
- `void`

**Exceções (`Exception`):**
- Lança exceção se o usuário tentar alterar um ID diferente do seu próprio (`'You can only update your own profile.'`).
- Lança exceção se o novo e-mail fornecido estiver em uso por outro usuário (`'Email is already in use by another account.'`).
