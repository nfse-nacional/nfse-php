<?php

namespace Nfse\Tests\Unit\Dto\Generated\NFSe\InfNFSe\DPS\Valores\Trib;

use Nfse\Dto\NFSe\InfNFSe\DPS\Valores\Trib\TribMunData;

it('can instantiate TribMunData via map helper', function () {
    $dto = \map(TribMunData::class, []);
    expect($dto)->toBeInstanceOf(TribMunData::class);
});

