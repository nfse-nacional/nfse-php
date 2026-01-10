<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\Trib\TotalTribData;

it('can instantiate TotalTribData', function () {
    $dto = new TotalTribData([]);
    expect($dto)->toBeInstanceOf(TotalTribData::class);
});

