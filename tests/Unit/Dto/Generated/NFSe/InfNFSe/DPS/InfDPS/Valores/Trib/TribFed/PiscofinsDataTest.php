<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribFed;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribFed\PiscofinsData;

it('can instantiate PiscofinsData via map helper', function () {
    $dto = \map(PiscofinsData::class, []);
    expect($dto)->toBeInstanceOf(PiscofinsData::class);
});

it('can map properties for PiscofinsData', function () {
    $data = [
        'CST' => 'test',
        'vBCPisCofins' => 'test',
        'pAliqPis' => 'test',
        'pAliqCofins' => 'test',
        'vPis' => 'test',
        'vCofins' => 'test',
        'tpRetPisCofins' => 'test',
    ];

    $dto = \map(PiscofinsData::class, $data);

    expect($dto->CST)->toBe('test');
    expect($dto->vBCPisCofins)->toBe('test');
    expect($dto->pAliqPis)->toBe('test');
    expect($dto->pAliqCofins)->toBe('test');
    expect($dto->vPis)->toBe('test');
    expect($dto->vCofins)->toBe('test');
    expect($dto->tpRetPisCofins)->toBe('test');
});
