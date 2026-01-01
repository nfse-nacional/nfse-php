---
title: Quickstart
sidebar_position: 2
---

Um guia rápido para começar com o pacote.

```php
use Nfse\Http\NfseContext;
use Nfse\Nfse;
use Nfse\Enums\TipoAmbiente;

$context = new NfseContext(
    TipoAmbiente::Homologacao,
    '/path/to/certificate.pfx',
    'password'
);

$nfse = new Nfse($context);
$service = $nfse->contribuinte();

// Emitir uma NFS-e mínima (exemplo)
use Nfse\Dto\Nfse\DpsData;

$dps = new DpsData(versao: '1.00', infDps: ['id' => 'DPS123', 'tipoAmbiente' => 2 /* ... */]);
$nfse = $service->emitir($dps);

// Consultar
$nfse = $service->consultar('chave...');

// Registrar evento
// Preparar XML -> assinar -> gzip+base64 -> registrarEvento(chave, payload)
```
