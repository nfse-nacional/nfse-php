---
title: Contribuinte Service
sidebar_position: 2
---

# Contribuinte Service 👤

O `ContribuinteService` é destinado a emissores (prestadores) e tomadores de serviço. Ele permite emitir notas, consultar documentos e gerenciar o ciclo de vida da NFS-e.

## Instanciação

```php
use Nfse\Nfse;

$nfse = new Nfse($context);
$service = $nfse->contribuinte();
```

## Emissão de NFS-e

A emissão é feita através do envio de um objeto `DpsData`. O serviço cuida da geração do XML, assinatura digital e transporte.

```php
use Nfse\Dto\DpsData;
// ... outros imports de DTOs

try {
    $nfse = $service->emitir($dps);
    echo "NFS-e emitida: " . $nfse->infNfse->numeroNfse;
} catch (\Exception $e) {
    echo "Erro: " . $e->getMessage();
}
```

## Consulta de NFS-e

Você pode recuperar os dados de uma nota pela sua chave de acesso.

```php
$nfse = $service->consultar('352310...');

if ($nfse) {
    echo "Valor: " . $nfse->infNfse->valores->valorServicos;
}
```

## Download de DANFSe (PDF)

Obtém o conteúdo binário do PDF para visualização ou impressão.

```php
$pdf = $service->downloadDanfse($chaveAcesso);
file_put_contents('nota.pdf', $pdf);
```

## Gestão de Eventos

Lista eventos vinculados a uma nota (cancelamentos, substituições, etc).

```php
$eventos = $service->listarEventos($chaveAcesso);
```

## Parâmetros Municipais

Consulta regras de tributação e convênios de um município.

```php
// Consultar convênio do município
$response = $service->consultarParametrosConvenio('3550308');
echo $response->mensagem;
echo $response->parametrosConvenio->tipoConvenio;

// Consultar alíquota para um serviço
// NOTA: O código do serviço deve estar no formato 00.00.00.000 (9 dígitos)
// A competência deve seguir o formato ISO8601 (AAAA-MM-DDThh:mm:ss)
$response = $service->consultarAliquota('3550308', '01.01.00.001', '2025-01-01T12:00:00');
echo $response->mensagem;
$aliquotas = $response->aliquotas['01.01.00.001'];
echo $aliquotas[0]->aliquota; // 5.0
```

## Distribuição (ADN Contribuinte)

Baixa documentos onde o contribuinte figura como prestador ou tomador de forma incremental via NSU (Número Seqüencial Único).

```php
// Baixa novos documentos a partir do NSU 100
$documentos = $service->baixarDfe(100);
```
