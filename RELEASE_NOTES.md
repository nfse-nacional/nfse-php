# v1.1.0-beta

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

-----------------------------------------------------------------------

# 🚀 NFS-e Nacional PHP SDK v1.0.0-beta

A primeira versão pública do SDK mais moderno e completo para integração com a NFS-e Nacional!

## ✨ Destaques

-   **SDK Completo**: Integração com SEFIN Nacional, ADN e CNC
-   **DTOs Tipados**: Estruturas de dados completas com `spatie/laravel-data`
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
