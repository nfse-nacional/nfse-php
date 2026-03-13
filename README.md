# 🚀 NFS-e Nacional PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nfse-nacional/nfse-php.svg?style=flat-square)](https://packagist.org/packages/nfse-nacional/nfse-php)
[![Coverage](https://img.shields.io/codecov/c/github/nfse-nacional/nfse-php/main?style=flat-square)](https://codecov.io/gh/nfse-nacional/nfse-php)
[![Total Downloads](https://img.shields.io/packagist/dt/nfse-nacional/nfse-php.svg?style=flat-square)](https://packagist.org/packages/nfse-nacional/nfse-php)

A maneira mais moderna e eficiente de integrar PHP com a NFS-e Nacional.

## 📦 Instalação

```bash
composer require nfse-nacional/nfse-php
```

## 🛠️ Uso dos Serviços

O pacote expõe dois serviços principais através da `NfseContext`: **ContribuinteService** (para emissores) e **MunicipioService** (para prefeituras).

### Configuração Inicial

```php
use Nfse\Nfse;
use Nfse\Http\NfseContext;
use Nfse\Enums\TipoAmbiente;

$context = new NfseContext(
    ambiente: TipoAmbiente::Homologacao,
    certificatePath: '/path/to/certificate.pfx',
    certificatePassword: 'password'
);

$nfse = new Nfse($context);
```

### 🏢 ContribuinteService

Focado nas necessidades de empresas que emitem notas.

```php
$service = $nfse->contribuinte();

// Principais Métodos:

// 1. Emitir NFS-e
$nfseData = $service->emitir($dps); // Retorna NfseData

// 2. Consultar NFS-e
$nfseData = $service->consultar('CHAVE_ACESSO');

// 3. Baixar Documentos (Notas recebidas/emitidas)
$docs = $service->baixarDfe(nsu: 100);

// 4. Outros métodos úteis
$service->consultarDps('ID_DPS');
$service->downloadDanfse('CHAVE_ACESSO'); // Retorna PDF binário
$service->registrarEvento('CHAVE_ACESSO', $xmlEvento); // Ex: Cancelamento
$service->consultarParametrosConvenio('CODIGO_MUNICIPIO');
```

### 🏛️ MunicipioService

Focado nas necessidades de prefeituras e órgãos gestores.

```php
$service = $nfse->municipio();

// Principais Métodos:

// 1. Baixar Arrecadação e Notas
$docs = $service->baixarDfe(nsu: 100, tipoNSU: 'GERAL');

// 2. Consulta Cadastral (CNC)
$dados = $service->consultarContribuinte('CPF_CNPJ');

// 3. Parâmetros e Configurações
$params = $service->consultarParametrosConvenio('CODIGO_MUNICIPIO');
$aliquotas = $service->consultarAliquota('COD_MUN', 'COD_SERV', 'COMPETENCIA');
```

## 📝 Exemplo de DPS (Declaração de Prestação de Serviço)

Abaixo, um exemplo completo de como montar o objeto DPS para emissão.

```php
use Nfse\Dto\Nfse\DpsData;
use Nfse\Support\IdGenerator;

// Gerar ID único para a DPS
$idDps = IdGenerator::generateDpsId('12345678000199', '3550308', '1', '1001');

$dps = new DpsData([
    '@attributes' => ['versao' => '1.00'],
    'infDPS' => [
        '@attributes' => ['Id' => $idDps],
        'tpAmb' => 2,                // 1-Produção, 2-Homologação
        'dhEmi' => date('Y-m-d\TH:i:s'),
        'verAplic' => '1.0.0',
        'serie' => '1',
        'nDPS' => '1001',
        'dCompet' => date('Y-m-d'),
        'tpEmit' => 1,               // 1-Prestador
        'cLocEmi' => '3550308',      // Código IBGE Município
        'prest' => [
            'CNPJ' => '12345678000199'
        ],
        'toma' => [
            'CPF' => '11122233344',
            'xNome' => 'Cliente Exemplo'
        ],
        'serv' => [
            'locPrest' => [
                'cLocPrestacao' => '3550308'
            ],
            'cServ' => [
                'cTribNac' => '01.01',  // Código Tributação Nacional
                'xDescServ' => 'Desenvolvimento de Software'
            ]
        ],
        'valores' => [
            'vServPrest' => [
                'vReceb' => 1000.00,
                'vServ' => 1000.00
            ],
            'trib' => [
                'tribMun' => [
                    'tribISSQN' => 1,    // 1-Tributável
                    'tpRetISSQN' => 2,   // 1-Retido, 2-Não Retido
                    'pAliq' => 5.00
                ]
            ]
        ]
    ]
]);

// Emitir
$nfse->contribuinte()->emitir($dps);
```

## 🌍 Municípios Atendidos

A biblioteca é compatível com todos os municípios que aderiram ao padrão nacional da NFS-e. Você pode consultar a lista atualizada de municípios conveniados através dos links oficiais:

- [Monitoramento de Adesões (Portal Gov.br)](https://www.gov.br/nfse/pt-br/municipios/monitoramento-adesoes)
- [Painel Geoestatístico de Adesões (Power BI)](https://app.powerbi.com/view?r=eyJrIjoiNGQ4YTcxNmMtMzdhNC00Mzc5LTllM2EtMjY1MTM3NWQyZDgyIiwidCI6IjZmNDlhYTQzLTgyMmEtNGMyMC05NjcwLWRiNzcwMGJmMWViMCJ9&pageName=608609c2e0a53d7a3c6e)

### 🚀 Municípios Testados (Mesmo Contrato API)

Alguns municípios utilizam servidores próprios, mas seguem rigorosamente o contrato da API Nacional (DPS). Então resolvemos corretamente os endpoints no pacote. Abaixo temos uma lista de municipios que foram testados nesse contexto.

| Município | UF  | Status     | Observação                                                       |
| :-------- | :-- | :--------- | :--------------------------------------------------------------- |
| Catanduva | SP  | ✅ Testado | Utiliza infraestrutura própria (RLZ) seguindo contrato nacional. |

#### Exemplo com Endpoint Customizado:

O pacote também permite que você informe endpoints próprios caso você queira usar um servidor diferente.

```php
use Nfse\Http\NfseContext;
use Nfse\Dto\Http\Endpoint;
use Nfse\Enums\TipoAmbiente;

$context = new NfseContext(
    ambiente: TipoAmbiente::Producao,
    certificatePath: '/path/to/cert.pfx',
    certificatePassword: 'password',
    endpoint: new Endpoint([
        'production'   => 'https://164.152.60.237/nota/nacional',
        'homologation' => 'https://catanduva.prefeitura.rlz.com.br/nota/nacional',
    ])
);
```

Ou enviar o código do município homologado pela nfse-nacional/nfse-php através do parâmetro correspondente

```php
use Nfse\Http\NfseContext;
use Nfse\Dto\Http\Endpoint;
use Nfse\Enums\TipoAmbiente;

$context = new NfseContext(
    ambiente: TipoAmbiente::Producao,
    certificatePath: '/path/to/cert.pfx',
    certificatePassword: 'password',
    codigoMunicipio: '3511102' // Catanduva/SP
);
```

## Endpoints por Município

Alguns municípios utilizam endpoints próprios mesmo seguindo o padrão nacional da NFS-e.
Consulte a lista completa no arquivo:

👉 [Endpoints por Município](endpoints.md)


## 📚 Documentação Completa

Para detalhes profundos sobre cada DTO e configurações avançadas, visite nossa [Documentação Oficial](https://nfse-php.netlify.app/).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
