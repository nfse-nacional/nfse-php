<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TotalTribData;

it('can instantiate TotalTribData via map helper', function () {
    $dto = \map(TotalTribData::class, []);
    expect($dto)->toBeInstanceOf(TotalTribData::class);
});

