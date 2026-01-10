<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\ValoresData;

it('can instantiate ValoresData via map helper', function () {
    $dto = \map(ValoresData::class, []);
    expect($dto)->toBeInstanceOf(ValoresData::class);
});

