<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\Valores\Trib;

use Nfse\Dto\NFSe\InfNFSe\DPS\Valores\Trib\TribMunData;

it('can instantiate TribMunData', function () {
    $dto = new TribMunData([]);
    expect($dto)->toBeInstanceOf(TribMunData::class);
});

