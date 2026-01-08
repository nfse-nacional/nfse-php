# 🚀 NFS-e Nacional PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nfse-nacional/nfse-php.svg?style=flat-square)](https://packagist.org/packages/nfse-nacional/nfse-php)
[![Coverage](https://img.shields.io/codecov/c/github/nfse-nacional/nfse-php/main?style=flat-square)](https://codecov.io/gh/nfse-nacional/nfse-php)
[![Coverage Status](https://github.com/nfse-nacional/nfse-php/actions/workflows/coverage.yml/badge.svg)](https://github.com/nfse-nacional/nfse-php/actions/workflows/coverage.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/nfse-nacional/nfse-php.svg?style=flat-square)](https://packagist.org/packages/nfse-nacional/nfse-php)

A maneira mais moderna e eficiente de integrar PHP com a NFS-e Nacional.

Este pacote é a fundação do ecossistema para integração com a NFS-e Nacional. O foco é garantir contratos sólidos, modelos de dados ricos (DTOs) e facilidade de uso para desenvolvedores PHP. Ele fornece um conjunto robusto de DTOs que simplificam a criação e validação dos XMLs, oferecendo uma interface fluida e uma documentação alinhada à realidade do desenvolvedor.

> ⚠️ **Atenção: Adequação dos Municípios**
>
> Os municípios ainda estão em processo de adequação à API Nacional. Antes de iniciar a integração, verifique se o município desejado já está credenciado e operando:
>
> 1.  **Consulte o Status No Painel de Monitoramento de Adesão:** [Painel de Monitoramento da NFS-e](https://app.powerbi.com/view?r=eyJrIjoiNGQ4YTcxNmMtMzdhNC00Mzc5LTllM2EtMjY1MTM3NWQyZDgyIiwidCI6IjZmNDlhYTQzLTgyMmEtNGMyMC05NjcwLWRiNzcwMGJmMWViMCJ9&pageName=608609c2e0a53d7a3c6e)
> 2.  **Verifique o Convênio via API:** Utilize o método `consultarParametrosConvenio` para confirmar se o município aceita emissão via API Nacional. Veja o exemplo em [examples/contribuinte/parametros/consultar_parametros.php](https://github.com/nfse-nacional/nfse-php/blob/main/examples/contribuinte/parametros/consultar_parametros.php).
>
> **Nota Importante:** Alguns municípios optaram por operar com **emissor próprio**. É fundamental verificar se você está habilitado para consumir a API Nacional. Em alguns casos, será necessário utilizar a API específica do município que optou pelo emissor próprio, caso a integração via Nacional não esteja disponível ou habilitada para o seu perfil.

📚 **Documentação Técnica:** [nfse-php.netlify.app](https://nfse-php.netlify.app/)

## Instalação

Você pode instalar o pacote via composer:

```bash
composer require nfse-nacional/nfse-php
```

## Nota Fical Service `Nfse`

`Nfse` _facade_ (fachada) que centraliza e simplifica o acesso aos diferentes serviços disponíveis:

-   **`ContribuinteService`**: Para empresas que emitem notas fiscais de serviço
-   **`MunicipioService`**: Para prefeituras e órgãos municipais que gerenciam a arrecadação

```php
use Nfse\Nfse;
use Nfse\Http\NfseContext;

// Nfse centraliza o acesso aos serviços
$nfse = new Nfse($context);

// Contribuinte (empresas)
$contribuinte = $nfse->contribuinte();

// Municipio (prefeituras)
$municipio = $nfse->municipio();
```

Esta abordagem facilita a integração tanto para **empresas prestadoras de serviço** quanto para **municípios** com uma API unificada para ambos os tipos de usuários do sistema nacional.

## Uso

Exemplo básico de utilização dos DTOs:

```php
use Nfse\Dto\Nfse\DpsData;

// Exemplo de instanciação usando Array (Padrão Nacional)
// Usa as tags XML exatamente como aparecem no schema
$dps = new DpsData([
    '@attributes' => [
        'versao' => '1.00',
    ],
    'infDPS' => [
        '@attributes' => [
            'Id' => 'DPS...',  // ID gerado
        ],
        // ... dados da DPS usando tags XML
        'tpAmb' => 2,
        'prest' => [
            'CNPJ' => '12345678000199',
        ],
    ]
]);
```

## Exemplo Completo

Abaixo, um exemplo de como gerar o ID, criar o objeto DPS, gerar o XML e assiná-lo digitalmente.

```php
use Nfse\Dto\Nfse\DpsData;
use Nfse\Xml\DpsXmlBuilder;
use Nfse\Signer\Certificate;
use Nfse\Signer\XmlSigner;
use Nfse\Support\IdGenerator;

// 1. Gerar o ID da DPS
// Formato: DPS + Cód.Mun.(7) + Tipo Inscr.(1) + Inscr.Fed.(14) + Série(5) + Número(15)
$id = IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001');

// 2. Instanciar o DTO usando Array (Padrão Nacional)
$dps = new DpsData([
    '@attributes' => [
        'versao' => '1.00',
    ],
    'infDPS' => [
        '@attributes' => [
            'Id' => $id,
        ],
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
            'regTrib' => [
                    'opSimpNac' => 3,   // 1- Não optante 2 Optante (MEI) 3 - Optante (ME/EPP)
                    'regApTribSN' => 1, // se Aplicável
                    'regEspTrib' => 0,
                ],
        ],
        'toma' => [
            'CPF' => '11122233344',
            'xNome' => 'Tomador Exemplo',
            
        ],
        'serv' => [
            'locPrest' => [
                'cLocPrestacao' => '3550308',
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
                'tribMun' => [
                    'tribISSQN' => 1, // 1 - Operação tributável
                    'tpRetISSQN' => 1, // 1 - Não Retido
                ],
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

// Baixar documentos (Contribuinte)
// Parâmetros opcionais: $cnpjConsulta (para terceiros) e $lote (default true)
$notas = $contribuinte->baixarDfe(nsu: 100, cnpjConsulta: '12345678000199');

// Baixar arrecadação (Município)
$municipio = $nfse->municipio();
// Parâmetros opcionais: $tipoNSU (RECEPCAO, DISTRIBUICAO, GERAL, MEI) e $lote
$notas = $municipio->baixarDfe(nsu: 100, tipoNSU: 'GERAL');
```

## 🗺️ Roadmap

Este projeto está em desenvolvimento ativo. Abaixo estão as fases planejadas:

### Fase 1: Estrutura de Dados (DTOs) ✅

-   [x] Implementar DTOs usando `spatie/data-transfer-object`.
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

## 💖 Sponsors

Este projeto é mantido de forma independente e só é possível graças à parceria técnica com empresas e municípios parceiros. Por questões de _compliance_ e confidencialidade, esses parceiros não podem ser citados nominalmente, mas seu apoio foi fundamental para chegarmos até aqui.

Para garantir a continuidade, manutenção e evolução constante do SDK, precisamos de novos patrocinadores. Os custos do projeto incluem:

-   **Infraestrutura de CI/CD**: Execução de testes automatizados e builds via GitHub Actions.
-   **Agentes de IA**: Utilização de ferramentas avançadas de codificação para acelerar o desenvolvimento.
-   **Café e Tempo**: Manter um projeto desse porte exige dedicação exclusiva e, claro, muito café!

Se este projeto é útil para você ou sua empresa, considere nos apoiar através do [GitHub Sponsors](https://github.com/sponsors/a21ns1g4ts).

## Credits

-   [A21ns1g4ts](https://github.com/a21ns1g4ts)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
