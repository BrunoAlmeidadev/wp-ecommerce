# UserRoutes

**Namespace:** `WpEcommerceApi\Routes`  
**Tipo:** `final class`

A classe `UserRoutes` lida com o registro dos endpoints REST nativos do WordPress (`register_rest_route`) para o módulo de Usuários. Ela mapeia as URLs da API para os métodos correspondentes no `UserController`, além de definir permissões de acesso e métodos HTTP permitidos.

## Métodos

### `register`

Método estático responsável por registrar todas as rotas atreladas à entidade de Usuários.

```php
public static function register(UserController $controller): void
```

**Parâmetros:**
- `$controller` (`UserController`): A instância do controller que tratará as lógicas das requisições mapeadas.

**Rotas Registradas:**

| Rota Base (Namespace) | Caminho (Endpoint) | Métodos (Verbo) | Callback do Controller | Callback de Permissão |
| :--- | :--- | :--- | :--- | :--- |
| `api/v1` | `/users/register` | `POST` | `UserController::register` | `__return_true` (Público) |
| `api/v1` | `/users/me` | `GET` | `UserController::getProfile` | `is_user_logged_in` (Requer Autenticação) |
| `api/v1` | `/users/me` | `PUT` | `UserController::updateProfile` | `is_user_logged_in` (Requer Autenticação) |

**Observações:**
- O namespace principal de toda API rest descrita é definido como `api/v1`.
- Apenas a rota de criação de usuários é pública. Todas as rotas atreladas ao contexto atual do usuário (`/users/me`) necessitam que ele esteja logado em uma sessão válida (`is_user_logged_in`).
