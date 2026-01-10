<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\DocumentosData;

it('can instantiate DocumentosData via map helper', function () {
    $dto = \map(DocumentosData::class, []);
    expect($dto)->toBeInstanceOf(DocumentosData::class);
});

