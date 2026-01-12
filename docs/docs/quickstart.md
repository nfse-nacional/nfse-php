---
title: Quickstart
sidebar_position: 2
---

## 🚀 Começando Rápido

### Instalação

```bash
composer require nfse-nacional/nfse-php
```

### Configuração Básica

Tudo começa com o `NfseContext`, onde você define o ambiente (Produção/Homologação) e o certificado digital.

```php
use Nfse\Nfse;
use Nfse\Http\NfseContext;
use Nfse\Enums\TipoAmbiente;

// 1. Configure o contexto
$context = new NfseContext(
    ambiente: TipoAmbiente::Homologacao,
    certificatePath: '/path/to/certificate.pfx',
    certificatePassword: 'minha-senha'
);

// 2. Instancie a façade principal
$nfse = new Nfse($context);
```

### Escolha seu Serviço

A biblioteca divide as funcionalidades em dois serviços principais:

#### Para Empresas (Prestadores)

Use o `ContribuinteService` para emitir notas, consultar DPS, e baixar documentos fiscais.

```php
$contribuinte = $nfse->contribuinte();

// Exemplo: Emitir uma nota
$resultado = $contribuinte->emitir($dps);
```

#### Para Prefeituras (Municípios)

Use o `MunicipioService` para baixar a arrecadação, consultar contribuintes no cadastro nacional e gerenciar parâmetros.

```php
$municipio = $nfse->municipio();

// Exemplo: Baixar notas emitidas contra o município
$notas = $municipio->baixarDfe(nsu: 100);
```

### Exemplo Rápido: Emitindo uma Nota (DPS)

```php
use Nfse\Dto\Nfse\DpsData;
use Nfse\Support\IdGenerator;

// 1. Gere o ID único
$id = IdGenerator::generateDpsId('CNPJ_TRESTADOR', 'COD_MUN', 'SERIE', 'NUMERO');

// 2. Crie o objeto DPS
$dps = new DpsData([
    '@attributes' => ['versao' => '1.00'],
    'infDPS' => [
        '@attributes' => ['Id' => $id],
        'tpAmb' => 2,
        'dhEmi' => date('Y-m-d\TH:i:s'),
        'verAplic' => 'App 1.0',
        'serie' => '1',
        'nDPS' => '1001',
        'dCompet' => date('Y-m-d'),
        'tpEmit' => 1,
        'cLocEmi' => '3550308', // São Paulo
        'prest' => ['CNPJ' => '12345678000199'],
        'toma' => [
            'CPF' => '11122233344',
            'xNome' => 'Tomador de Exemplo'
        ],
        'serv' => [
            'locPrest' => ['cLocPrestacao' => '3550308'],
            'cServ' => [
                'cTribNac' => '01.01',
                'xDescServ' => 'Descrição do Serviço'
            ]
        ],
        'valores' => [
            'vServPrest' => [
                'vReceb' => 100.00,
                'vServ' => 100.00
            ],
            'trib' => [
                'tribMun' => [
                    'tribISSQN' => 1,
                    'tpRetISSQN' => 2, // Sem retenção
                    'pAliq' => 5.00
                ]
            ]
        ]
    ]
]);

// 3. Envie
try {
    $nfseData = $contribuinte->emitir($dps);
    echo "Sucesso! Nota emitida: " . $nfseData->infNfse->numeroNfse;
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage();
}
```
