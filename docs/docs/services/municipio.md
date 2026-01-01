---
title: Município Service
sidebar_position: 3
---

# Município Service 🏛️

O `MunicipioService` é exclusivo para prefeituras e órgãos autorizados. Ele permite a gestão da arrecadação municipal e a integração com o Cadastro Nacional de Contribuintes (CNC).

## Instanciação

```php
use Nfse\Nfse;

$nfse = new Nfse($context);
$service = $nfse->municipio();
```

## Sincronização de Documentos (ADN Município)

Permite ao município baixar todos os documentos fiscais emitidos ou tomados em sua jurisdição. Esta é a principal forma de manter a base local da prefeitura atualizada.

```php
// Baixa documentos do município via NSU
$dfe = $service->baixarDfe(12345);
```

## Recepção de Documentos (ADN Recepção)

Porta de entrada para enviar lotes de documentos (DPS, Eventos) para o ambiente nacional.

```php
// Envia lote de documentos (XML compactado em GZip e Base64)
$resultado = $service->enviarLote($xmlZipB64);
```

## Cadastro Nacional de Contribuintes (CNC)

Gerencia as informações cadastrais dos contribuintes no âmbito nacional.

### Consulta Cadastral

Consulta os dados atuais de um contribuinte no cadastro nacional.

```php
$dados = $service->consultarContribuinte('12345678000199');
```

### Sincronização de Cadastro

Recebe atualizações cadastrais de contribuintes de interesse do município.

```php
$alteracoes = $service->baixarAlteracoesCadastro(100);
```

### Atualização Cadastral

Envia dados para alimentar ou atualizar a base nacional.

```php
$dados = [
    // ... estrutura do cadastro conforme manual
];
$service->atualizarContribuinte($dados);
```

## Parâmetros Municipais

Consulta regras de tributação e convênios.

```php
// Consultar convênio do município
$response = $service->consultarParametrosConvenio('3550308');
echo $response->mensagem;

// Consultar alíquota para um serviço
// NOTA: O código do serviço deve estar no formato 00.00.00.000 (9 dígitos)
// A competência deve seguir o formato ISO8601 (AAAA-MM-DDThh:mm:ss)
$response = $service->consultarAliquota('3550308', '01.01.00.001', '2025-01-01T12:00:00');
echo $response->mensagem;
$aliquotas = $response->aliquotas['01.01.00.001'];
echo $aliquotas[0]->aliquota;
```
