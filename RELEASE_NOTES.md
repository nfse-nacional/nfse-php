# v1.19.0-beta

📅 **Data de Lançamento**: 2026-05-27

## ⚠️ Depreciações

### Geração oficial do DANFSe pelo Ambiente Nacional

-   **Deprecated**: `ContribuinteService::downloadDanfse()` e `MunicipioService::downloadDanfse()` foram marcados como depreciados.
-   A API oficial do ambiente nacional para geração do Documento Auxiliar da Nota Fiscal de Serviços Eletrônica (DANFSe) será descontinuada em **1º de julho de 2026**.
-   A emissão passará a ser responsabilidade dos sistemas emissores, ERPs e softwares das próprias empresas.
-   **Fim da API de Geração**: a interface oficial do governo que gerava o DANFSe será desligada.
-   **Responsabilidade do Emissor**: ERPs, softwares de gestão e plataformas de contabilidade precisarão gerar o DANFSe internamente e adequar seus layouts.
-   **Novo Layout**: o documento agora possui um formato padrão obrigatório em folha A4, exigência de QR Code e inclusão de campos para IBS e CBS.

📄 **Nota técnica**: https://www.gov.br/nfse/pt-br/biblioteca/documentacao-tecnica/rtc/nt-008-se-cgnfse-danfse-20260505.pdf

---

# v1.4.0-beta

📅 **Data de Lançamento**: 2026-01-06

## 🎯 Destaques

Esta versão representa um marco importante na evolução do SDK, trazendo **type safety completo** através de enums tipados e melhorias significativas na estrutura de dados.

## 🚀 Novidades

### Refatoração Completa com Enums Tipados

Implementação de **22 enums** para substituir valores primitivos (strings/integers) por tipos seguros, aumentando drasticamente a confiabilidade e a manutenibilidade do código.

#### ✨ Novos Enums Adicionados

**Tributação e Regime Fiscal:**

-   `RegimeApuracaoSN` - Regime de apuração dos tributos (Simples Nacional)
-   `OpcaoSimplesNacional` - Opção pelo Simples Nacional
-   `RegimeEspecialTributacao` - Regime especial de tributação
-   `TributacaoIssqn` - Tributação do ISSQN
-   `TipoImunidade` - Tipos de imunidade fiscal
-   `TipoSuspensao` - Tipos de suspensão de exigibilidade
-   `CstPisCofins` - Código de Situação Tributária (PIS/COFINS)

**Retenções:**

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

### 🔧 Melhorias no EnumCaster

Aprimoramento do `EnumCaster` para suportar:

-   Conversão automática de strings numéricas para int-backed enums
-   Validação rigorosa de valores
-   Melhor tratamento de erros com mensagens descritivas

### 🏗️ Integração com DTOs

Todos os DTOs foram atualizados para utilizar os novos enums através do atributo `#[CastWith(EnumCaster::class)]`, garantindo:

-   Type hints adequados em todas as propriedades
-   Autocomplete no IDE
-   Validação em tempo de execução
-   Documentação inline dos valores válidos

### 📦 Builders XML Atualizados

Os builders XML (`DpsXmlBuilder`, `NfseXmlBuilder`, `EventosXmlBuilder`) foram ajustados para:

-   Extrair automaticamente o valor de enums backed (`$enum->value`)
-   Manter compatibilidade com valores null
-   Preservar a formatação correta do XML

## 🛠️ Correções

### Testes Corrigidos

-   **Fix**: Corrigido valor inválido para `regApTribSN` nos testes (era `0` ou `3`, agora usa `null` ou `2`)
-   **Fix**: Corrigido valor inválido para `cMotivo` no teste (era `'1'`, agora usa `'01'`)
-   **Fix**: Removido cast manual de enum para string em `DpsXmlBuilder::appendElement()` que causava erro de conversão

### Validação de Enums

-   **Fix**: Implementada validação rigorosa de valores de enum, prevenindo uso de valores inválidos
-   **Fix**: Mensagens de erro mais claras quando valores inválidos são fornecidos

## 📊 Impacto nos Testes

-   ✅ **150 testes passando** (521 assertions)
-   ⚠️ **1 teste skipped** (certificado expirado - requer arquivo pré-gerado)
-   ❌ **0 testes falhando**

## 🔄 Breaking Changes

⚠️ **Atenção**: Esta versão introduz mudanças significativas na API.

### Migração de Valores Primitivos para Enums

**Antes:**

```php
$dps = new DpsData([
    'infDPS' => [
        'tpAmb' => 2,
        'tpEmit' => 1,
        // ...
    ]
]);
```

**Depois:**

