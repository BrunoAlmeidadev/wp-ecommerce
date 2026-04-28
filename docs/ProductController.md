# ProductController

**Namespace:** `WpEcommerceApi\Controllers`  
**Tipo:** `final class`

A classe `ProductController` gerencia o recebimento e o tratamento das requisições REST da API relacionadas à entidade de Produtos. Interage primariamente com o `ProductService`.

## Dependências

- `WpEcommerceApi\Services\ProductService`: Injetado pelo construtor. Realiza as lógicas, requisições de sistema e processamento.

## Construtor

```php
public function __construct(private readonly ProductService $service)
```

## Métodos

### `create`

Endpoint para criação de um novo produto (suporta envio de variáveis form-data devido ao suporte de upload de arquivos binários integrados).

```php
public function create(WP_REST_Request $request): WP_REST_Response
```

**Fluxo:**
1. Resgata o ID do usuário (vendedor) que fez a chamada na API (`get_current_user_id()`).
2. Tenta fazer upload das imagens através do serviço e recupera um array contendo os IDs dos anexos gerados no painel.
3. Cria o `ProductCreateDTO` sanitizando os dados vindos do `$request`.
4. Chama o Service para persistir e devolver a resposta.

**Retorno:**
- `WP_REST_Response`: Sucesso `201 Created` retornando o objeto final; ou Status 500 (Erro Interno) na falha.

---

### `list`

Endpoint genérico para recuperar uma lista paginada e filtrada de múltiplos produtos (tipo de listagem).

```php
public function list(WP_REST_Request $request): WP_REST_Response
```

**Retorno:**
- `WP_REST_Response`: Encapsula a formatação da paginação `ApiResponse::paginated()` (Status 200).

---

### `getOne`

Endpoint para consultar um único item pelo seu ID recebido como parâmetro de rota.

```php
public function getOne(WP_REST_Request $request): WP_REST_Response
```

**Retorno:**
- `WP_REST_Response`: Sucesso com o produto formatado (Status 200) ou Não Encontrado (Status 404).

---

### `delete`

Endpoint que viabiliza a deleção de um único produto caso o autor da exclusão também for o dono dele.

```php
public function delete(WP_REST_Request $request): WP_REST_Response
```

**Retorno:**
- `WP_REST_Response`: Sucesso (Status 200) informando que foi removido e não traz nada no payload; ou Retorna Proibido (Status 403) na violação de regras de deleção.
