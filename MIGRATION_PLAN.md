# Plano de Migração: Sistema Legado → Laravel

## Análise do Sistema Legado

### Problemas Identificados
- **Vulnerabilidade SQL Injection**: concatenação direta de strings no SQL
- **Validação insuficiente**: validações básicas sem sanitização adequada
- **Arquitetura monolítica**: lógica misturada em um único arquivo
- **Sem transações**: risco de inconsistência de dados
- **Sem testes**: ausência de cobertura automatizada
- **Tratamento de erro básico**: apenas `die()` sem logs adequados

### Estrutura Atual
```sql
-- Tabela legada
CREATE TABLE fornecedores (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  cnpj VARCHAR(14) NOT NULL,
  email VARCHAR(255) NULL,
  criado_em DATETIME NOT NULL
);
```

## Estratégia de Migração

### Fase 1: Preparação (1-2 semanas)
1. **Setup do ambiente Laravel** ao lado do sistema legado
2. **Criação da estrutura** (migrations, models, controllers)
3. **Migração de dados** com script de conversão
4. **Testes de compatibilidade** com dados reais

### Fase 2: Implementação Paralela (2-3 semanas)
1. **API Laravel funcionando** em paralelo ao sistema legado
2. **Sincronização bidirecional** temporária entre sistemas
3. **Testes de carga** e performance
4. **Validação de business rules** equivalentes

### Fase 3: Transição Gradual (1-2 semanas)
1. **Redirecionamento progressivo** do tráfego para Laravel
2. **Monitoramento intensivo** de erros e performance
3. **Rollback plan** preparado para emergências
4. **Descomissionamento** do sistema legado

## Migração de Dados

### Script de Conversão
```sql
-- Migrar dados existentes
INSERT INTO providers (name, cnpj, email, created_at, updated_at)
SELECT 
    nome,
    cnpj,
    email,
    criado_em,
    criado_em
FROM fornecedores_legacy;
```

### Validação Pós-Migração
- **Contagem de registros**: verificar total de fornecedores
- **Integridade de CNPJs**: validar formato e unicidade
- **Dados obrigatórios**: verificar campos não-nulos
- **Consistência temporal**: validar datas de criação

## Compatibilidade de API

### Mapeamento de Endpoints
```
Sistema Legado → Laravel
GET ?action=list&q=termo → GET /api/providers?search=termo
POST ?action=create → POST /api/providers
```

### Mapeamento de Campos
```
nome → name
cnpj → cnpj (sanitizado)
email → email
criado_em → created_at
```

## Benefícios da Migração

### Segurança
- ✅ Prevenção de SQL Injection com ORM
- ✅ Validação robusta com FormRequests
- ✅ Sanitização automática de dados
- ✅ Criptografia de dados sensíveis

### Manutenibilidade
- ✅ Arquitetura em camadas (MVC + Service)
- ✅ Código testável e documentado
- ✅ PSR-12 compliance
- ✅ Dependency injection

### Performance
- ✅ Query optimization com Eloquent
- ✅ Cache strategies integradas
- ✅ Connection pooling
- ✅ Lazy loading de relacionamentos

### Funcionalidades
- ✅ Soft deletes para auditoria
- ✅ Timestamps automáticos
- ✅ Validação de CNPJ algorítmica
- ✅ API RESTful padronizada

## Riscos e Mitigações

### Riscos Identificados
1. **Downtime durante migração**
   - *Mitigação*: Migração gradual com sincronização
2. **Perda de dados**
   - *Mitigação*: Backup completo + testes de restore
3. **Incompatibilidade de comportamento**
   - *Mitigação*: Testes abrangentes com dados reais
4. **Performance degradada**
   - *Mitigação*: Load testing + otimização prévia

### Plano de Rollback
1. **Monitoramento em tempo real** de erros críticos
2. **Switch automático** para sistema legado se > 5% erro
3. **Backup de dados** antes de cada fase
4. **Scripts de reversão** testados e documentados

## Cronograma Detalhado

### Semana 1-2: Preparação
- [ ] Setup ambiente Laravel
- [ ] Migração inicial de dados
- [ ] Implementação de endpoints básicos
- [ ] Testes unitários e integração

### Semana 3-4: Implementação
- [ ] API completa funcionando
- [ ] Sincronização bidirecional
- [ ] Testes de carga
- [ ] Documentação da API

### Semana 5-6: Transição
- [ ] Deploy em ambiente de produção
- [ ] Redirecionamento gradual (10% → 50% → 100%)
- [ ] Monitoramento e ajustes
- [ ] Descomissionamento do legado

## Métricas de Sucesso

- **Zero perda de dados** durante migração
- **Performance igual ou superior** ao sistema legado
- **Redução de 90%** em vulnerabilidades de segurança
- **Cobertura de testes > 95%**
- **Tempo de resposta < 200ms** para 95% das requests
