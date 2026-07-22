# Changelog

All notable changes to `nfse-php` will be documented in this file.

## [Unreleased]

### 🧾 Grupo IBS/CBS (Reforma Tributária sobre o Consumo)

Implementação do grupo `IBSCBS` conforme o pacote de esquemas AnexoVI v1.01.03 (NT 004),
nos dois sentidos: informações declaradas na DPS e valores calculados pelo Sistema Nacional
na NFS-e.

### ✨ Funcionalidades

-   `IbscbsData` passa a cobrir o grupo declarado na DPS: `finNFSe`, `indFinal`, `cIndOp`,
    `tpOper`, `gRefNFSe`, `tpEnteGov`, `indDest`, `dest`, `imovel`, `gReeRepRes` e
    `gIBSCBS` (CST, cClassTrib, cCredPres, gTribRegular e gDif).
-   `IbscbsNfseData` expõe o grupo calculado retornado na NFS-e, incluindo alíquotas
    efetivas, totalizadores de IBS e CBS, crédito presumido, tributação regular e
    compras governamentais.
-   Novos DTOs `ImovelData` e `ReembolsoDocumentoData`.
-   Novos enums `TipoOperacaoRtc`, `TipoEnteGovernamental`, `IndicadorDestinatario`,
    `TipoChaveDFe` e `TipoReembolsoRepasseRessarcimento`.
-   `DpsValidator` valida as regras de negócio do grupo que não dependem de tabelas
    externas (RN 324, 542, 549, 554, 618/619, 621, 622 e 627).
-   Novo exemplo `examples/contribuinte/emitir_ibscbs.php`.

### 🐛 Correções

-   `cLocEmi` passa a ser serializado depois de `cMotivoEmisTI` e `chNFSeRej`, como exige
    a sequência do XSD. A ordem anterior invalidava a DPS quando esses campos eram usados.
-   Grupos repetíveis com uma única ocorrência deixam de ser desmontados na leitura do XML
    (`ArrayCaster`), o que também corrige `vDedRed/documentos`.

### ⚠️ Breaking changes

-   Removido `IbscbsData::$indicadorZfmAlc` e a emissão do elemento `indZFMALC`. O campo
    não existe no esquema oficial nem no Anexo I e gerava XML rejeitado.

## [1.4.0-beta] - 2026-01-06

### 🎯 Type Safety com Enums

Esta versão traz uma refatoração completa focada em type safety através de enums tipados.

### ✨ Funcionalidades

#### 📦 Novos Enums (22 no total)

**Tributação e Regime Fiscal:**

-   `RegimeApuracaoSN` - Regime de apuração dos tributos (Simples Nacional)
-   `OpcaoSimplesNacional` - Opção pelo Simples Nacional
-   `RegimeEspecialTributacao` - Regime especial de tributação
-   `TributacaoIssqn` - Tributação do ISSQN
-   `TipoImunidade` - Tipos de imunidade fiscal
-   `TipoSuspensao` - Tipos de suspensão de exigibilidade
-   `CstPisCofins` - Código de Situação Tributária (PIS/COFINS)
-   `TipoRetencaoIssqn` - Tipo de retenção do ISSQN
-   `TipoRetencaoPisCofins` - Tipo de retenção de PIS/COFINS

**Documentos e Processos:**

-   `MotivoSubstituicao` - Motivo de substituição de NFS-e
-   `MotivoEmissaoTomadorIntermediario` - Motivo de emissão por tomador/intermediário
-   `MotivoNaoNif` - Motivo de não informar NIF
-   `TipoDeducaoReducao` - Tipo de dedução/redução

**Comércio Exterior:**

-   `ModoPrestacao` - Modo de prestação de serviço
-   `MovimentacaoTemporariaBens` - Movimentação temporária de bens

**Outros:**

