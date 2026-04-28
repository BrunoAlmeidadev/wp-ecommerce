# ProductRoutes

**Namespace:** `WpEcommerceApi\Routes`  
**Tipo:** `final class`

A classe `ProductRoutes` realiza a vinculação dos caminhos REST do módulo de Produtos. Como um dos pontos de entrada iniciais do WordPress, essa classe expõe endpoints permitindo controle de restrição na chamada e direcionamento pro controller.

## Métodos

### `register`

Método responsável por inscrever as rotas da Entidade Produtos no router global REST.

```php
public static function register(ProductController $controller): void
```

**Parâmetros:**
- `$controller` (`ProductController`): A instância base de destino das invocações das rotas.

**Rotas Registradas:**

| Caminho (Endpoint com `api/v1`) | Métodos HTTP | Callback no Controller | Permissão (`permission_callback`) |
| :--- | :--- | :--- | :--- |
| `/products` | `GET` | `ProductController::list` | Qualquer Usuário (`__return_true`) |
| `/products` | `POST` | `ProductController::create` | Requer Usuário Logado (`is_user_logged_in`) |
| `/products/(?P<id>\d+)` | `GET` | `ProductController::getOne` | Qualquer Usuário (`__return_true`) |
| `/products/(?P<id>\d+)` | `DELETE` | `ProductController::delete` | Requer Usuário Logado (`is_user_logged_in`) |

**Observações:**
- Rotas de obtenção de um único produto requerem uma regex paramétrica para buscar um `$id` com valor inteiro (`(?P<id>\d+)`).
