# UserController

**Namespace:** `WpEcommerceApi\Controllers`  
**Tipo:** `final class`

A classe `UserController` é responsável por gerenciar as requisições HTTP da API REST (endpoints) referentes aos usuários. Ela recebe o request (`WP_REST_Request`), sanitiza os dados de entrada, repassa a execução para a camada de serviço (`UserService`) e devolve a resposta adequada (no formato `WP_REST_Response`) com auxílio da classe `ApiResponse`.

## Dependências

- `WpEcommerceApi\Services\UserService`: Injetado pelo construtor. Usado para execução das regras de negócio.

## Construtor

```php
public function __construct(private readonly UserService $service)
```

## Métodos

### `register`

Endpoint responsável por registrar (criar) um novo usuário.

```php
public function register(WP_REST_Request $request): WP_REST_Response
```

**Parâmetros:**
- `$request` (`WP_REST_Request`): O objeto da requisição HTTP do WordPress. Recupera do corpo da requisição os parâmetros `username`, `email`, `password`, `firstName` e `lastName`, realizando as sanitizações adequadas (como `sanitize_text_field` e `sanitize_email`).

**Retorno:**
- `WP_REST_Response`:
    - **Sucesso (201 Created):** Retorna o ID do usuário criado na chave `id`.
    - **Erro (Bad Request/Internal):** Mensagem de erro capturada da exceção da Service.

---

### `getProfile`

Endpoint que busca e retorna os detalhes do perfil do usuário logado que realizou a requisição.

```php
public function getProfile(WP_REST_Request $request): WP_REST_Response
```

**Parâmetros:**
- `$request` (`WP_REST_Request`): Objeto da requisição.

**Retorno:**
- `WP_REST_Response`:
    - **Sucesso (200 OK):** Retorna um array de propriedades do perfil obtidas do `UserService`.
    - **Erro (404 Not Found):** Retorna mensagem de erro (Ex: caso o usuário não seja encontrado na base de dados).

---

### `updateProfile`

Endpoint para que o usuário autenticado consiga atualizar seus próprios dados.

```php
public function updateProfile(WP_REST_Request $request): WP_REST_Response
```

**Parâmetros:**
- `$request` (`WP_REST_Request`): Objeto da requisição contendo possivelmente `email`, `firstName`, `lastName` e `password` para edição. Novamente, são aplicadas regras de sanitização do WordPress ao resgatar esses dados.

**Retorno:**
- `WP_REST_Response`:
    - **Sucesso (200 OK):** Retorna sucesso com `null` de payload de dados, e a mensagem `'Profile updated successfully'`.
    - **Erro (403 Forbidden):** Caso ocorra falha nas validações de negócio, devolvendo o status 403 e a mensagem de erro da Exceção.
