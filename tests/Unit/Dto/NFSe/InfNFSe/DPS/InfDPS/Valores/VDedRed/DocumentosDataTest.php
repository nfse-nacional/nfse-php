<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\DocumentosData;

it('can instantiate DocumentosData', function () {
    $dto = new DocumentosData([]);
    expect($dto)->toBeInstanceOf(DocumentosData::class);
});

