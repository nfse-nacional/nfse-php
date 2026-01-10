<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDescCondIncondData;

it('can instantiate VDescCondIncondData via map helper', function () {
    $dto = \map(VDescCondIncondData::class, []);
    expect($dto)->toBeInstanceOf(VDescCondIncondData::class);
});

it('can map properties for VDescCondIncondData', function () {
    $data = [
        'vDescIncond' => 'test',
        'vDescCond' => 'test',
    ];

    $dto = \map(VDescCondIncondData::class, $data);

    expect($dto->vDescIncond)->toBe('test');
    expect($dto->vDescCond)->toBe('test');
});
