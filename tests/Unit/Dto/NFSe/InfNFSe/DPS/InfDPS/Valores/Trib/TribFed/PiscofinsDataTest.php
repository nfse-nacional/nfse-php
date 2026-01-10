<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribFed;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TribFed\PiscofinsData;

it('can instantiate PiscofinsData', function () {
    $dto = new PiscofinsData([]);
    expect($dto)->toBeInstanceOf(PiscofinsData::class);
});

it('can set properties for PiscofinsData', function () {
    $data = [
        'CST' => 'test',
        'vBCPisCofins' => 'test',
        'pAliqPis' => 'test',
        'pAliqCofins' => 'test',
        'vPis' => 'test',
        'vCofins' => 'test',
        'tpRetPisCofins' => 'test',
    ];

    $dto = map(PiscofinsData::class, $data);

    expect($dto->cST)->toBe('test');
    expect($dto->vBCPisCofins)->toBe('test');
    expect($dto->pAliqPis)->toBe('test');
    expect($dto->pAliqCofins)->toBe('test');
    expect($dto->vPis)->toBe('test');
    expect($dto->vCofins)->toBe('test');
    expect($dto->tpRetPisCofins)->toBe('test');
});
