<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\EndData;

it('can instantiate EndData via map helper', function () {
    $dto = \map(EndData::class, []);
    expect($dto)->toBeInstanceOf(EndData::class);
});

