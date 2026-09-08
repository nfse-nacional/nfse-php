# 🚀 NFS-e Nacional PHP SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nfse-nacional/nfse-php.svg?style=flat-square)](https://packagist.org/packages/nfse-nacional/nfse-php)
[![Coverage](https://img.shields.io/codecov/c/github/nfse-nacional/nfse-php/main?style=flat-square)](https://codecov.io/gh/nfse-nacional/nfse-php)
[![Total Downloads](https://img.shields.io/packagist/dt/nfse-nacional/nfse-php.svg?style=flat-square)](https://packagist.org/packages/nfse-nacional/nfse-php)

## Versão estável aberta para sugestões e melhorias

[Discussão: modelo arquitetural estável](https://github.com/nfse-nacional/nfse-php/issues/13)

> _A bibiloteca se mostrou bastante útil no dia a dia, mas nem tudo que parece **“útil”** é realmente *bom de verdade*. Com o tempo, a gente consegue enxergar com mais clareza o ruído gerado por determinadas interfaces e abstrações._

A experiência real de utilização permitiu identificar pontos da arquitetura que podem ser refinados e simplificados, principalmente nas responsabilidades, interfaces e abstrações entre objetos e classes.

Algumas ideias presentes no modelo atual foram úteis durante a evolução do projeto, mas certas decisões arquiteturais acabaram adicionando complexidade e ruído desnecessários em alguns cenários de uso. Esse processo de amadurecimento faz parte da evolução natural do SDK.

A próxima versão será uma oportunidade para consolidar uma arquitetura mais simples, previsível e sustentável no longo prazo, além de tornar a construção de uma versão estável algo mais aberto, democrático e colaborativo com a comunidade.

A ideia é evoluir o projeto sem perder o foco principal: oferecer uma das maneiras mais modernas e eficientes de integrar aplicações PHP com a NFS-e Nacional.

Conto com a ajuda e sugestões de todos para construirmos uma versão estável sólida e sustentável no longo prazo.

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

## 🔎 Preenchimento automático do tomador (CPF/CNPJ)

Para evitar a digitação manual, principal origem de rejeição de schema (endereço com caractere inválido, CEP ou município errados), há um resolver opcional que preenche o `TomadorData` (nome ou razão social, endereço, CEP e código IBGE do município) a partir do CPF ou CNPJ. A fonte de dados fica atrás da interface `Nfse\Support\Contracts\PessoaLookup`, aberta a qualquer provedor. A implementação de referência usa a API da [CPF.CNPJ](https://www.cpfcnpj.com.br).

```php
use Nfse\Support\TomadorResolver;

$resolver = TomadorResolver::comToken(getenv('CPFCNPJ_TOKEN'));

// Detecta CPF ou CNPJ pelo tamanho; há também porCpf() e porCnpj().
$tomador = $resolver->porDocumento('44827692000111');

$dps = new DpsData([
    '@attributes' => ['versao' => '1.01'],
    'infDPS' => [
        // ...
        'toma' => $tomador->toArray(),
    ],
]);
```

### Token de integração

A implementação de referência requer um token da CPF.CNPJ:

1. Crie uma conta em [cpfcnpj.com.br](https://www.cpfcnpj.com.br);
2. No painel, acesse **API > Tokens** e gere um token (atrelado ao IP de origem da requisição);
3. Passe-o ao resolver: `TomadorResolver::comToken($token)`.

Para desenvolvimento há um token público de testes que retorna dados fictícios: `5ae973d7a997af13f0aaf2bf60e65803`.

Você pode escolher o pacote de consulta. Para CPF, `1` traz somente o nome e `3` traz nome e endereço. Para CNPJ, `5` traz razão social e endereço e `6` inclui também o Simples Nacional, a situação cadastral e o porte:

```php
$resolver = TomadorResolver::comToken($token, pacoteCpf: 3, pacoteCnpj: 6);
```

### Sobre a CPF.CNPJ

A [CPF.CNPJ](https://www.cpfcnpj.com.br) é um serviço brasileiro de consulta cadastral de CPF e CNPJ. Os dados são retornados atualizados em D+0 (no mesmo dia da consulta), com 100% de cobertura dos documentos consultados, diferente das bases mensais que o governo distribui, cuja defasagem média é de cerca de 45 dias. Para PJ, o pacote CNPJ D (`6`) inclui o enquadramento no Simples Nacional e SIMEI, útil para decidir a tributação e a retenção na emissão, já que uma empresa pode mudar de regime a qualquer momento.

## 🌍 Municípios Atendidos

A biblioteca é compatível com todos os municípios que aderiram ao padrão nacional da NFS-e. Você pode consultar a lista atualizada de municípios conveniados através dos links oficiais:

- [Monitoramento de Adesões (Portal Gov.br)](https://www.gov.br/nfse/pt-br/municipios/monitoramento-adesoes)
- [Painel Geoestatístico de Adesões (Power BI)](https://app.powerbi.com/view?r=eyJrIjoiNGQ4YTcxNmMtMzdhNC00Mzc5LTllM2EtMjY1MTM3NWQyZDgyIiwidCI6IjZmNDlhYTQzLTgyMmEtNGMyMC05NjcwLWRiNzcwMGJmMWViMCJ9&pageName=608609c2e0a53d7a3c6e)

### 🚀 Municípios Testados (Mesmo Contrato API)

Alguns municípios utilizam servidores próprios, mas seguem rigorosamente o contrato da API Nacional (DPS). Então resolvemos corretamente os endpoints no pacote. Abaixo temos uma lista de municipios que foram testados nesse contexto.

| Município | UF  | Status     | Observação                                                       |
| :-------- | :-- | :--------- | :--------------------------------------------------------------- |
| Catanduva | SP  | ✅ Testado | Utiliza infraestrutura própria (RLZ) seguindo contrato nacional. |

Para esses municípios o `downloadDanfse()` também busca o PDF no servidor da própria prefeitura
(`{endpoint}/danfse/{chaveAcesso}/pdf`), em vez do ambiente nacional (que frequentemente responde 503).
A chamada não muda: basta informar o `codigoMunicipio` no `NfseContext`.

Para os demais municípios (que passam pelo ambiente nacional), as consultas e downloads são repetidos
automaticamente até 2 vezes quando o servidor responde 502/503/504 ou derruba a conexão, com backoff de
1s e 2s. Envios (POST) nunca são repetidos, para não duplicar NFS-e ou evento.

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
