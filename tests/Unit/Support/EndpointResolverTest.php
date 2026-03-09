<?php

use Nfse\Enums\TipoAmbiente;
use Nfse\Http\NfseContext;
use Nfse\Support\EndpointResolver;

it('resolves default production endpoint when municipio is not informed', function () {
    $context = new NfseContext(
        ambiente: TipoAmbiente::Producao,
        certificatePath: '/tmp/cert.pfx',
        certificatePassword: '123456'
    );

    expect(EndpointResolver::resolve($context))
        ->toBe('https://sefin.nfse.gov.br/SefinNacional');
});

it('resolves default homologation endpoint when municipio is not informed', function () {
    $context = new NfseContext(
        ambiente: TipoAmbiente::Homologacao,
        certificatePath: '/tmp/cert.pfx',
        certificatePassword: '123456'
    );

    expect(EndpointResolver::resolve($context))
        ->toBe('https://sefin.producaorestrita.nfse.gov.br/SefinNacional');
});

it('resolves Catanduva production endpoint', function () {
    $context = new NfseContext(
        ambiente: TipoAmbiente::Producao,
        certificatePath: '/tmp/cert.pfx',
        certificatePassword: '123456',
        codigoMunicipio: '3511102'
    );

    expect(EndpointResolver::resolve($context))
        ->toBe('https://164.152.60.237/nota/nacional');
});

it('resolves Catanduva homologation endpoint', function () {
    $context = new NfseContext(
        ambiente: TipoAmbiente::Homologacao,
        certificatePath: '/tmp/cert.pfx',
        certificatePassword: '123456',
        codigoMunicipio: '3511102'
    );

    expect(EndpointResolver::resolve($context))
        ->toBe('https://catanduva.prefeitura.rlz.com.br/nota/nacional');
});