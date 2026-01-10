<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\InfDPS\Valores;

use Nfse\Dto\NFSe\InfNFSe\DPS\InfDPS\Valores\TribData;

it('can instantiate TribData via map helper', function () {
    $dto = \map(TribData::class, []);
    expect($dto)->toBeInstanceOf(TribData::class);
});

