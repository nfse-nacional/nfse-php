# Nfse Nacional - PHP DATA TYPES AND BUILDER XML

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nfse-nacional/nfse-php.svg?style=flat-square)](https://packagist.org/packages/nfse-nacional/nfse-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/nfse-nacional/nfse-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/nfse-nacional/nfse-php/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/nfse-nacional/nfse-php.svg?style=flat-square)](https://packagist.org/packages/nfse-nacional/nfse-php)

A maneira mais moderna e eficiente de integrar PHP com a NFS-e Nacional.

Este pacote é a fundação do ecossistema para integração com a NFS-e Nacional. O foco é garantir contratos sólidos, modelos de dados ricos (DTOs) e facilidade de uso para desenvolvedores PHP. Ele fornece um conjunto robusto de DTOs que simplificam a criação e validação dos XMLs, oferecendo uma interface fluida e uma documentação alinhada à realidade do desenvolvedor.

## Instalação

Você pode instalar o pacote via composer:

```bash
composer require nfse-nacional/nfse-php
```

## Uso

Exemplo básico de utilização dos DTOs:

```php
use Nfse\Nfse\Dto\DpsData;

// Exemplo de instanciação (ajuste conforme sua necessidade)
$dps = DpsData::from([
    '@versao' => '1.00',
    'infDPS' => [
        // ... dados da DPS
    ]
]);
```

## 🗺️ Roadmap

Este projeto está em desenvolvimento ativo. Abaixo estão as fases planejadas:

### Fase 1: Estrutura de Dados (DTOs) 🚧

-   [x] Implementar DTOs usando `spatie/laravel-data`.
-   [x] Mapear campos do Excel (`ANEXO_I...`) usando atributos `#[MapInputName]`.
-   [x] Implementar `Dps`, `Prestador`, `Tomador`, `Servico`, `Valores`.
-   [x] Adicionar validações (Constraints) nos DTOs.
-   [x] Testes unitários de validação.

### Fase 2: Serialização ✅

-   [x] Implementar Serializer para XML (padrão ABRASF/Nacional).
-   [ ] Implementar Serializer para JSON.
-   [x] Garantir que a serialização respeite os XSDs oficiais.

### Fase 3: Assinatura Digital 📅

-   [ ] Criar `SignerInterface`.
-   [ ] Implementar adaptador para assinatura XML (DSig).
-   [ ] Suporte a certificado A1 (PKCS#12).

### Fase 4: Utilitários 📅

-   [ ] Helpers para cálculo de impostos (simples).
-   [ ] Formatadores de documentos (CPF/CNPJ).

Para mais detalhes, consulte o arquivo [ROADMAP.md](ROADMAP.md).

## Testing

```bash
composer test
```

## Changelog

Por favor, veja [CHANGELOG](CHANGELOG.md) para mais informações sobre o que mudou recentemente.

## Contributing

Por favor, veja [CONTRIBUTING](CONTRIBUTING.md) para detalhes.

## Security

Se você descobrir alguma vulnerabilidade de segurança, por favor, envie um e-mail para o mantenedor em vez de usar o rastreador de problemas.

## Credits

-   [Danvizera](https://github.com/danvizera)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
