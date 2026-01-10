<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TotalTrib;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TotalTrib\PTotTribData;

it('can instantiate PTotTribData', function () {
    $dto = new PTotTribData([]);
    expect($dto)->toBeInstanceOf(PTotTribData::class);
});

it('can set properties for PTotTribData', function () {
    $data = [
        'pTotTribFed' => 'test',
        'pTotTribEst' => 'test',
        'pTotTribMun' => 'test',
    ];

    $dto = map(PTotTribData::class, $data);

    expect($dto->pTotTribFed)->toBe('test');
    expect($dto->pTotTribEst)->toBe('test');
    expect($dto->pTotTribMun)->toBe('test');
});
