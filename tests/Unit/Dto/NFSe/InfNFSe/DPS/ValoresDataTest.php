<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS;

use Nfse\Dto\NFSe\InfNFSe\DPS\ValoresData;

it('can instantiate ValoresData', function () {
    $dto = new ValoresData([]);
    expect($dto)->toBeInstanceOf(ValoresData::class);
});

