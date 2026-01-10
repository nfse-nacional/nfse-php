<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TotTribData;

it('can instantiate TotTribData', function () {
    $dto = new TotTribData([]);
    expect($dto)->toBeInstanceOf(TotTribData::class);
});

it('can set properties for TotTribData', function () {
    $data = [
        'indTotTrib' => 'test',
        'pTotTribSN' => 'test',
    ];

    $dto = map(TotTribData::class, $data);

    expect($dto->indTotTrib)->toBe('test');
    expect($dto->pTotTribSN)->toBe('test');
});
