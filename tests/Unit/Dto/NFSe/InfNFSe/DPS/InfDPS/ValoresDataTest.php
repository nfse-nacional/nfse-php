<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\InfDPS;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\ValoresData;

it('can instantiate ValoresData', function () {
    $dto = new ValoresData([]);
    expect($dto)->toBeInstanceOf(ValoresData::class);
});

