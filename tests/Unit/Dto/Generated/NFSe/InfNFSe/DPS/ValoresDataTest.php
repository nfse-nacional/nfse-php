<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS;

use Nfse\Dto\NFSe\InfNFSe\DPS\ValoresData;

it('can instantiate ValoresData via map helper', function () {
    $dto = \map(ValoresData::class, []);
    expect($dto)->toBeInstanceOf(ValoresData::class);
});

