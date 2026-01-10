<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\Valores;

use Nfse\Dto\NFSe\InfNFSe\DPS\Valores\TribData;

it('can instantiate TribData via map helper', function () {
    $dto = \map(TribData::class, []);
    expect($dto)->toBeInstanceOf(TribData::class);
});

