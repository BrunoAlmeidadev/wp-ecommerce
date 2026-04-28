# UserRepository

**Namespace:** `WpEcommerceApi\Repositories`  
**Tipo:** `final class`

A classe `UserRepository` é responsável por encapsular as operações de acesso a dados (banco de dados) relacionadas aos usuários do WordPress, utilizando as funções nativas do núcleo do WordPress.

## Métodos

### `emailExists`

Verifica se um endereço de e-mail já está em uso por algum usuário.

```php
public function emailExists(string $email): bool
```

**Parâmetros:**
- `$email` (`string`): O e-mail a ser verificado.

**Retorno:**
- `bool`: Retorna `true` se o e-mail existir, ou `false` caso contrário.

---

### `usernameExists`

Verifica se um nome de usuário (login) já está registrado.

```php
public function usernameExists(string $username): bool
```

**Parâmetros:**
- `$username` (`string`): O nome de usuário a ser verificado.

**Retorno:**
- `bool`: Retorna `true` se o nome de usuário existir, ou `false` caso contrário.

---

### `create`

Cria um novo usuário no banco de dados do WordPress com a regra (`role`) de `customer`.

```php
public function create(UserCreateDTO $dto): int
```

**Parâmetros:**
- `$dto` (`UserCreateDTO`): O objeto de transferência de dados contendo os dados do novo usuário.

**Retorno:**
- `int`: O ID numérico do usuário recém-criado.

**Exceções:**
- Lança uma `Exception` se houver uma falha ao inserir o usuário (`is_wp_error`).

---

### `update`

Atualiza os dados de um usuário existente no banco de dados.

```php
public function update(UserUpdateDTO $dto): void
```

**Parâmetros:**
- `$dto` (`UserUpdateDTO`): O objeto de transferência de dados contendo o ID do usuário e as informações a serem atualizadas. A senha só será atualizada se o valor de `$password` não for nulo.

**Retorno:**
- `void`

**Exceções:**
- Lança uma `Exception` se houver uma falha ao atualizar o usuário (`is_wp_error`).

---

### `getById`

Busca um usuário do WordPress pelo seu ID único.

```php
public function getById(int $id): ?WP_User
```

**Parâmetros:**
- `$id` (`int`): O ID do usuário.

**Retorno:**
- `?WP_User`: O objeto `WP_User` com os dados do usuário, ou `null` caso o usuário não seja encontrado ou haja uma falha na busca.
