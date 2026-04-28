# TransactionRoutes

**Namespace:** `WpEcommerceApi\Routes`  
**Tipo:** `final class`

A classe `TransactionRoutes` registra no ecosistema do WordPress as rotas acessíveis via HTTP para interagir com o fluxo de checkout e listagem de transações passadas.

## Métodos

### `register`

Efetua o mapeamento (`register_rest_route`) declarando URLs, métodos HTTP aceitos e restrições de chamadas, unindo os *endpoints* com o seu respectivo *controller*.

```php
public static function register(TransactionController $controller): void
```

**Rotas Registradas:**

| Caminho (`api/v1`) | Verbo HTTP | Ação no Controller | Permissão de Acesso (`permission_callback`) |
| :--- | :--- | :--- | :--- |
| `/transactions` | `POST` | `TransactionController::checkout` | Usuário logado (`is_user_logged_in`) |
| `/transactions/purchases` | `GET` | `TransactionController::myPurchases` | Usuário logado (`is_user_logged_in`) |
| `/transactions/sales` | `GET` | `TransactionController::mySales` | Usuário logado (`is_user_logged_in`) |

**Observações sobre permissão:**
- Por tratar-se de fluxo financeiro ou que resgatam histórico associado diretamente a contas de usuários (vendedor/comprador), todos os três endpoints são restritos ao escopo logado (`is_user_logged_in`), significando que sem a devida autorização/cookie da API do WordPress a chamada será bloqueada prematuramente.
