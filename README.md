# 🛍️ WP E-commerce API

![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![WordPress](https://img.shields.io/badge/WordPress-Core-21759B?style=for-the-badge&logo=wordpress&logoColor=white)
![Architecture](https://img.shields.io/badge/Architecture-Clean%20Code-brightgreen?style=for-the-badge)

Uma **API RESTful moderna, robusta e escalável** para e-commerce, construída sob a fundação do WordPress em formato de Plugin. Desenvolvido para entregar máxima performance, este projeto rompe com os padrões antigos do WordPress (como Custom Post Types e `wp_postmeta`), utilizando **Tabelas Customizadas**, o que garante integridade referencial, queries de alta performance e flexibilidade de escala.

Sob o capô, foi desenvolvido aplicando rigorosos padrões de engenharia de software em **PHP 8.3**, como Injeção de Dependências (DI), Tipagem Estrita, Data Transfer Objects (DTOs) e uma arquitetura limpa em camadas (Services, Repositories, Controllers). Todo o código-fonte foi padronizado no idioma inglês para aderência à comunidade open-source.

---

## ✨ Destaques e Diferenciais

- 🚀 **Alta Performance:** Uso de tabelas otimizadas próprias (ex: `wp_ec_products`, `wp_ec_transactions`), evitando a pesada tabela de metadados nativa do WordPress.
- 🛡️ **Segurança e Validação:** Rotas protegidas utilizando tokens JWT (JSON Web Tokens), DTOs "readonly" para fluxo imutável de dados e queries totalmente blindadas via `$wpdb->prepare`.
- 🏗️ **Arquitetura em Camadas:** Código testável e isolado com responsabilidades bem definidas (Segregação por Repositories, Services e Controllers).
- 🧩 **100% API-Driven:** O plugin não gera views ou páginas no Front-end; ele é inteiramente focado em entregar dados formatados (JSON) para integrações com Frontends modernos (React, Vue, Next.js, Apps Mobile).

---

## 🎯 Requisitos e Funcionalidades

### 👤 Autenticação e Usuários
- Cadastro de novos usuários (com validação estrita de unicidade de e-mail e username).
- Login seguro e emissão de tokens JWT.
- Consulta e edição do próprio perfil com isolamento (bloqueio de acesso a dados de terceiros).

### 📦 Gerenciamento de Produtos
- Cadastro de produtos com suporte a upload de múltiplas imagens integrado de forma nativa à galeria de Mídia do WordPress.
- Listagem pública com paginação, busca por texto e filtragem por vendedor (inclui totalizadores no corpo ou via cabeçalho HTTP).
- Visualização de detalhes isolados de um produto específico.
- Exclusão inteligente e segura (apenas o dono pode excluir o item. Ao deletar, as imagens físicas associadas também são apagadas do servidor, poupando espaço em disco).

### 💳 Transações (Compra e Venda)
- Processamento seguro de checkout via API.
- Travas lógicas de fraude: bloqueio contra compra de itens criados pelo próprio usuário ou itens já marcados como vendidos.
- Alteração automática de disponibilidade (status modificado para "sold" após a transação).
- Consulta de histórico separada por papéis: veja o que você já comprou e acompanhe os produtos que você conseguiu vender.

---

## 📁 Estrutura de Diretórios e Arquitetura

O núcleo de negócio foi meticulosamente isolado dentro da pasta `src/`:

```text
wp-ecommerce-api/
├── wp-ecommerce-api.php         # Entrypoint principal do plugin e inicialização
├── composer.json                # Gerenciador de dependências e Autoload (PSR-4)
├── docs/                        # 📚 Documentação detalhada dos componentes
└── src/
    ├── App.php                  # Motor de partida e injeção de dependências global
    ├── Controllers/             # Tratamento de endpoints (WP_REST_Request e Reponse)
    ├── Services/                # Casos de uso complexos e validações de regras de negócio
    ├── Repositories/            # Acesso direto e otimizado ao banco de dados ($wpdb)
    ├── DTOs/                    # Objetos estritos de transporte de dados
    ├── Http/                    # Padronizador de respostas unificado (ApiResponse)
    ├── Routes/                  # Mapeamento estático e Inscrição de rotas do WordPress
    └── Database/                # Scripts de Migrations (dbDelta) para tabelas customizadas
```

---

## 📖 Documentação do Código (Docs)

Preparamos uma documentação individual e detalhada para cada componente e classe do sistema. Se você deseja entender a fundo os parâmetros de entrada, tipos de retorno, injeção de dependências ou exceções que os métodos podem lançar, basta conferir a nossa pasta **`/docs`**.

**Alguns dos principais artefatos que você pode consultar:**
- 📄 [App.md](docs/App.md) - Entenda o bootstrap, o Hook de inicialização e as Injeções.
- 📦 [ProductService.md](docs/ProductService.md) | [TransactionService.md](docs/TransactionService.md) - Entenda todas as Regras de Negócio aplicadas.
- 🗄️ [ProductRepository.md](docs/ProductRepository.md) - Conheça os métodos de persistência e buscas.
- 🛣️ [ProductRoutes.md](docs/ProductRoutes.md) - Explore como as rotas foram atreladas e protegidas.

*(Navegue pela pasta `/docs` do repositório para conferir toda a documentação das outras classes!)*

---

## 🛠️ Instalação e Configuração

### 1. Pré-requisitos
- **WordPress** instalado e ativo.
- **PHP 8.3** ou superior.
- O Plugin [JWT Authentication for WP-API](https://wordpress.org/plugins/jwt-authentication-for-wp-rest-api/) devidamente instalado no WP.

### 2. Configurando o Ambiente (JWT)
O plugin de Autenticação JWT precisa de chaves secretas. Edite o seu arquivo `wp-config.php` na raiz da instalação do seu WordPress:

```php
define('JWT_AUTH_SECRET_KEY', 'sua-chave-super-secreta-e-complexa-aqui-123456');
define('JWT_AUTH_CORS', true);
```
*(Você pode usar variáveis de ambiente caso trabalhe com bibliotecas como `vlucas/phpdotenv`)*

### 3. Instalando a API
1. Realize o clone deste repositório diretamente para a pasta de plugins do seu projeto WordPress:
   ```bash
   cd wp-content/plugins/
   git clone https://github.com/BrunoAlmeidadev/wp-ecommerce.git
   ```
2. Acesse a pasta do plugin no terminal e gere o arquivo de autoload do Composer:
   ```bash
   cd wp-ecommerce-api
   composer dump-autoload
   ```
3. Acesse o Painel Administrativo do WordPress (`/wp-admin`), navegue até **Plugins** e **Ative o plugin "WP E-commerce API"**. As tabelas customizadas serão criadas em background automaticamente neste instante.
4. Por fim, vá em **Configurações > Links Permanentes** e simplesmente clique em **Salvar alterações**. Isso aplicará as regras de reescrita do WordPress e fará com que as rotas da nossa API passem a funcionar.

---

## 📡 Endpoints da API

*Nota Importante: Todas as requisições que requerem acesso "Protegido" exigem o envio do cabeçalho HTTP:*
`Authorization: Bearer <SEU_TOKEN_JWT>`

### 🔐 Autenticação & Usuários
| Método | Endpoint | Acesso | Descrição |
| :--- | :--- | :--- | :--- |
| `POST` | `/wp-json/jwt-auth/v1/token` | Público | Login. Emite o Token JWT se válido. |
| `POST` | `/wp-json/api/v1/users/register` | Público | Cadastro de um novo usuário. |
| `GET` | `/wp-json/api/v1/users/me` | Protegido | Visualiza os dados do seu próprio perfil. |
| `PUT` | `/wp-json/api/v1/users/me` | Protegido | Atualiza atributos do seu próprio perfil. |

### 🛍️ Produtos
| Método | Endpoint | Acesso | Descrição |
| :--- | :--- | :--- | :--- |
| `GET` | `/wp-json/api/v1/products` | Público | Lista todos os produtos (Aceita `?page=`, `?limit=`, `?q=`, `?sellerId=`). |
| `GET` | `/wp-json/api/v1/products/{id}` | Público | Visualiza os detalhes minuciosos e imagens de um item. |
| `POST` | `/wp-json/api/v1/products` | Protegido | Cria novo produto. *Exige `multipart/form-data` se for enviar fotos.* |
| `DELETE` | `/wp-json/api/v1/products/{id}` | Protegido | Exclui um produto próprio permanentemente do banco. |

### 💳 Transações
| Método | Endpoint | Acesso | Descrição |
| :--- | :--- | :--- | :--- |
| `POST` | `/wp-json/api/v1/transactions` | Protegido | Processa uma compra (Checkout do item). |
| `GET` | `/wp-json/api/v1/transactions/purchases` | Protegido | Visualiza o seu histórico como Comprador. |
| `GET` | `/wp-json/api/v1/transactions/sales` | Protegido | Visualiza o seu histórico como Vendedor (itens vendidos). |

---

*Desenvolvido com padrão de qualidade e arquitetura robusta.*
