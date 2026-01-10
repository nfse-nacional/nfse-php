<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRedData;

it('can instantiate VDedRedData via map helper', function () {
    $dto = \map(VDedRedData::class, []);
    expect($dto)->toBeInstanceOf(VDedRedData::class);
});

it('can map properties for VDedRedData', function () {
    $data = [
        'pDR' => 'test',
        'vDR' => 'test',
    ];

    $dto = \map(VDedRedData::class, $data);

    expect($dto->pDR)->toBe('test');
    expect($dto->vDR)->toBe('test');
});
