<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\VDedRed\Documentos\DocDedRed\Fornec\EndData;

it('can instantiate EndData', function () {
    $dto = new EndData([]);
    expect($dto)->toBeInstanceOf(EndData::class);
});

