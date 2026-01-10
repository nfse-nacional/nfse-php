<?php

namespace Nfse\Tests\Unit\Dto\NFSe\InfNFSe\DPS\Valores;

use Nfse\Dto\NFSe\InfNFSe\DPS\Valores\TribData;

it('can instantiate TribData', function () {
    $dto = new TribData([]);
    expect($dto)->toBeInstanceOf(TribData::class);
});

