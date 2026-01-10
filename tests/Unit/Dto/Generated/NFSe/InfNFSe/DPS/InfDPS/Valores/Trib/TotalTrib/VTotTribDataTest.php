<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TotalTrib;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TotalTrib\VTotTribData;

it('can instantiate VTotTribData via map helper', function () {
    $dto = \map(VTotTribData::class, []);
    expect($dto)->toBeInstanceOf(VTotTribData::class);
});

it('can map properties for VTotTribData', function () {
    $data = [
        'vTotTribFed' => 'test',
        'vTotTribEst' => 'test',
        'vTotTribMun' => 'test',
    ];

    $dto = \map(VTotTribData::class, $data);

    expect($dto->vTotTribFed)->toBe('test');
    expect($dto->vTotTribEst)->toBe('test');
    expect($dto->vTotTribMun)->toBe('test');
});