```php
use Nfse\Enums\TipoAmbiente;
use Nfse\Enums\EmitenteDPS;

$dps = new DpsData([
    'infDPS' => [
        'tpAmb' => TipoAmbiente::Homologacao,
        // ou simplesmente: 'tpAmb' => 2,
        'tpEmit' => EmitenteDPS::Prestador,
        // ou simplesmente: 'tpEmit' => 1,
        // ...
    ]
]);
```

**Nota**: O `EnumCaster` mantém retrocompatibilidade, aceitando tanto valores primitivos quanto instâncias de enum.

### Valores que Mudaram

-   `regApTribSN`: Agora aceita apenas `'1'` ou `'2'` (valores `0` ou `3` não são mais válidos)
-   `cMotivo`: Deve usar formato com zero à esquerda (ex: `'01'` ao invés de `'1'`)

## 📚 Documentação

Para mais detalhes sobre os enums e seus valores válidos, consulte:

-   A documentação inline de cada enum em `src/Enums/`
-   Os métodos `getDescription()` disponíveis em cada enum
-   Os testes de exemplo em `tests/Unit/Enums/EnumsTest.php`

## 🎓 Guia de Migração

Consulte o arquivo `DTO_MIGRATION_GUIDE.md` para instruções detalhadas sobre como migrar seu código para utilizar os novos enums.

---

## 🚀 Novidades

### Suporte Completo à Distribuição de Documentos (ADN)

Agora é possível baixar documentos fiscais tanto para Contribuintes quanto para Municípios com suporte total aos parâmetros da API Nacional.

-   **Contribuinte**: Adicionado suporte para `cnpjConsulta` (para consultar notas de terceiros/filiais) e controle de `lote`.
-   **Município**: Adicionado suporte para `tipoNSU` (RECEPCAO, DISTRIBUICAO, GERAL, MEI) e controle de `lote`.

### Melhorias na API Client

-   **Correção de Endpoints**: Ajuste nos caminhos da API para respeitar o Case Sensitivity (`/DFe`, `/NFSe`, `/Eventos`).
-   **Tratamento de Erros**: Mensagens de erro da API agora são capturadas e exibidas com mais detalhes nas exceções.
-   **Mapeamento de DTOs**: Correção no mapeamento de respostas que utilizam PascalCase (ex: `TipoAmbiente`, `UltimoNSU`).

## 🛠️ Correções

-   **Fix**: Resolvido erro `TypeError` ao tentar baixar DANFSe quando a chave de acesso não estava disponível.
-   **Fix**: Correção na descompactação de arquivos XML (GZIP) que estavam sendo tratados incorretamente como ZIP.
-   **Fix**: Remoção de chamadas depreciadas `setAccessible(true)` nos testes unitários.

## 📦 Alterações Internas

-   Atualização da documentação (`README.md` e `docs/`) com novos exemplos de uso.
-   Refatoração dos testes para garantir compatibilidade com as novas assinaturas de métodos.

---

# v1.0.0-beta

A primeira versão pública do SDK mais moderno e completo para integração com a NFS-e Nacional!

## ✨ Destaques

-   **SDK Completo**: Integração com SEFIN Nacional, ADN e CNC
-   **Assinatura A1**: Suporte nativo a certificados PKCS#12/PFX
-   **139 Testes**: Cobertura extensiva com Pest
-   **Documentação**: Site completo em [nfse-php.netlify.app](https://nfse-php.netlify.app)

## 📦 Instalação

```bash
composer require nfse-nacional/nfse-php:1.0.0-beta
```

## 🌐 Web Services

### Contribuinte

```php
$nfse = new Nfse($context);
$contribuinte = $nfse->contribuinte();

$contribuinte->emitir($dps);           // Emitir NFS-e
$contribuinte->consultarNfse($chave);  // Consultar nota
$contribuinte->registrarEvento($evento); // Cancelar/substituir
```

### Município

```php
$municipio = $nfse->municipio();

$municipio->baixarDfe($nsu);           // Baixar notas
$municipio->consultarAliquota(...);    // Consultar alíquotas
$municipio->consultarContribuinte(...); // Consultar cadastro
```

## 📋 Requisitos

-   PHP 8.4+
-   Extensão OpenSSL
-   Certificado digital A1 (PFX/P12)

## 🔗 Links

-   📚 [Documentação](https://nfse-php.netlify.app)
-   💬 [Discussões](https://github.com/nfse-nacional/nfse-php/discussions)
-   🐛 [Issues](https://github.com/nfse-nacional/nfse-php/issues)

---

⚠️ **Nota**: Esta é uma versão beta. Reporte problemas no [Issues](https://github.com/nfse-nacional/nfse-php/issues).

💖 **Apoie o projeto**: [GitHub Sponsors](https://github.com/sponsors/a21ns1g4ts)
