<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\PrestData;

it('can instantiate PrestData via map helper', function () {
    $dto = \map(PrestData::class, []);
    expect($dto)->toBeInstanceOf(PrestData::class);
});

it('can map properties for PrestData', function () {
    $data = [
        'CNPJ' => 'test',
        'CPF' => 'test',
        'NIF' => 'test',
        'cNaoNIF' => 'test',
        'CAEPF' => 'test',
        'IM' => 'test',
        'xNome' => 'test',
        'endNac' => 'test',
        'fone' => 'test',
        'email' => 'test',
    ];

    $dto = \map(PrestData::class, $data);

    expect($dto->CNPJ)->toBe('test');
    expect($dto->CPF)->toBe('test');
    expect($dto->NIF)->toBe('test');
    expect($dto->cNaoNIF)->toBe('test');
    expect($dto->CAEPF)->toBe('test');
    expect($dto->IM)->toBe('test');
    expect($dto->xNome)->toBe('test');
    expect($dto->endNac)->toBe('test');
    expect($dto->fone)->toBe('test');
    expect($dto->email)->toBe('test');
});
