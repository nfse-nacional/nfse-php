---
title: Emitir NFS-e
sidebar_position: 1
---

## Objetivo

Este guia detalha como montar um DPS e emitir uma NFS-e usando o Service do pacote.

### 1) Instanciar o Service

```php
use Nfse\Http\NfseContext;
use Nfse\Nfse;
use Nfse\Enums\TipoAmbiente;

$context = new NfseContext(
    TipoAmbiente::Homologacao,
    '/path/to/certificate.pfx',
    'password'
);

// Helper entry point
$nfse = new Nfse($context);
$service = $nfse->contribuinte();
```

### 2) Exemplo mínimo (array)

```php
use Nfse\Dto\Nfse\DpsData;

$dps = new DpsData(
    versao: '1.00',
    infDps: [
        'id' => 'DPS123',
        'tipoAmbiente' => 2,
        'prestador' => ['cnpj' => '12345678000199'],
        'tomador' => ['cpf' => '11122233344'],
        'servico' => ['codigoTributacaoNacional' => '01.01'],
        'valores' => ['valorServicoPrestado' => ['valorServico' => 100.00]]
    ]
);

$nfse = $service->emitir($dps);
// O método atualmente retorna o XML compacto da resposta; quando o
// parser estiver implementado, será retornado um objeto NfseData.
```

### 3) Exemplo semântico (objetos DTO)

```php
use Nfse\Dto\Nfse\DpsData;
use Nfse\Dto\Nfse\InfDpsData;
use Nfse\Dto\Nfse\PrestadorData;
use Nfse\Dto\Nfse\TomadorData;

$dps = new DpsData(
    versao: '1.00',
    infDps: new InfDpsData(
        id: 'DPS123',
        tipoAmbiente: 2,
        prestador: new PrestadorData(cnpj: '12345678000199'),
        tomador: new TomadorData(cpf: '11122233344'),
        servico: ...
    )
);

$nfse = $service->emitir($dps);
```

### 4) Tratamento de erros

-   Validação: o pacote pode lançar exceções de validação se campos estiverem faltando ou estiverem no formato errado.
-   Erros do provedor: trate exceções de rede e respostas de erro retornadas pela SEFIN.

> Dica: Teste em Homologação antes de migrar para Produção.
