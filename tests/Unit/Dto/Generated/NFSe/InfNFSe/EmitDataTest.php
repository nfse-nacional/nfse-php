<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe;

use Nfse\Dto\NFSe\InfNFSe\EmitData;

it('can instantiate EmitData via map helper', function () {
    $dto = \map(EmitData::class, []);
    expect($dto)->toBeInstanceOf(EmitData::class);
});

it('can map properties for EmitData', function () {
    $data = [
        'CNPJ' => 'test',
        'CPF' => 'test',
        'IM' => 'test',
        'xNome' => 'test',
        'xFant' => 'test',
        'fone' => 'test',
        'email' => 'test',
    ];

    $dto = \map(EmitData::class, $data);

    expect($dto->CNPJ)->toBe('test');
    expect($dto->CPF)->toBe('test');
    expect($dto->IM)->toBe('test');
    expect($dto->xNome)->toBe('test');
    expect($dto->xFant)->toBe('test');
    expect($dto->fone)->toBe('test');
    expect($dto->email)->toBe('test');
});
