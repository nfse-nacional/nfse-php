# Roadmap: nfse-php

Este pacote é a fundação do ecossistema. O foco é garantir contratos sólidos e modelos de dados ricos.

## 📅 Fases

### Fase 1: Estrutura de Dados (DTOs)

-   [x] Implementar DTOs usando `spatie/laravel-data`.
-   [x] Mapear campos do Excel (`ANEXO_I...`) usando atributos `#[MapInputName]`.
-   [x] Implementar `Dps`, `Prestador`, `Tomador`, `Servico`, `Valores`.
-   [ ] Adicionar validações (Constraints) nos DTOs.
-   [ ] Testes unitários de validação.

### Fase 2: Serialização

-   [ ] Implementar Serializer para XML (padrão ABRASF/Nacional).
-   [ ] Implementar Serializer para JSON.
-   [ ] Garantir que a serialização respeite os XSDs oficiais.

### Fase 3: Assinatura Digital

-   [ ] Criar `SignerInterface`.
-   [ ] Implementar adaptador para assinatura XML (DSig).
-   [ ] Suporte a certificado A1 (PKCS#12).

### Fase 4: Utilitários

-   [ ] Helpers para cálculo de impostos (simples).
-   [ ] Formatadores de documentos (CPF/CNPJ).
