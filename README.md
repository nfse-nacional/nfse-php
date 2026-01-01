# Nfse Nacional - PHP DATA TYPES AND BUILDER XML

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nfse-nacional/nfse-php.svg?style=flat-square)](https://packagist.org/packages/nfse-nacional/nfse-php)
[![Tests](https://img.shields.io/github/actions/workflow/status/nfse-nacional/nfse-php/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/nfse-nacional/nfse-php/actions/workflows/run-tests.yml)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/nfse-nacional/nfse-php/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/nfse-nacional/nfse-php/actions/workflows/fix-php-code-style-issues.yml)
[![Coverage](https://img.shields.io/codecov/c/github/nfse-nacional/nfse-php?style=flat-square)](https://codecov.io/gh/nfse-nacional/nfse-php)
[![Total Downloads](https://img.shields.io/packagist/dt/nfse-nacional/nfse-php.svg?style=flat-square)](https://packagist.org/packages/nfse-nacional/nfse-php)

A maneira mais moderna e eficiente de integrar PHP com a NFS-e Nacional.

Este pacote é a fundação do ecossistema para integração com a NFS-e Nacional. O foco é garantir contratos sólidos, modelos de dados ricos (DTOs) e facilidade de uso para desenvolvedores PHP. Ele fornece um conjunto robusto de DTOs que simplificam a criação e validação dos XMLs, oferecendo uma interface fluida e uma documentação alinhada à realidade do desenvolvedor.

📚 **Documentação Técnica:** [nfse.netlify.app](https://nfse.netlify.app/)

## Instalação

Você pode instalar o pacote via composer:

```bash
composer require nfse-nacional/nfse-php
```

## Uso

Exemplo básico de utilização dos DTOs:

```php
use Nfse\Dto\DpsData;

// Exemplo de instanciação (ajuste conforme sua necessidade)
$dps = DpsData::from([
    '@versao' => '1.00',
    'infDPS' => [
        // ... dados da DPS
    ]
]);
```

## Exemplo Completo

Abaixo, um exemplo de como gerar o ID, criar o objeto DPS, gerar o XML e assiná-lo digitalmente.

```php
use Nfse\Dto\DpsData;
use Nfse\Xml\DpsXmlBuilder;
use Nfse\Signer\Certificate;
use Nfse\Signer\XmlSigner;
use Nfse\Support\IdGenerator;

// 1. Gerar o ID da DPS
// Formato: DPS + Cód.Mun.(7) + Tipo Inscr.(1) + Inscr.Fed.(14) + Série(5) + Número(15)
$id = IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001');

// 2. Instanciar o DTO (você pode usar arrays ou objetos)
$dps = DpsData::from([
    '@versao' => '1.00',
    'infDPS' => [
        '@Id' => $id,
        'tpAmb' => 2, // 2 - Homologação
        'dhEmi' => date('Y-m-d\TH:i:s'),
        'verAplic' => '1.0',
        'serie' => '1',
        'nDPS' => '1001',
        'dCompet' => date('Y-m-d'),
        'tpEmit' => 1, // 1 - Prestador
        'cLocEmi' => '3550308', // São Paulo - SP
        'prest' => [
            'CNPJ' => '12345678000199',
            'IM' => '12345',
        ],
        'toma' => [
            'CPF' => '11122233344',
            'xNome' => 'Tomador Exemplo',
        ],
        'serv' => [
            'locPrest' => [
                'cLocPrest' => '3550308',
            ],
            'cServ' => [
                'cTribNac' => '1.01',
                'xDescServ' => 'Analise de sistemas',
            ],
        ],
        'valores' => [
            'vServPrest' => [
                'vReceb' => 1000.00,
                'vServ' => 1000.00,
            ],
            'trib' => [
                'tribISSQN' => 1, // 1 - Operação tributável
                'tpRetISSQN' => 1, // 1 - Não Retido
            ],
        ],
    ]
]);

// 3. Gerar o XML
$builder = new DpsXmlBuilder();
$xml = $builder->build($dps);

// 4. Assinar o XML
// Carregue seu certificado A1 (PKCS#12)
$cert = new Certificate('/caminho/para/certificado.pfx', 'senha123');
$signer = new XmlSigner($cert);

// Assina a tag 'infDPS'
$signedXml = $signer->sign($xml, 'infDPS');

// Agora você pode enviar $signedXml para a API da Nacional
echo $signedXml;
```

## Web Services (SDK) 🌐

O pacote agora inclui uma camada de serviços de alto nível para integração direta com a SEFIN Nacional e o ADN.

```php
use Nfse\Nfse;
use Nfse\Http\NfseContext;
use Nfse\Enums\TipoAmbiente;

$context = new NfseContext(
    ambiente: TipoAmbiente::Homologacao,
    certificatePath: '/caminho/para/certificado.p12',
    certificatePassword: 'senha'
);

$nfse = new Nfse($context);

// Emitir uma nota (Contribuinte)
$contribuinte = $nfse->contribuinte();
$resultado = $contribuinte->emitir($dps);

// Baixar arrecadação (Município)
$municipio = $nfse->municipio();
$notas = $municipio->baixarDfe(100);
```

## 🗺️ Roadmap

Este projeto está em desenvolvimento ativo. Abaixo estão as fases planejadas:

### Fase 1: Estrutura de Dados (DTOs) ✅

-   [x] Implementar DTOs usando `spatie/laravel-data`.
-   [x] Mapear campos do Excel usando atributos.
-   [x] Testes unitários de validação.

### Fase 2: Serialização ✅

-   [x] Implementar Serializer para XML.
-   [x] Garantir conformidade com XSDs oficiais.

### Fase 3: Assinatura Digital ✅

-   [x] Suporte a certificado A1 (PKCS#12).
-   [x] Implementação de XML-DSig.

### Fase 4: Web Services (SDK) ✅

-   [x] Integração com SEFIN Nacional (Emissão/Consulta).
-   [x] Integração com ADN (Distribuição/Parâmetros).
-   [x] Integração com CNC (Cadastro Nacional).
-   [x] Camada de serviços simplificada (`ContribuinteService` e `MunicipioService`).

### Fase 5: Documentação & Busca ✅

-   [x] Docusaurus com busca local.
-   [x] Documentação completa de serviços e DTOs.

### Fase 6: Testes E2E & CI/CD 🚀

-   [ ] Testes end-to-end com ambiente de homologação.
-   [ ] GitHub Actions para CI/CD.
-   [ ] Releases automáticas.

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

-   [A21ns1g4ts](https://github.com/a21ns1g4ts)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
