# App

**Namespace:** `WpEcommerceApi`  
**Tipo:** `final class`

A classe `App` atua como a classe raiz ou o núcleo (Bootstrap) de inicialização de toda a arquitetura de funcionalidades da API do plugin. Ela registra o gatilho principal e cumpre o papel básico de um Contêiner de Injeção de Dependência (DI Container), acoplando os componentes necessários e as rotas.

## Métodos

### `init`

Ponto de partida central de tudo. Deve ser executado (ex: `App::init();`) a partir do arquivo principal do plugin do WordPress.

```php
public static function init(): void
```

**Funcionamento:**
- Adiciona uma `action` para o evento `rest_api_init` do WordPress, chamando o método `registerRoutes` desta mesma classe. Assim, garante-se que os endpoints personalizados sejam expostos somente no momento adequado durante o ciclo de vida do carregamento do WordPress.

---

### `registerRoutes`

Responsável por compilar as instâncias (Controllers, Services e Repositórios), montando suas dependências em cascata, e disparando o registro global de todas as suas rotas na REST API.

```php
public static function registerRoutes(): void
```

**Fluxo de Construção de Componentes:**
1. A variável global de conexão do banco de dados do WordPress (`global $wpdb`) é carregada, pois será injetada e compartilhada entre os Repositórios da camada de abstração de dados.
2. **Ciclo de Usuários (`Users`)**:
   - Inicializa `UserRepository` (Repositório que usa as funções diretas de usuário e não `$wpdb`).
   - Inicializa `UserService` repassando o seu repositório.
   - Inicializa `UserController` repassando seu respectivo service.
   - O array é entregue ao `UserRoutes::register`, que vincula tudo isso as URLs do sistema.
3. **Ciclo de Produtos (`Products`)**:
   - Inicializa `ProductRepository` recebendo `$wpdb`.
   - Inicializa `ProductService` recebendo seu respectivo repositório.
   - Inicializa `ProductController` recebendo seu respectivo service.
   - Associa as URLs via `ProductRoutes::register`.
4. **Ciclo de Transações (`Transactions`)**:
   - Inicializa `TransactionRepository` recebendo a global `$wpdb`.
   - Inicializa `TransactionService`, que necessita tanto do Repositório de Transações quanto do Repositório de Produtos (para verificar status e marcar o mesmo como vendido).
   - Inicializa `TransactionController` recebendo a service preparada.
   - Por fim, registra as transações no banco de URLs via `TransactionRoutes::register`.
