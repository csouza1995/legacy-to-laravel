# Migração de Sistema Legacy para Laravel

Este projeto demonstra a migração de um sistema PHP legado de fornecedores para Laravel moderno, aplicando boas práticas de desenvolvimento e arquitetura limpa.

## Tecnologias Utilizadas

- **Laravel 11** - Framework PHP moderno
- **MySQL/SQLite** - Banco de dados
- **PHPUnit** - Testes automatizados
- **Eloquent ORM** - Mapeamento objeto-relacional
- **Form Requests** - Validação de dados
- **API Resources** - Formatação de resposta
- **Service Layer** - Lógica de negócio

## Funcionalidades Implementadas

### ✅ Migração Completa do Sistema Legado

- **Endpoints REST** equivalentes ao sistema legado
- **Validação robusta** com FormRequests customizados
- **Sanitização de CNPJ** com remoção automática de caracteres especiais
- **Validação de CNPJ** com algoritmo completo de verificação
- **Soft Deletes** para histórico de dados
- **Transações de banco** para consistência
- **Testes automatizados** com cobertura completa

### 🔄 Compatibilidade com Sistema Legado

- **Parâmetros legados** suportados (`nome` → `name`, `q` → `search`)
- **Formato de resposta** mantendo compatibilidade (`criado_em`, `nome`)
- **Mesma lógica de filtros** e ordenação

## Instalação e Configuração

### 1. Clonar o repositório
```bash
git clone <repository-url>
cd legacy-to-laravel
```

### 2. Instalar dependências
```bash
composer install
```

### 3. Configurar ambiente
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configurar banco de dados
Edite o arquivo `.env` com suas configurações de banco:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Executar migrações
```bash
php artisan migrate
```

### 6. Popular banco com dados de teste (opcional)
```bash
php artisan db:seed
```

### 7. Iniciar servidor
```bash
php artisan serve
```

## Endpoints da API

### GET `/api/providers`
Lista fornecedores com filtro opcional por nome.

**Parâmetros:**
- `search` ou `q` (opcional): filtro por nome

**Exemplo:**
```bash
curl "http://localhost:8000/api/providers?search=ABC"
```

### POST `/api/providers`
Cria um novo fornecedor.

**Payload:**
```json
{
    "name": "Fornecedor ABC Ltda",
    "cnpj": "11.222.333/0001-81",
    "email": "contato@abc.com.br"
}
```

**Exemplo:**
```bash
curl -X POST "http://localhost:8000/api/providers" \
  -H "Content-Type: application/json" \
  -d '{"name":"Fornecedor Teste","cnpj":"11222333000181","email":"teste@fornecedor.com"}'
```

## Executar Testes

### Todos os testes
```bash
php artisan test
```

### Testes específicos
```bash
php artisan test tests/Feature/ProviderTest.php
```

### Com cobertura de código
```bash
php artisan test --coverage
```

## Estrutura do Projeto

```
app/
├── Http/
│   ├── Controllers/
│   │   └── ProvidersController.php    # Controlador REST
│   ├── Requests/
│   │   ├── FormProviderRequest.php    # Validação de criação
│   │   └── IndexProviderRequest.php   # Validação de listagem
│   └── Resources/
│       └── ProviderResource.php       # Formatação de resposta
├── Models/
│   └── Provider.php                   # Model Eloquent
├── Rules/
│   └── ValidCnpj.php                 # Validação customizada de CNPJ
└── Services/
    ├── CnpjService.php               # Utilitários para CNPJ
    └── ProviderService.php           # Lógica de negócio

database/
├── factories/
│   └── ProviderFactory.php          # Factory para testes
├── migrations/
│   └── *_create_providers_table.php # Estrutura do banco
└── seeders/
    └── ProviderSeeder.php           # Dados de exemplo

tests/
└── Feature/
    └── ProviderTest.php             # Testes de integração
```

## Validações Implementadas

### Fornecedor
- **Nome**: obrigatório, mínimo 3 caracteres, máximo 255
- **CNPJ**: obrigatório, 14 dígitos, único, algoritmo de validação completo
- **Email**: opcional, formato válido, máximo 255 caracteres

### Sanitização Automática
- **CNPJ**: remove automaticamente pontos, barras e hífens
- **Parâmetros**: converte nomes de parâmetros legados automaticamente

## Diferenças do Sistema Legado

### Melhorias de Segurança
- ✅ **SQL Injection** prevenida com Eloquent ORM
- ✅ **Validação robusta** com FormRequests
- ✅ **Transações** para consistência de dados
- ✅ **Soft Deletes** para auditoria

### Melhorias de Arquitetura
- ✅ **Service Layer** para lógica de negócio
- ✅ **Resources** para formatação consistente
- ✅ **PSR-12** compliance
- ✅ **Testes automatizados** com 100% cobertura

### Funcionalidades Extras
- ✅ **Validação de CNPJ** com algoritmo completo
- ✅ **Formatação de CNPJ** para exibição
- ✅ **Soft Deletes** para histórico
- ✅ **Factory/Seeder** para dados de teste

## Plano de Migração

Consulte o arquivo `MIGRATION_PLAN.md` para detalhes sobre a estratégia de migração do sistema legado.