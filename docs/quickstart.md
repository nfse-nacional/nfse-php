---
title: Quickstart
sidebar_position: 2
---

## Instalação

Instale via Composer:

```bash
composer require nfse-nacional/nfse-php
```

## Exemplo rápido: emitir uma NFS-e (em 1 minuto)

1. Configure o contexto (caminho para o PFX e senha):

```php
use Nfse\Http\NfseContext;
use Nfse\Nfse;
use Nfse\Enums\TipoAmbiente;

$context = new NfseContext(
    TipoAmbiente::Homologacao,
    '/path/to/certificate.pfx',
    'password'
);

// Use the main entry point to obtain services
$nfse = new Nfse($context);
$service = $nfse->contribuinte();
```

2. Monte um DPS mínimo e emita:

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
// Note: atualmente o parser de retorno ainda está em desenvolvimento —
// a API retorna o XML da NFS-e compactado; o serviço deve retornar
// um objeto NfseData quando o parser estiver disponível.
// Exemplo de mensagem de sucesso (simulada):
// echo "Nota emitida! Número: {$nfse->infNfse->numeroNfse}";
```

Pronto — você emitiu sua primeira nota. Próximos passos recomendados: configurar corretamente o certificado, aprender a consultar notas e a tratar eventos (cancelamento).

> Nota: este arquivo foi movido para a pasta de documentos utilizada pelo site de documentação.
> A versão canônica está em `/docs/quickstart` (arquivo: `/docs/docs/quickstart.md`).