-   `IndicadorTotalTributos` - Indicador de informação de tributos
-   `TipoPessoa` - Tipo de pessoa (Física/Jurídica/Estrangeiro)
-   `AmbienteGerador` - Ambiente gerador da NFS-e
-   `TipoNsu` - Tipo de NSU para distribuição
-   `EmitenteDPS` - Emitente do DPS
-   `ProcessoEmissao` - Processo de emissão
-   `TipoAmbiente` - Tipo de ambiente (Produção/Homologação)

#### 🔧 EnumCaster Aprimorado

-   Conversão automática de strings numéricas para int-backed enums
-   Validação rigorosa de valores
-   Mensagens de erro descritivas

#### 🏗️ DTOs Atualizados

-   Todos os DTOs integrados com os novos enums via `#[CastWith(EnumCaster::class)]`
-   Type hints adequados em todas as propriedades
-   Autocomplete melhorado no IDE
-   Validação em tempo de execução

### 🛠️ Correções

-   **Fix**: Corrigido valores inválidos de `regApTribSN` nos testes (era `0` ou `3`, agora usa `null` ou `2`)
-   **Fix**: Corrigido valor inválido de `cMotivo` (era `'1'`, agora usa `'01'`)
-   **Fix**: Removido cast manual de enum em `DpsXmlBuilder` que causava erro de conversão
-   **Fix**: Implementada validação rigorosa de valores de enum

### ⚠️ Breaking Changes

-   `regApTribSN` agora aceita apenas `'1'` ou `'2'` (valores `0` ou `3` não são mais válidos)
-   `cMotivo` deve usar formato com zero à esquerda (ex: `'01'` ao invés de `'1'`)

### 📊 Testes

-   ✅ 150 testes passando (521 assertions)
-   ❌ 0 testes falhando

## [1.0.0-beta] - 2026-01-01

### 🎉 Lançamento Inicial (Beta)

Esta é a primeira versão pública do SDK NFS-e Nacional PHP. O pacote oferece uma solução completa e moderna para integração com a NFS-e Nacional.

### ✨ Funcionalidades

#### 📦 DTOs (Data Transfer Objects)

-   DTOs completos para DPS, NFS-e e Eventos
-   Validação automática de campos obrigatórios
-   Mapeamento de nomes de campos conforme especificação oficial
-   Suporte a todos os tipos de operação: emissão, cancelamento, substituição

#### 🔐 Assinatura Digital

-   Suporte a certificado A1 (PKCS#12/PFX)
-   Assinatura XML-DSig compatível com ICP-Brasil
-   Algoritmos SHA-1 e SHA-256

#### 📄 Serialização XML

-   Geração de XML compatível com XSDs oficiais
-   Builder fluente para DPS e Eventos
-   Serialização automática de DTOs para XML

#### 🌐 Web Services (SDK)

-   **SEFIN Nacional**: Emissão, consulta, verificação e listagem de eventos
-   **ADN (Ambiente de Dados Nacional)**: Distribuição de DFe, consulta de alíquotas, regimes especiais, retenções
-   **CNC (Cadastro Nacional de Contribuintes)**: Consulta e atualização cadastral

#### 🏢 Camada de Serviços

-   `ContribuinteService`: Operações para contribuintes emissores
-   `MunicipioService`: Operações para sistemas municipais
-   Interface simplificada através da classe `Nfse`

#### 🧪 Qualidade de Código

-   139 testes automatizados com Pest
-   485 assertions
-   Análise estática com PHPStan (nível máximo)
-   Code style com Laravel Pint

#### 📚 Documentação

-   Site de documentação com Docusaurus
-   Busca local integrada
-   Exemplos práticos e guias de uso

### 📋 Requisitos

-   PHP 8.4+
-   Extensão OpenSSL
-   Certificado digital A1 (PFX/P12)

### 📦 Dependências

-   `guzzlehttp/guzzle` ^7.9
-   `illuminate/support` ^12.0
-   `illuminate/validation` ^12.0
-   `illuminate/translation` ^12.0

### 🔗 Links

-   [Documentação](https://nfse-php.netlify.app)
-   [GitHub](https://github.com/nfse-nacional/nfse-php)
-   [Packagist](https://packagist.org/packages/nfse-nacional/nfse-php)
