<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TotTribData;

it('can instantiate TotTribData via map helper', function () {
    $dto = \map(TotTribData::class, []);
    expect($dto)->toBeInstanceOf(TotTribData::class);
});

it('can map properties for TotTribData', function () {
    $data = [
        'indTotTrib' => 'test',
        'pTotTribSN' => 'test',
    ];

    $dto = \map(TotTribData::class, $data);

    expect($dto->indTotTrib)->toBe('test');
    expect($dto->pTotTribSN)->toBe('test');
});
