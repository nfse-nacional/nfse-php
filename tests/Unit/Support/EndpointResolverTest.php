<?php

use Nfse\Enums\TipoAmbiente;
use Nfse\Http\NfseContext;
use Nfse\Support\SefinEndpointResolver;
use Nfse\Dto\Http\Endpoint;

it('resolves default production endpoint when municipio is not informed', function () {
    $context = new NfseContext(
        ambiente: TipoAmbiente::Producao,
        certificatePath: '/tmp/cert.pfx',
        certificatePassword: '123456'
    );

    $resolver = new SefinEndpointResolver();
    expect($resolver->resolve($context))
        ->toBe('https://sefin.nfse.gov.br/SefinNacional');
});

it('resolves default homologation endpoint when municipio is not informed', function () {
    $context = new NfseContext(
        ambiente: TipoAmbiente::Homologacao,
        certificatePath: '/tmp/cert.pfx',
        certificatePassword: '123456'
    );

    $resolver = new SefinEndpointResolver();
    expect($resolver->resolve($context))
        ->toBe('https://sefin.producaorestrita.nfse.gov.br/SefinNacional');
});

it('resolves Catanduva production endpoint', function () {
    $context = new NfseContext(
        ambiente: TipoAmbiente::Producao,
        certificatePath: '/tmp/cert.pfx',
        certificatePassword: '123456',
        codigoMunicipio: '3511102'
    );

    $resolver = new SefinEndpointResolver();
    expect($resolver->resolve($context))
        ->toBe('https://164.152.60.237/nota/nacional');
});

it('resolves Catanduva homologation endpoint', function () {
    $context = new NfseContext(
        ambiente: TipoAmbiente::Homologacao,
        certificatePath: '/tmp/cert.pfx',
        certificatePassword: '123456',
        codigoMunicipio: '3511102'
    );

    $resolver = new SefinEndpointResolver();
    expect($resolver->resolve($context))
        ->toBe('https://catanduva.prefeitura.rlz.com.br/nota/nacional');
});

it('resolves custom endpoint when provided in context', function () {
    $customEndpoint = new Endpoint([
        'production' => 'https://custom.api.com/prod',
        'homologation' => 'https://custom.api.com/homo',
    ]);

    $context = new NfseContext(
        ambiente: TipoAmbiente::Producao,
        certificatePath: '/tmp/cert.pfx',
        certificatePassword: '123456',
        endpoint: $customEndpoint
    );

    $resolver = new SefinEndpointResolver();
    expect($resolver->resolve($context))
        ->toBe('https://custom.api.com/prod');

    $context->ambiente = TipoAmbiente::Homologacao;
    expect($resolver->resolve($context))
        ->toBe('https://custom.api.com/homo');
});